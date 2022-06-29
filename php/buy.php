<?php
session_start();
if(!$_SESSION['user']){
    header('Location: /login.php');
    exit();
}


 
require_once 'connect.php';

$id_goods = filter_var(trim($_POST['id_goods']), FILTER_SANITIZE_STRING);
$id_user = $_SESSION['user']['id'];
$amount_pay = filter_var(trim($_POST['sum']), FILTER_SANITIZE_NUMBER_INT)*100;

$bill = $mySQL->query("SELECT * FROM `bills` WHERE `id_bills`= '$id_user'  ")->fetch_assoc(); ;
$user_bill = $bill['amount'];
$user_bill_vir = $bill['amount_vir'];

$now = date("Y-m-d H:i:s"); // текущее время (метка времени)


$result = $mySQL->query("SELECT * FROM `goods` WHERE `id`= '$id_goods' AND `time_end`> '$now' ")->fetch_assoc();
$goods = $mySQL->query("SELECT MAX(`total_sum`) as `max_am` FROM `transaction` WHERE `id_goods`= '$id_goods' GROUP BY `id_goods` ")->fetch_assoc();

$MyGoods = $mySQL->query("SELECT MAX(`total_sum`) as `max_am` FROM `transaction` WHERE `id_goods`= '$id_goods' and `id_user`= '$id_user' GROUP BY `id_goods` ")->fetch_assoc();
$raznica_pay = $amount_pay-$MyGoods['max_am'];

if( $goods['max_am']===NULL ){
    $status = 1;
     
}else{
  
    $status = 2;
     
}

if($result['status']!='1'){
 
    $_SESSION ['message_good'] = 'Лот выкуплен или время размешения истекло';
    
    header('Location: /good.php?id='.$id_goods); 
    exit();
}elseif($user_bill < ($user_bill_vir + $raznica_pay )){
    //проверка возможность оплаты 
    $_SESSION ['message_good'] = 'Не жостатоно средств ';
    
    header('Location: /good.php?id='.$id_goods); 
    exit();
}elseif($amount_pay<=$goods['max_am'] ){
    //проверка на наличие такой же ставки и выше 
    $_SESSION ['message_good'] = 'Найдена превосходящяя ставка  ';
    
    header('Location: /good.php?id='.$id_goods); 
    exit();
}


 
$mySQL->query("INSERT INTO `transaction` (`id_user`,`id_goods`,`amount`,`total_sum`,`date`,`status`) VALUES('$id_user','$id_goods','$raznica_pay','$amount_pay','$now','$status') ");
$mySQL->query("UPDATE `bills` SET `amount_vir`= `amount_vir`+'$raznica_pay' WHERE `id_bills` = '$id_user' ");

//  платеж равен предельной стоимости 
if ($result['price_lim'] == $amount_pay){
    // меняю статус товара на куплен и присвиваю id покупателя
    $mySQL->query("UPDATE `goods` SET `status` = '3', `user_buy` = '$id_user' WHERE `id`= '$id_goods' ");
    //вычитаю cумму платежа из счета пользователя 
    $mySQL->query("UPDATE `bills` SET `amount` = `amount` - '$amount_pay' WHERE `id_bills` = '$id_user' ");
    //возврашяю виртуальные средства всем кто учавствовал в лоте 
    $mySQL->query("UPDATE `bills` SET `amount_vir` = `amount_vir` - ( SELECT SUM( `amount` ) AS `sum` FROM `transaction` AS `ts` WHERE `ts`.`id_goods` = '$id_goods' AND `bills`.`id_bills` = `ts`.`id_user` GROUP BY `ts`.`id_user` ) WHERE `id_bills` = ( SELECT `id_user` FROM `transaction` AS `ts` WHERE `ts`.`id_goods` = '$id_goods' AND `bills`.`id_bills` = `ts`.`id_user` GROUP BY `ts`.`id_user`) ");
}

$mySQL->close();  
header('Location: /good.php?id='.$id_goods);  
?>

