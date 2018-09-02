<?php

include_once '../../Objetos/Usuario.php';
include_once '../../config/Database.php';
include_once '../../config/AuthJson.php';

$token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6IjkiLCJjcmVhdGVkIjoxNTM1ODU3MjM4LCJleHBpcmF0aW9uIjoxNTM1OTQzNjM4fQ.xsEICGs1MOuIp2lOf_xiffBi-EzZ2LzKq-DLVo3y_fs';
$my_token = new Token() ;
echo "ok" ;
$my_token->decoding_key($token) ;



?>
