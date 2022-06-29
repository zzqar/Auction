<?php
session_start();
require_once 'connect.php';
$login = filter_var(trim($_POST['login']), FILTER_SANITIZE_STRING);

$result = $mySQL->query("SELECT * FROM `user` WHERE `login` = '$login' ")->fetch_assoc();
if(count($result) != 0){
    $_SESSION ['message'] = 'Пользователь с таким логином существует';
    header('Location: /registr.php');
    exit();
}


//$email = filter_var(trim($_POST['email']), FILTER_SANITIZE_STRING);
 
$psw = filter_var(trim($_POST['psw']), FILTER_SANITIZE_STRING);
$name = filter_var(trim($_POST['name']), FILTER_SANITIZE_STRING);
 
if($login == "zzqar") {
     $group = '2';
    }else {
        $group = '0';
    };

$psw_repeat = filter_var(trim($_POST['psw-repeat']), FILTER_SANITIZE_STRING);
if (mb_strlen($login) < 5 || mb_strlen($login) > 20 ) {

    $_SESSION ['message'] = 'Недопустимая длина логина';
    header('Location: /registr.php');
   exit();

}elseif (mb_strlen($psw) < 5 || mb_strlen($psw) > 10 ) {

    $_SESSION ['message'] = 'Недопустимая длина пароля  5 - 10 символов';
    header('Location: /registr.php');
    exit();

}elseif ($psw != $psw_repeat ) {
    $_SESSION ['message'] = 'Пароли не совпадают';
    header('Location: /registr.php');
    exit();
}
$psw = md5($psw.("adas23dawk231"));

$mySQL->query("INSERT INTO `user`(`login`, `password`, `name`, `group`) VALUES ('$login', '$psw', '$name', '$group')");
$mySQL->query("INSERT INTO `bills` (`amount`) VALUES ('100000')");
$mySQL->close();

$_SESSION ['message'] = 'Регистрация прошла успешно!';
 
header('Location: /login.php');
?>
