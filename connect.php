<?php
$isql=@new mysqli('localhost','username','password','database');

if ($isql->connect_error) {
    die('Connect Error (' . $isql->connect_errno . ') '
        . $isql->connect_error);
}

$result=$isql->query("set names 'utf8'");//设置编码为utf8
$record=array(20);