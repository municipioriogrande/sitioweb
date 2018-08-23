<?php
require_once( dirname(__FILE__).'/Class.Token.php');

$_token = new Token();
//$_token->setChars(true, true, true, false, '()_:.()_:.()_:.()_:.');
$_token->setChars(true, true, true, false, '');
$_token->setLength(1250, 1250);
$_string = $_token->getToken();
echo $_string;

?>