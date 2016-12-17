<?php
namespace Denise92\FacebookMessage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class FacebookMessageController extends Controller {
    protected $data = [];
    /**
     * Return Facebook challenge for Webhook
     *
     * @return Response
     */
    public function webhook(Request $request){
        // Verify token
        $hub_verify_token = null;
        $verify_token = config('facebook_message.fb_verify_token');
        // Set this Verify Token Value on your Facebook App 
        if(isset($request->hub_challenge)) {
            $challenge = $request->hub_challenge;
            $hub_verify_token = $request->hub_verify_token;
            if ($hub_verify_token === $verify_token) {
                if(config(app.debug))
                    Log::info('FB Message Challenge: Return challenge '.$challenge);
                return $challenge;
            }
        }
        if(config('app.debug'))
            Log::info('FB Message Challenge: Error, wrong validation token');
        return 'Error, wrong validation token';
    }
    /**
     * Receive message and reply text message
     *
     * @return Response
     */
    public function conversation(Request $request)
    {
        $this->data['app_id'] = config('facebook_message.fb_app_id');
        $this->data['page_id'] = config('facebook_message.fb_page_id');
        $access_token = config('facebook_message.fb_access_token');
        $conversation = config('facebook_message.conversation');
        $default_reply = config('facebook_message.default_reply');
        
        $input = json_decode(file_get_contents('php://input'), true);
        // Get the Senders Graph ID
        $sender = $message = null;
        if(isset($input['entry'][0]['messaging'][0]['sender']['id']))
            $sender = $input['entry'][0]['messaging'][0]['sender']['id'];
        // Get the returned message
        if(isset($input['entry'][0]['messaging'][0]['message']['text']))
            $message = $input['entry'][0]['messaging'][0]['message']['text'];
        if(!$sender || !$message){
            // 不合法的連結，顯示對話按鈕頁面
            return 'Error, empty sender or message.';
        }
        
        //API Url and Access Token, generate this token value on your Facebook App Page
        $url = 'https://graph.facebook.com/v2.6/me/messages?access_token='.$access_token;
        //Initiate cURL.
        $ch = curl_init($url);
        
        //The JSON data.
        $msg = $default_reply;
        Log::info('FB Message BOT->ToMessage1='.$msg);
        foreach ($conversation as $key => $value) {
            if (preg_match("/".$key."/i", $message)) {
                $msg = $value;
                Log::info('FB Message BOT->ToMessage2='.$msg);
                break;;
            }
        }
        $jsonData = '{
            "recipient":{
                "id":"'.$sender.'"  
            }, 
            "message":{
                "text":"'.$msg.'"
            }
        }';
        
        //Encode the array into JSON.
        $jsonDataEncoded = $jsonData;
        
        //Tell cURL that we want to send a POST request.
        curl_setopt($ch, CURLOPT_POST, 1);
        
        //Attach our encoded JSON string to the POST fields.
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
        
        //Set the content type to application/json
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        
        //Execute the request
        $res = curl_exec($ch);
        if(config('app.debug')){
            Log::info('FB Message BOT Log: '.json_encode($input));
            Log::info('FB Message BOT->FromMessage='.$message);
            Log::info('FB Message BOT->ToMessage='.$msg);
            Log::info('FB Message BOT->ReplyResult='.$res);
        }
    }
}