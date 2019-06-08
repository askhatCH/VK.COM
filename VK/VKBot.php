<?php
class VKBot
{
    public $token = ''; // access_token
    public $confirmation_token = '';
    public function request(string $method, array $options) // sends request
    {
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => 'https://api.vk.com/method/'.$method.'?'.http_build_query($options),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false
        ]);
        curl_exec($ch);
        curl_close($ch);
    }
    public function getID(string $url) // gets user ID
    {
        $url_id = trim(substr($url, 15));
        $get_id = json_decode( file_get_contents('https://api.vk.com/method/utils.resolveScreenName?screen_name='.$url_id.'&access_token='.$this->token.'&v=5.95') );
        if (is_numeric($get_id->response->object_id)) return $get_id->response->object_id;
        else return 'Error';
    }
}
