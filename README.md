# How to work with library «VKBot.php»?
It requires:
* Server (Hosting) or IDE (DevelNext, DevelStudio, PhpStorm and...)
* PHP 7+
* Group VK
* Knowledge VK.COM and Programming (**Necessarily**)
* And of course.. the Brain!

Example Bot for VK [RU]:
```php
require_once 'VKBot.php'; // connect library

if (!isset($_REQUEST)){ 
    return;
}

$vk = new VKBot; // create an instance
$data = json_decode(file_get_contents('php://input')); 
    
switch ($data->type) { 
case 'confirmation': 
echo $vk->confirmation_token; 
break; 
    
case 'message_new':
$user_id = $data->object->user_id;
$user_info = json_decode(file_get_contents("https://api.vk.com/method/users.get?user_ids={$user_id}&access_token={$vk->token}&v=5.95")); 
$message = $data->object->body;
$user_name = $user_info->response[0]->first_name;

// call functions
if (preg_match("/\AУзнать\s/ui", $message)) $answer = $vk->getID(trim(substr($message, 12)));
elseif (preg_match("/\AДата\s/ui", $message)) $answer = $vk->getRegData(trim(substr($message, 8)));
else $answer = 'Не понятно!';

$vk->request('messages.send',
[
'message' => $answer,
'peer_id' => $user_id,
'random_id' => mt_rand(0, 9223372036854775807),
'access_token' => $vk->token,
'v' => 5.95,
]);
    
echo 'ok'; 
    
break;

default:

echo 'ok';

break;
    
}
```
