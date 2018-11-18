<?php

namespace App\Http\Controllers;

use Cookie;
use Ziparchive;
use \Facebook\Facebook;

class FacebookController extends Controller
{
    public function __construct(Facebook $fb)
    {
        $this->fb = $fb;
    }

    public function decision($albumId, $albumName)
    {
        return view('facebook/decision', ['albumId' => $albumId, 'albumName' => $albumName]);
    }

    public function albums()
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function savePhotosToComputer($albumId, $albumName)
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

        $albumPhotos = $response->getGraphList();
        $zip = new ZipArchive;

        $public_dir = public_path();
        $zipFileName = "$albumName.zip";
        $filetopath = $public_dir . '/' . $zipFileName;
        $headers = ['Content-Type' => 'application/octet-stream'];

        if ($zip->open($public_dir . '/' . $zipFileName, ZipArchive::CREATE) === true) {
            foreach ($albumPhotos as $photo) {
                $name = $albumName . time() . '.jpg';
                $url = $photo['source'];
                $contents = file_get_contents($url);

                $zip->addFromString($name, $contents);
            }
            $zip->close();
        }
        if (file_exists($filetopath)) {
            return response()->download($filetopath, $zipFileName, $headers)->deleteFileAfterSend(true);
        }
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
        return redirect('/facebook/albums')->cookie(
            'fb_access_token', $accessToken, 10
        );
    }
}
