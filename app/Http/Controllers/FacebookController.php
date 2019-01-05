<?php

namespace App\Http\Controllers;

use Cookie;
use Google_Client;
use Google_Service_Drive;
use Google_Service_Drive_DriveFile;
use Ziparchive;
use \Facebook\Facebook;

class FacebookController extends Controller
{
    public function __construct(Facebook $fb, Google_Client $client)
    {
        $this->fb = $fb;
        $this->client = $client;

        $this->decisions = ['computer' => 'Your Computer', 'googleDrive' => 'Google Drive'];
    }

    public function savePhotos($decision)
    {
        if ($decision === 'googleDrive') {
            return $this->savePhotosGoogleDrive();
        } else {
            $decided = 'computer';
            return $this->savePhotosToComputer();
        }

        return view('facebook/decided', ['decisions' => $this->decisions, 'decided' => $decided]);
    }

    public function decision($albumId, $albumName)
    {
        session(['albumId' => $albumId, 'albumName' => $albumName]);

        return view('facebook/decision', ['decisions' => $this->decisions]);
    }

    /**
     * this function is used to save Photos to the .
     *
     * @return \Illuminate\Http\Response
     */
    public function savePhotosGoogleDrive()
    {
        $session = session()->all();

        $albumPhotos = $this->getAlbumPhotos($session['albumId']);

        $google_access_token = Cookie::get('google_access_token');

        if (!isset($google_access_token)) {
            $authUrl = $this->client->createAuthUrl();
            return redirect()->away($authUrl);
        } else {
            $this->client->setAccessToken($google_access_token);
        }

        $name = 'Facebook_' . $session['albumName'];

        //Creating the folder to save the file too
        $service = new Google_Service_Drive($this->client);
        $fileMetadata = new Google_Service_Drive_DriveFile(array(
            'name' => $name,
            'mimeType' => 'application/vnd.google-apps.folder'));

        //Return the folder
        $folder = $service->files->create($fileMetadata, array(
            'fields' => 'id'));

        foreach ($albumPhotos as $photo) {
            $url = $photo['source'];
            $photoName = $session['albumName'] . time() . '.jpg';
            $contents = file_get_contents($url);

            $fileMetadata = new Google_Service_Drive_DriveFile(array(
                'name' => $photoName,
                'parents' => array($folder->id),
            ));

            $service->files->create($fileMetadata, array(
                'data' => $contents,
                'mimeType' => 'image/jpeg',
                'uploadType' => 'multipart',
                'fields' => 'id'));
        }
        return view('facebook/decided', ['decisions' => $this->decisions, 'decided' => 'googleDrive']);
    }

    /**
     * Returns an authorized API client.
     * @return Google_Client the authorized client object
     */
    public function getGoogleAccessToken()
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
        return redirect('/facebook/savePhotosGoogleDrive')->cookie(
            'google_access_token', $accessToken, 10
        );
    }

    /**
     * this function is used to save Photos to the .
     *
     * @return \Illuminate\Http\Response
     */
    public function savePhotosToComputer()
    {
        $session = session()->all();
        $albumPhotos = $this->getAlbumPhotos($session['albumId']);

        $zip = new ZipArchive;

        $public_dir = public_path();
        $zipFileName = $session['albumName'] . ".zip";
        $pathToFile = $public_dir . '/' . $zipFileName;
        $headers = ['Content-Type' => 'application/octet-stream'];

        if ($zip->open($pathToFile, ZipArchive::CREATE) === true) {
            foreach ($albumPhotos as $photo) {
                $name = $session['albumName'] . time() . '.jpg';
                $url = $photo['source'];
                $contents = file_get_contents($url);

                $zip->addFromString($name, $contents);
            }
            $zip->close();
        }
        if (file_exists($pathToFile)) {
            return response()->download($pathToFile, $zipFileName, $headers)->deleteFileAfterSend(true);
        }

    }

    /**
     * fetches all the albums for a Facebook user
     *
     * @return \Illuminate\Http\Response
     */
    public function getAlbums()
    {
        $userId = Cookie::get('fb_user_id');
        $access_token = Cookie::get('fb_access_token');
        /* make the API call */
        try {
            $response = $this->fb->get(
                "/{$userId}/albums",
                $access_token
            );

        } catch (Facebook\Exceptions\FacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }

        $data = $response->getGraphList();

        return view('facebook/albums', ['PhotoAlbums' => $data]);
    }

    /**
     * fetches all the photos for a specific facebook album
     *
     * @return \Illuminate\Http\Response
     */
    public function getAlbumPhotos($albumId)
    {
        $userId = Cookie::get('fb_user_id');
        $access_token = Cookie::get('fb_access_token');

        /* make the API call */
        try {
            $response = $this->fb->get(
                "/$albumId/photos?fields=id,source",
                $access_token
            );
        } catch (Facebook\Exceptions\FacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }

        return $response->getGraphList();

    }

    public function getToken()
    {
        $helper = $this->fb->getRedirectLoginHelper();
        $_SESSION['FBRLH_state'] = $_GET['state'];
        try {
            $accessToken = $helper->getAccessToken();
        } catch (Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }
        if (!isset($accessToken)) {
            if ($helper->getError()) {
                header('HTTP/1.0 401 Unauthorized');
                echo "Error: " . $helper->getError() . "\n";
                echo "Error Code: " . $helper->getErrorCode() . "\n";
                echo "Error Reason: " . $helper->getErrorReason() . "\n";
                echo "Error Description: " . $helper->getErrorDescription() . "\n";
            } else {
                header('HTTP/1.0 400 Bad Request');
                echo 'Bad request';
            }
            exit;
        }

        $oAuth2Client = $this->fb->getOAuth2Client();
        $tokenMetadata = $oAuth2Client->debugToken($accessToken);

        // Validation (these will throw FacebookSDKException's when they fail)
        $tokenMetadata->validateAppId(env('client_id'));
        $tokenMetadata->validateExpiration();

        if (!$accessToken->isLongLived()) {
            // Exchanges a short-lived access token for a long-lived one
            try {
                $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
            } catch (Facebook\Exceptions\FacebookSDKException $e) {
                echo "<p>Error getting long-lived access token: " . $e->getMessage() . "</p>\n\n";
                exit;
            }
        }
        return redirect('/facebook/getAlbums')->cookie(
            'fb_access_token', $accessToken, 10
        );
    }
}
