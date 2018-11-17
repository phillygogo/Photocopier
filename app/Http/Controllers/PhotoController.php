<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;

class PhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $file = Storage::disk('public')->get('picco4.jpg');

        return view('/photo/homepage', ['myFile' => $file]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getPhotos()
    {
        $userId = session('fb_user_id');
        /* PHP SDK v5.0.0 */
        $fb = new \Facebook\Facebook([
            'app_id' => env('client_id'),
            'app_secret' => env('client_secret'),
            'default_graph_version' => 'v3.2',
        ]);
        /* make the API call */
        try {
            // Returns a `Facebook\FacebookResponse` object
            $response = $fb->get(
                "/{$userId}/photos?fields=source",
                session('fb_access_token')
            );
        } catch (Facebook\Exceptions\FacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }
        $graphEdge = $response->getGraphList();
        $count = 0;

        foreach ($graphEdge as $graphNode) {
            $url = $graphNode['source'];
            $contents = file_get_contents($url);
            $name = "picco{$count}.jpg";
            \Storage::disk('public')->put($name, $contents);
            $count++;
        }
        return redirect('/');
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
