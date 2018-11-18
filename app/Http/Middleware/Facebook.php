<?php

namespace App\Http\Middleware;

use Closure;
use Cookie;

class Facebook
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (empty(Cookie::get('fb_has_logged'))) {
            return $this->login();
        }

        if (!empty(Cookie::get('fb_access_token'))) {
            $this->getUserId();
        }

        return $next($request);
    }

    public function login()
    {
        if (!session_id()) {
            session_start();
        }

        $fb = new \Facebook\Facebook([
            'app_id' => env('client_id'),
            'app_secret' => env('client_secret'),
            'default_graph_version' => 'v2.2',
        ]);

        $helper = $fb->getRedirectLoginHelper();
        $permissions = ['user_photos'];
        $loginUrl = $helper->getLoginUrl('https://localhost/facebook/getToken', $permissions);

        $loginUrl = str_replace('amp;', '', htmlspecialchars($loginUrl));

        return redirect()->away($loginUrl)->cookie(
            'fb_has_logged', true, 10
        );
    }

    public function getUserId()
    {
        $access_token = Cookie::get('fb_access_token');

        if (!isset($access_token)) {
            return redirect('/login');
        }

        $fb = new \Facebook\Facebook([
            'app_id' => env('client_id'),
            'app_secret' => env('client_secret'),
            'default_graph_version' => 'v3.2',
        ]);

        try {
            $response = $fb->get('/me?fields=id', $access_token);
        } catch (Facebook\Exceptions\FacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }

        $user = $response->getGraphUser();
        Cookie::queue('fb_user_id', $user['id'], 10);
        return;
    }
}
