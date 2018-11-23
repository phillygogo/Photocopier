<?php

namespace App\Http\Controllers;

use Cookie;
use Google_Client;
use Google_Service_Drive;

class GoogleDriveController extends Controller
{
    public function __construct(Google_Client $client)
    {
        $this->client = $client;
    }

    public function index()
    {
        $google_access_token = Cookie::get('google_access_token');

        if (!isset($google_access_token)) {
            $authUrl = $this->client->createAuthUrl();
            return redirect()->away($authUrl);
        } else {
            $this->client->setAccessToken($google_access_token);
        }

        $service = new Google_Service_Drive($this->client);
        $this->getfiles($service);
        dd('stop');
    }
    /**
     * Returns an authorized API client.
     * @return Google_Client the authorized client object
     */
    public function getAccessToken()
    {
        // If there is no previous token or it's expired.
        if ($this->client->isAccessTokenExpired()) {
            // Refresh the token if possible, else fetch a new one.
            if ($this->client->getRefreshToken()) {
                $this->client->fetchAccessTokenWithRefreshToken($this->client->getRefreshToken());
            } else {
                // Exchange authorization code for an access token.
                $authCode = $_GET['code'];
                $accessToken = $this->client->fetchAccessTokenWithAuthCode($authCode);
                $this->client->setAccessToken($accessToken);

                // Check to see if there was an error.
                if (array_key_exists('error', $accessToken)) {
                    throw new Exception(join(', ', $accessToken));
                }
            }
        }
        return redirect('/googleDrive')->cookie(
            'google_access_token', $accessToken, 10
        );
    }

    public function getfiles($service)
    {
        // Print the names and IDs for up to 20 files.
        $optParams = array(
            'pageSize' => 20,
            'fields' => 'nextPageToken, files(id, name)',
        );
        $results = $service->files->listFiles($optParams);

        dd($results);

        if (count($results->getFiles()) == 0) {
            var_dump("No files found.\n");
            return false;
        } else {
            foreach ($results->getFiles() as $file) {
                var_dump("%s (%s)\n", $file->getName(), $file->getId());
            }
        }
        return true;
    }

}
