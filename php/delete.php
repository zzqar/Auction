<?php
//удаление пользователей 
session_start();
require_once 'connect.php';
$id = $_GET ['id'];
 


if(  ($_SESSION['user']['group']!= 2 )||(!$_SESSION['user']) ){
    header('Location: /login.php');
    exit();
    
}
 
 
 
 $mySQL->query("UPDATE `user` SET `is_deleted`='1',date_del =NOW() WHERE `id` = '$id' ") ;
 header('Location: /user.php');
 $mySQL->close();
 



?>

        