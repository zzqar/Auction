<?php
// добавление нового лота 
session_start();
if(  ($_SESSION['user']['group']!= 2 )||(!$_SESSION['user']) ){
    header('Location: /login.php');
    exit();  
}

require_once 'connect.php';
$name_good = $_POST['name_goods'];
$price = filter_var(trim($_POST['price']), FILTER_SANITIZE_NUMBER_INT)*100;
$price_lim = filter_var(trim($_POST['price_lim']), FILTER_SANITIZE_NUMBER_INT)*100;
$date = $_POST['date'];

if( ($_FILES['file']['name']!=='')){
    $file =$_FILES['file'];
    $name = time().$file['name'];
    $path  ='style/images/'.$name;    
    move_uploaded_file($file['tmp_name'],'../'.$path);    
}else{
    $name = 'no_icon.png';
}
$mySQL->query("INSERT INTO `goods` (`name`,`image`,`price`,`price_lim`,`time_end`,`status`) VALUES('$name_good','$name','$price','$price_lim','$date','1') ");
    

header("Location: \auction.php");
?>