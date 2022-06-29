<?php
session_start();

if($_SESSION['user']){
    header('Location: /index.php');
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auction</title>
    <link rel="stylesheet" type="text/css" href="style/css/style.css">
    <link rel="stylesheet" href="style/css/index.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">    


</head>
<body>
  <header class="header">
    <div class="container">
        <div class="header_inner">
             <div class="header_logo"  >  Auction </div>
                <nav class="nav">
                   
                    <a class="nav_link" href="registr.php">Регистрация</a>
                    <a class="nav_link" href="login.php">Войти</a>
                </nav>
                  
        </div>

    </div>
</header>
    <form class="form_reg" action="php/signin.php" method="post">
        
        <div class="container2">
            <h1>Авторизация</h1>
            
            <hr>
            <label for="login"><b>Login</b></label>
            <input  type="text" class="poleinput" name="login" id="login" placeholder="login"    >
        
           
              
            

            <label for="psw"><b>Password</b></label>
            <input id="psw" type="password" class="poleinput" name="psw" placeholder="текст внутри 2 ( типо пароль)"   >
         
 
            <p class="msg">
                <?php
                 echo $_SESSION['message'];
                 unset($_SESSION['message']);
                  ?>
            </p>
             

            
            <button type="button" class="registerbtn" id="reset">Сбросить</button>
            <button type="submit" class="registerbtn" id="validate">Войти</button>
            
             
        </div>

        <hr>
    </form>
    <div class="container signin">
      <p>Already Dont have an account? <a href="registr.php">reg</a>.</p>
    </div>

   
    
</body>
</html>