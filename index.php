<?php
//инфа должна быть тут...
session_start();

if(!$_SESSION['user']){
    header('Location: /login.php');
    exit();
}
?>


<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style/css/index.css">
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
                        <a class="nav_link" href="game.php">Game</a>
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
    <div class="intro">
         
    </div>
    <div class="main">
        <div class="contant">
            <div class="contant_name"> ABOUT </div>
                <p>Аукцио́н — публичная продажа товаров, ценных бумаг, имущества предприятий, произведений искусства, и других объектов, которая производится по заранее установленным правилам аукциона. Общим для всех аукционов принципом является принцип состязательности между потенциальными покупателями. </p>
                <p>Раработал Ложков Виктор Алексеевич МОАИС-о-19/1</p>                
        </div>

    </div>
    <pre>
            <?php
            print_r($_SESSION['user'] )
            ?>
        </pre>
    
   
</body>
</html>