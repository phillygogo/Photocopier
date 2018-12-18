<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;


class InstagramController extends Controller
{
    public function __construct(Client $client) {
        $this->client = $client;
    }
    
    public function index() {
        $clientId = env('instagram_client_id');
        return redirect()->away("https://api.instagram.com/oauth/authorize/?client_id={$clientId}&redirect_uri=https://ephotocopier.com/instagram/callback&response_type=code");
    }

    public function callback(Request $request) {
        // $client = new Client(["base_uri" => "https://api.instagram.com"]);
        
        $response = $this->client->request("POST", "/oauth/access_token", [
            "form_params" => [
                    'client_id' => env('instagram_client_id'),
                    'client_secret' => env('instagram_client_secret'),
                    'grant_type' => 'authorization_code',
                    'redirect_uri' => 'https://ephotocopier.com/instagram/callback',
                    'code' => $request->code,
                ]
            ]);
        
        $instaUser = json_decode($response->getbody());
        
        $accessToken = $instaUser->access_token;

        $media = $this->getRecentMedia($accessToken);

    }

    public function getRecentMedia($accessToken) 
    {
        $response = $this->client->request("GET", "/v1/users/self", [
            "query" => [
                'access_token' => $accessToken
            ],
        ]);

        dd(json_decode($response->getBody()));

        dd(json_decode($response));

    }

}
