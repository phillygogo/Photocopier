<?php

namespace App\Http\Controllers;

use Google_Client;
use Google_Service_Drive;

class GoogleDriveController extends Controller
{
    //
    public function index()
    {
        $client = new Google_Client();

        // $client->setAuthConfig('credentials.json');
        $client->setClientId(env("googleDrive_client_id"));
        $client->setClientSecret(env("googleDrive_client_id"));
        $client->setScopes("https://www.googleapis.com/auth/drive");
        $client->setRedirectUri(env("googleDrive_redirect_url"));

//

        $authUrl = $client->createAuthUrl();

        return redirect()->away($authUrl)->cookie(
            'google_has_logged', true, 10
        );

        dd('stop');
        // Get the API client and construct the service object.
        // $client = $this->getClient();
        $service = new Google_Service_Drive($client);

    }
    /**
     * Returns an authorized API client.
     * @return Google_Client the authorized client object
     */
    public function getAccessToken()
    {

        $client = new Google_Client();

        // $client->setAuthConfig('credentials.json');
        $client->setClientId(env("googleDrive_client_id"));
        $client->setClientSecret(env("googleDrive_client_id"));
        $client->setScopes("https://www.googleapis.com/auth/drive");
        $client->setRedirectUri(env("googleDrive_redirect_url"));
        $client->setAccessType('offline');

        // Load previously authorized token from a file, if it exists.
        // The file token.json stores the user's access and refresh tokens, and is
        // created automatically when the authorization flow completes for the first
        // time.
        $tokenPath = 'token.json';
        if (file_exists($tokenPath)) {
            $accessToken = json_decode(file_get_contents($tokenPath), true);
            $client->setAccessToken($accessToken);
        }

        // If there is no previous token or it's expired.
        if ($client->isAccessTokenExpired()) {

            // Refresh the token if possible, else fetch a new one.
            if ($client->getRefreshToken()) {
                $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
            } else {

                $authCode = $_GET['code'];

                // Exchange authorization code for an access token.
                $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);

                var_dump($accessToken);

                $client->setAccessToken($accessToken);

                // Check to see if there was an error.
                if (array_key_exists('error', $accessToken)) {
                    throw new Exception(join(', ', $accessToken));
                }
            }
            // Save the token to a file.
            // if (!file_exists(dirname($tokenPath))) {
            //     mkdir(dirname($tokenPath), 0700, true);
            // }
            // file_put_contents($tokenPath, json_encode($client->getAccessToken()));
        }
        dd($client);

        return $client;
    }

    public function redirectAwayforAuth($client)
    {

    }

    public function getfiles($service)
    {
        // Print the names and IDs for up to 20 files.
        $optParams = array(
            'pageSize' => 20,
            'fields' => 'nextPageToken, files(id, name)',
        );
        $results = $service->files->listFiles($optParams);

        if (count($results->getFiles()) == 0) {
            print "No files found.\n";
        } else {
            print "Files:\n";
            foreach ($results->getFiles() as $file) {
                printf("%s (%s)\n", $file->getName(), $file->getId());
            }
        }
    }

}
