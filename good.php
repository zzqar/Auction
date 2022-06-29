<?php
session_start();

$id = $_GET ['id'];
if(!$id){
    header('Location: /auction.php');  
    exit();
}
require_once 'php/connect.php';
$result = $mySQL->query("SELECT * FROM `goods` WHERE `id`= '$id' ")->fetch_assoc();
if(!$_SESSION['user']){
    header('Location: /login.php');
    exit();
}
$id_user = $_SESSION['user']['id'];
$goods = $mySQL->query("SELECT MAX(`total_sum`) as `max_am` FROM `transaction` WHERE `id_goods`= '$id' GROUP BY `id_goods` ")->fetch_assoc();
$MyGoods = $mySQL->query("SELECT MAX(`total_sum`) as `max_am` FROM `transaction` WHERE `id_goods`= '$id' and `id_user`= '$id_user' GROUP BY `id_goods` ")->fetch_assoc();


if( $goods['max_am']===NULL ){
    $startPay = $result['price']/100;
     
}else{
  
    $startPay = $goods['max_am']/100;
     
}
?>



<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style/css/index.css">
    <link rel="stylesheet" href="style/css/profile.css">
    <link rel="stylesheet" href="style/css/goods_style.css">
    <link rel="stylesheet" href="style/css/popup.css">
    <link rel="stylesheet" href="style/css/tabel.css">
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
        <p class="msg">
            <?php
                echo $_SESSION['message_good'];
                unset($_SESSION['message_good']);
            ?>
        </p>
        <div class="contant">
            <div class="product-photo">
                <img src="style/images/<?=$result['image']?>" alt="">
            </div> 
            <div class="inf_cont">
                <div class="contant_name"> <?=$result['name']?> </div>  
                 
                <div class="prof_inf">
                    <p class="">Начальная стоимость: </p>
                    <p><?=$result['price']/100?> руб</p>
                </div>

                <div class="prof_inf">
                    <p class="">Моментальный выкуп: </p>
                    <p><?=$result['price_lim']/100?> руб</p>
                </div>

                <div class="prof_inf">
                    <p class="">Последняя ставка: </p>
                    <p><?=$goods['max_am']/100?> руб</p>
                </div>

                <div class="prof_inf">
                    <p class="">Дата окончания лота: </p>
                    <p><?=$result['time_end']?></p>
                </div>

                <div class="prof_inf btw_con">
                    <?php if ( ($_SESSION['user']['group']==2) ): ?>
                    <a href="" class = "btw_box">Редактировать</a>
                    <a href="" class = "btw_box">Удалить</a>
                    <?php endif; ?>

                    <?php if ( ($result['status']==3) ): ?>
                        <p class="msg">Товар куплен </p>
                    <?php else: ?>
                    <a  class = "btw_box  buy" id ="buy-button" ><?=$MyGoods['max_am'] === NULL ? 'Cделать ставку!':'Поднять ставку';?></a>
                    <?php endif; ?>
                </div>                
            </div>                  
        </div>

        <hr>
        <table class="main_rows">
            <thead class="name_rows">
            <tr>
                <th>user</th>
                <th>event</th>
                <th>amount</th>
                <th> </th>
                <th>sum</th>
                <th>date</th>
            <tr>
            </thead>
                    
            <tbody>
            <?php   
                            
                $log = $mySQL->query("SELECT `ts`.`id` as `id`, `name`, FORMAT(`amount`/100,2) as `amount`,`status`, FORMAT(`total_sum`/100,2) as `total_sum` , `date` FROM `transaction` as `ts` JOIN `user` as `u`  on `ts`.`id_user` = `u`.`id` WHERE `ts`.`id_goods` = '$id' ORDER BY  `date` DESC ")->fetch_all(MYSQLI_ASSOC);     
                     
                
                foreach ($log as $i => $value) {
                    if (!$log[$i]['date_del']  ){


                        echo '<tr class ="boss_index_table_offline">';
                        echo '<td><b>'.$log[$i]['name'].'</b></td>' ;
                        if($log[$i]['status']==1){
                            echo '<td>Сделал ставку</td>'; 
                        }else{
                            echo  '<td>Поднял ставку на </td>' ;  
                        }
                        echo '<td><b>'.$log[$i]['amount'].' Руб.</b></td>' ;
                        echo '<td> Итог </td>' ; 
                        echo '<td><b>'.$log[$i]['total_sum'].' Руб.</b></td>' ;
                        echo '<td>'.$log[$i]['date'].'</td>' ;  
                        echo '</tr>';
                    }
                        
                }
                $mySQL->close();
            ?>
            <tbody>
        </table>    
        <hr>
    </div>

    <div class="popup__bg" id="buy-dialog">
        <form   class="popup" method="post" action="php/buy.php">
            <img src="style/images/close_img.png" alt="" class="close__popup">
            <div class ="invisibility">
                <input type="number" name ="id_goods"  value = "<?=$id?>">
                <div class="label__text">
                    id лота
                </div>
            </div>

            <label>
                <div class="label__text">
                Последняя ставка: <b> <?=$goods['max_am']/100?> руб.</b>
                </div>
            </label>
            <label>
                <div class="label__text">
                Ваша последняя ставка: <b><?=$MyGoods['max_am']/100?> руб.<b>
                </div>
            </label>

            <label>
                <input type="number" name ="sum"  step="1" min ="<?= $startPay+1 ?>" max ="<?=$result['price_lim']/100?>" value = "<?=$startPay+1?>">
                    <div class="label__text">
                        Ваша ставка
                    </div>
            </label>
            
            <button class="btw_use" type="submit" >Отправить</button>
        </form>
                        
    </div>

    <script src="js/popup.js"></script> 
    <pre>
        <?php 
           
            
        ?>
    </pre>
     
 
</body>

</html>