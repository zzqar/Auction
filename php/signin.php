<?php
//авторизация
session_start();
require_once 'connect.php';
$login = filter_var(trim($_POST['login']), FILTER_SANITIZE_STRING);

$result = $mySQL->query("SELECT * FROM `user` WHERE `login` = '$login' ")->fetch_assoc();
$mySQL->close();

$psw = md5(filter_var(trim($_POST['psw']), FILTER_SANITIZE_STRING).("NoaNaoki"));

 
if(count($result) == 0){
    $_SESSION ['message'] = 'Пользователь не существует';
    header('Location: /login.php');
    exit();
}


if($psw != $result['password']){
    $_SESSION ['message'] = 'Пароль введен не верно';
    header('Location: /login.php');
    exit();
}

$_SESSION ['user'] = [
    "id" => $result['id'],
    "name" => $result['name'],
    "group" => $result['group'],
    "login" => $result['login'],
    "id_bills" => $result['id_bills']
];

 

 
header('Location: /index.php');

