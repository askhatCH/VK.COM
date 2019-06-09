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
    public function getRegData(int $user_id) // gets registration date of user
    {
        if(!is_numeric($user_id)) return 'Error';
		else{
		$xml = file_get_contents("https://vk.com/foaf.php?id={$user_id}");
        preg_match("#<ya:created dc:date=\"(.+?)\"/>#", $xml, $getRegData);
		$regData = substr(trim($getRegData[1]), 0, -15);
		$userDataTime = substr(trim($getRegData[1]), 10, -12);
		$userDataDay = substr(str_replace('-', '.', $getRegData[1]), 8);
        if ($userDataTime == 'T23' || $userDataTime == 'T22' || $userDataTime == 'T21' ) $userDataDay += 1;
        $userDataMonth = substr(str_replace('-', '.', $getRegData[1]), 5, -18);
        $userDataYear = substr(str_replace('-', '.', $getRegData[1]), 0, -21);
		return $userDataDay.'.'.$userDataMonth.'.'.$userDataYear;
		}
    }
}
