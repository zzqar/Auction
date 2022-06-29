<?php
session_start();
 

if( (!$_SESSION['user']) ){
    header('Location: /login.php');
    exit();
}
?>  
 
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style/css/index.css">
    <link rel="stylesheet" href="style/css/tabel.css">
    <link rel="stylesheet" href="style/css/auction.css">
    <link rel="stylesheet" href="style/css/popup.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">    
    <title>Аукцион by zzqar</title>
</head>
<body>
    <header class="header">
        <div class="container">
            <div class="header_inner">
                 <div class="header_logo">Auction</div>
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
    <div class="intro">
         
    </div>
    <div class="main">
        <div class="contant">
            <div class="contant_name">АУКЦИОН</div>
            <hr>
            <?php
                if ($_SESSION['user']['group']=='2'){                 
                    echo'<div class="btw_con">
                        <button type="button" id ="buy-button"  class="btw_use"  >Добавить лот</button>   
                    </div>';
                }
            ?>
            <div class="goods">
                <ul class="products clearfix">
                <?php
                    $now = date("Y-m-d H:i:s"); // текущее время (метка времени)
                    $nows = new DateTime(); 


                    require_once 'php/connect.php';
                    $result = $mySQL->query("SELECT * FROM `goods` WHERE `time_end`> '$now' ")->fetch_all(MYSQLI_ASSOC);
                    
                    foreach ($result as $i => $value) {
                        if ($result[$i]['status']='1'  ){
                            $price = $result[$i]['price']/100;
                            $lim_price = $result[$i]['price_lim']/100;

                            $date = date_create($result[$i]['time_end']);
                           
                            $interval = $date->diff($nows);
                            
                            

                            echo '<li class="product-wrapper">
                                    <a href="good.php?id='.$result[$i]['id'].'" class="product">
                                        <div class="product-photo">
                                            <img src="style/images/'.$result[$i]['image'].'" alt="">
                                         </div>
                                         <div class="soder">
                                            <p class="name_goods">'.$result[$i]['name'].'</p>
                                            <p> '.$price.' руб</p>
                                        </div>
                                        
                                        <div class="soder">
                                            <p class=" ">Быстрый выкуп: </p>
                                            <p>'.$lim_price.' руб </p>
                                        </div>
                                        <div class="soder">
                                            <p class=" ">Окончание:</p>
                                            <p>'.$interval->d.' д. '.$interval->h.' ч.</p>
                                        </div>
                                        <button type="button" class="btw_use  lot"  >Выкупить</button>
                                    </a>
                                </li>';        
                        }
                    }
                 
                ?>     
                </ul>
            </div>            
        </div>
    </div>

    <div class="popup__bg" id="buy-dialog">
        <form   class="popup" method="post" action="php/addgoods.php" enctype="multipart/form-data" >
            <img src="style/images/close_img.png" alt="" class="close__popup">

            <div class ="invisibility">
                <input type="number" name ="id_goods"  value = "<?=$id?>">
                <div class="label__text">
                    id лота
                </div>
            </div>
            <label>
                <input type="file" name="file">
                     
            </label>        
            <label>
                <input type="text" name ="name_goods"     >
                    <div class="label__text">
                        Название
                    </div>
            </label>
            <label>
                <input type="number" name ="price"  step="1"  >
                    <div class="label__text">
                        Начальная стоимость
                    </div>
            </label>
            <label>
                <input type="number" name ="price_lim"  step="1"  >
                    <div class="label__text">
                        Стоимость быстрого выкупа
                    </div>
            </label>
            <label>
                <input type="date" name ="date"     >
                    <div class="label__text">
                        Дата завершения лота 
                    </div>
            </label>
            
            <button class="btw_use" type="submit" >Загрузить</button>
        </form>
                        
    </div>

    <script src="js/popup.js"></script> 
    
   
</body>
</html>