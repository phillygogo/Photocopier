<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('/photo/homepage');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function authenticate()
    {

        $fb = new \Facebook\Facebook([
            'app_id' => env('client_id'), // Replace {app-id} with your app id
            'app_secret' =>  env('client_secret'),
            'default_graph_version' => 'v2.2',
            ]);
          
          $helper = $fb->getRedirectLoginHelper();
          
          $permissions = ['email']; // Optional permissions
          $loginUrl = $helper->getLoginUrl('https://localhost/fb-callback.php', $permissions);
          
        //   echo '<a href="' . htmlspecialchars($loginUrl) . '">Log in with Facebook!</a>';
        // $fb = new \Facebook\Facebook([
        //     'app_id' => env('client_id'),
        //     'app_secret' => env('client_secret'),
        //     'default_graph_version' => 'v2.2',
        // ]);

        // $helper = $fb->getCanvasHelper();

        // try {
        //     $accessToken = $helper->getAccessToken();
        // } catch (Facebook\Exceptions\FacebookResponseException $e) {
        //     // When Graph returns an error
        //     echo 'Graph returned an error: ' . $e->getMessage();
        //     exit;
        // } catch (Facebook\Exceptions\FacebookSDKException $e) {
        //     // When validation fails or other local issues
        //     echo 'Facebook SDK returned an error: ' . $e->getMessage();
        //     exit;
        // }

        // if (!isset($accessToken)) {
        //     echo 'No OAuth data could be obtained from the signed request. User has not authorized your app yet.';
        //     exit;
        // }

        // // Logged in
        // echo '<h3>Signed Request</h3>';
        // var_dump($helper->getSignedRequest());

        // echo '<h3>Access Token</h3>';
        // var_dump($accessToken->getValue());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
