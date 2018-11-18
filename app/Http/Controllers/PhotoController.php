<?php

namespace App\Http\Controllers;

use Cookie;
use Illuminate\Http\Request;
use Storage;
use ZipArchive;

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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function savePhotosToComputer()
    {
        $userId = Cookie::get('fb_user_id');
        $access_token = Cookie::get('fb_access_token');

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
                $access_token
            );
        } catch (Facebook\Exceptions\FacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }

        $graphEdge = $response->getGraphList();

        $zip = new ZipArchive;

        $public_dir = public_path();
        $zipFileName = 'facebookPhotos.zip';
        $filetopath = $public_dir . '/' . $zipFileName;
        $headers = ['Content-Type' => 'application/octet-stream'];

        if ($zip->open($public_dir . '/' . $zipFileName, ZipArchive::CREATE) === true) {
            foreach ($graphEdge as $graphNode) {
                $name = 'facebook ' . time() . '.jpg';
                $url = $graphNode['source'];
                $contents = file_get_contents($url);

                $zip->addFromString($name, $contents);
            }
            $zip->close();
        }
        if (file_exists($filetopath)) {
            return response()->download($filetopath, $zipFileName, $headers)->deleteFileAfterSend(true);
        }

        return view('/photo/homepage');
    }

/**
 *
 *  THE DOWNLOAD DOESNT WORK PUTTING INTO A FUNCTION> WILL SORT THIS OUT LATER
 *
 */

    // public function download($graphEdge)
    // {

    //     $zip = new ZipArchive;

    //     $public_dir = public_path();
    //     $zipFileName = 'facebookPhotos.zip';
    //     $filetopath = $public_dir . '/' . $zipFileName;
    //     $headers = ['Content-Type' => 'application/octet-stream'];

    //     if ($zip->open($public_dir . '/' . $zipFileName, ZipArchive::CREATE) === true) {
    //         foreach ($graphEdge as $graphNode) {
    //             $name = 'facebook ' . time() . '.jpg';
    //             $url = $graphNode['source'];
    //             $contents = file_get_contents($url);

    //             $zip->addFromString($name, $contents);
    //         }
    //         // Close ZipArchive
    //         $zip->close();
    //     }
    //     if (file_exists($filetopath)) {
    //         return response()->download($filetopath, $zipFileName, $headers)->deleteFileAfterSend(true);
    //     }

    //     return redirect('/');
    // }
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
