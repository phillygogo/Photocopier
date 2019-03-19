<?php

namespace App\Http\Middleware;

use Closure;
use Cookie;
use Response;
use \Facebook\Facebook;

class FacebookMiddleware
{
    public function __construct(Facebook $fb)
    {
        $this->fb = $fb;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (empty(Cookie::get('fb_has_logged')) || empty(Cookie::get('fb_access_token'))) {
            return $this->login();
        }

        if (is_null(Cookie::get('fb_user_id'))) {
            $this->getUserId();
        }

        return $next($request);
    }

    public function login()
    {
        $helper = $this->fb->getRedirectLoginHelper();
        $data = ['scope' => 'user_photos'];
        $loginUrl = $helper->getLoginUrl('https://ephotocopier.com/facebook/getToken', $data);

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

        try {
            $response = $this->fb->get('/me?fields=id', $access_token);
        } catch (Facebook\Exceptions\FacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }

        $user = $response->getGraphUser();
        Cookie::queue('fb_user_id', $user['id'], 10);
        return Response::make();
    }

}
