<?php
session_start();
//страница со спиком пользователей. Пока можно только смотреть и удалять 

if(  ($_SESSION['user']['group']!= 2 )||(!$_SESSION['user']) ){
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
            <div class="contant_name"> USERS </div>
            <hr>
             <div class="btw_con">
                <button type="button" class="btw_use"  >Пустышка</button>
                <button type="submit" class="btw_use"  >Добавить пользователя</button>
             </div>
             <hr>
            <table class="main_rows">
                <thead class="name_rows">
                <tr>
                    <th>id</th>
                    <th>name</th>
                    <th>login</th>
                    <th>group</th>
                    <th> </th>
                <tr>
                </thead>
                    
                <tbody>
                <?php
                    require_once 'php/connect.php';
                    $result = $mySQL->query("SELECT `id`, `login`, `name`, `group` FROM `user`WHERE `is_deleted` is NULL")->fetch_all(MYSQLI_ASSOC);
                    
                     
                    foreach ($result as $i => $value) {
                        if (!$result[$i]['date_del']  ){
                            echo '<tr class ="boss_index_table_offline">';
                            echo '<td>'.$result[$i]['id'].'</td>' ;
                            echo '<td>'.$result[$i]['name'].'</td>' ; 
                            echo '<td>'.$result[$i]['login'].'</td>' ;
                            echo '<td>'.$result[$i]['group'].'</td>' ;
                            echo '<td class = "left">
                                    <div class ="btn-group nowrap"> 
                                        <a href="" class = "btn btn-default js-tooltip">Редактировать</a>
                                        <a href="php/delete.php?id='.$result[$i]['id'].'" class = "btn btn-default js-tooltip">Удалить</a>
                                    </div>
                                </td>' ; 

                            echo '</tr>';
                        }
                        
                    }
                    $mySQL->close();
                ?>
                <tbody>
            </table>    
            <hr>
            <pre>
                <?php 
                print_r($_SESSION['user']);
                ?>
            </pre> 
                      
        </div>
    </div>

    
   
</body>
</html>