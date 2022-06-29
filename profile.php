<?php
//Профиль пользователя 
session_start();

if(!$_SESSION['user']){
    header('Location: /login.php');
    exit();
}

require_once 'php/connect.php';
$bills = $_SESSION['user']['id_bills'];
$result = $mySQL->query("SELECT * FROM `bills` WHERE `id_bills` = '$bills' ")->fetch_assoc();
$mySQL->close();
?>


<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style/css/index.css">
    <link rel="stylesheet" href="style/css/profile.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">    
    <title>Аукцион by zzqar</title>
</head>
<body>
    <header class="header">
        <div class="container">
            <div class="header_inner">
                 <div class="header_logo">  Auction </div>
                    <nav class="nav">
                        <a class="nav_link" href="index.php">about</a>
                        <a class="nav_link" href="auction.php">Аукцион</a>
                        <?php if ($_SESSION['user']['group']==2):?> 
                        <a class="nav_link" href="user.php">users</a>
                        <?php endif; ?>
                        <?php if (count($_SESSION['user']) != '' ): ?>
                        <a class="nav_link" href="profile.php"><?=$_SESSION['user']['name']?></a>
                        <a class="nav_link" href="php/logout.php">Выйти</a>
                        <?php endif; ?>

                    </nav>
                      
            </div>

        </div>
    </header>
    
    <div class="profil">
        <div class="contant">
            <div class="product-photo">
                <img src="style/images/no_icon.png" alt="">
            </div> 
            <div class="inf_cont">
                <div class="contant_name"> <?=$_SESSION['user']['name']?> </div>  
                <div class="prof_inf">
                    <p class="">Login: </p>
                    <p><?=$_SESSION['user']['login']?></p>
                </div>
                <div class="prof_inf">
                    <p class="">Номер телефона: </p>
                    <p>-</p>
                </div>
                <div class="prof_inf">
                    <p class="">email: </p>
                    <p>-</p>
                </div>
                <div class="prof_inf">
                    <p class="">Баланс: </p>
                    <p><?=$result['amount']/100-$result['amount_vir']/100?>/<?=$result['amount']/100?> руб</p>
                </div>
                <div class="prof_inf">
                    <p class="">Купленно товаров: </p>
                    <p>-</p>
                </div>            
            </div>                  
            
            
        </div>

    </div>
 
    
   
</body>
</html>