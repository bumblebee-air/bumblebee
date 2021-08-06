<?php

namespace App\Http\Controllers;

use App\UserToken;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Validator;

class ZoomController extends Controller
{
    public function getAuthenticateZoom(){
        $auth_redirect_uri = url('zoom-oauth-redirect');
        $zoom_oauth_client_id = env('ZOOM_OAUth_CLIENT_ID');
        if(!$zoom_oauth_client_id){
            die('ZOOM is not configured properly, please contact the administration');
        }
        $auth_url = 'https://zoom.us/oauth/authorize?response_type=code&client_id='.$zoom_oauth_client_id.'&redirect_uri='.$auth_redirect_uri;
        return redirect()->intended($auth_url);
    }

    public function authenticateZoomRedirect(Request $request){
        $current_user = \Auth::user();
        if(!$current_user){
            die('You are not logged into the platform');
        }
        if(!$request->get('code')){
            dd($request->all());
        }
        $zoom_code = $request->get('code');
        $zoom_oauth_client_id = env('ZOOM_OAUth_CLIENT_ID');
        $zoom_oauth_client_secret = env('ZOOM_OAUth_CLIENT_SECRET');
        if(!$zoom_oauth_client_id || !$zoom_oauth_client_secret){
            die('ZOOM is not configured properly, please contact the administration');
        }
        $guzzle_client = new \GuzzleHttp\Client();
        $zoom_auth_header = base64_encode($zoom_oauth_client_id.':'.$zoom_oauth_client_secret);
        $token_request = $guzzle_client->request('POST', 'https://zoom.us/oauth/token', [
            'headers' => [
                'Authorization' => 'Basic ' . $zoom_auth_header,
            ],
            'form_params' => [
                'grant_type'=> 'authorization_code',
                'code' => $zoom_code,
                'redirect_uri' => url('zoom-oauth-redirect')
            ]
        ]);
        $response = $token_request->getBody()->getContents();
        $response = json_decode($response);
        //dd($response);
        $user_tokens = UserToken::where('user_id',$current_user->id)->first();
        if(!$user_tokens){
            $user_tokens = new UserToken();
            $user_tokens->user_id = $current_user->id;
        }
        $user_tokens->zoom_api = $response->access_token;
        $user_tokens->save();
        die('You are signed in successfully with Zoom, you can close this tab now');
    }

    public function testZoomApi(){
        $current_user = \Auth::user();
        if(!$current_user){
            return json_encode(['error_code'=>401, 'error_message'=>'Not signed in']);
        }
        $user_tokens = UserToken::where('user_id',$current_user->id)->first();
        if(!$user_tokens || $user_tokens->zoom_api==null){
            return json_encode(['error_code'=>401, 'error_message'=>'No user tokens yet']);
        }
        $access_token = $user_tokens->zoom_api;
        $guzzle_client = new \GuzzleHttp\Client();
        try {
            $token_request = $guzzle_client->request('GET', 'https://api.zoom.us/v2/users/me/meetings', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $access_token,
                ],
            ]);
        } catch (GuzzleException $e) {
            return json_encode(['error_code'=>$e->getCode(), 'error_message'=>$e->getMessage()]);
        }
        /*$token_request = $guzzle_client->request('POST', 'https://api.zoom.us/v2/users/me/meetings', [
            'headers' => [
                'Authorization' => 'Bearer ' . $access_token,
            ],
            'json' => [
                "topic"=> "Test meeting from the API",
                "type"=> 2,
                "start_time"=> "2021-07-02T09:00:00Z",
                "duration"=> 120,
                //"timezone": "string",
                //"password": "string",
            ]
        ]);*/
        $response = $token_request->getBody()->getContents();
        //dd(json_decode($response));
        return json_encode(['error_code'=>null, 'message'=>json_encode($response)]);
    }
}
