<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Ziparchive;

class InstagramController extends Controller
{
    public function __construct()
    {
        $this->chony = '';
    }

    public function index(Request $request)
    {
        // $accessToken = $request->input('access_token');
        $url = $request->fullUrl();
        // $url = $request->fullUrl();
        dd($url . 'inside index should have access token in URL');
    }

    public function authorizeUser()
    {
        return redirect('https://api.instagram.com/oauth/authorize?client_id=2be11b37c43e4992a0dd20c9f34025d9&redirect_uri=https://ephotocopier.com/callback&response_type=code');
    }

    public function callback(Request $request)
    {
        $client = new Client([
            'base_uri' => 'https://api.instagram.com',
        ]);

        $response = $client->post(
            '/oauth/access_token',
            [
                'form_params' => [
                    'Content-Type' => 'application/json',
                    'client_id' => '2be11b37c43e4992a0dd20c9f34025d9',
                    'client_secret' => 'a8ac07c7be734504a3a22ee95f5b3888',
                    'grant_type' => 'authorization_code',
                    'redirect_uri' => 'https://ephotocopier.com/callback',
                    'code' => $request->input('code')],
            ]
        );

        // $code = $request->input('code');
        // return redirect("https://api.instagram.com/oauth/authorize?client_id=981c45ab41b949d39543b35dcc96096b&client_secret=a8ac07c7be734504a3a22ee95f5b3888&grant_type={$code}&redirect_uri=https://ephotocopier.com/instagram?&response_type=token");

        $data = json_decode($response->getBody());

        $response = $client->get(
            '/v1/users/self/media/recent',
            [
                'query' => ['access_token' => $data->access_token],
            ]

        );

        $response = json_decode($response->getBody());

        return $this->savePhotosToComputer($response);

    }

    /**
     * this function is used to save Photos to the .
     *
     * @return \Illuminate\Http\Response
     */
    public function savePhotosToComputer($data)
    {
        $zip = new ZipArchive;

        $public_dir = public_path();
        $zipFileName = "InstagramImages.zip";
        $pathToFile = $public_dir . '/' . $zipFileName;
        $headers = ['Content-Type' => 'application/octet-stream'];

        if ($zip->open($pathToFile, ZipArchive::CREATE) === true) {
            foreach ($data->data as $imageObject) {
                $name = 'instagramImages' . time() . '.jpg';
                $contents = file_get_contents($imageObject->images->standard_resolution->url);

                $zip->addFromString($name, $contents);

            }
        }
        $zip->close();
        if (file_exists($pathToFile)) {
            return response()->download($pathToFile, $zipFileName, $headers)->deleteFileAfterSend(true);
        }

    }
}
