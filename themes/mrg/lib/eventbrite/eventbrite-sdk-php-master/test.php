<?php


require_once('HttpClient.php');


$client = new HttpClient('NA323OU6DZOHFY32DXOE');
$user = $client->get('/users/me/');

//echo  $user['id'];
//print_r($user);
/*
$events = $client->get('/events/search/');
print_r($events);
*/
$arguments = array('order_by'=>'created_asc');

$client->setArguments($arguments);
$my_events = $client->get_user_owned_events($user['id'], $expand=array());


print_r($my_events);
//user.id
//get_user_owned_events
?>