<?php
//крестики нолики, код спижен 
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
    <link rel="stylesheet" href="style/css/game.css">
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
     
         
   
    <div class="main">
        <div class="contant">
            <div class="contant_name"> Game </div>
            <input type="checkbox" id="difficulty" checked />
<input type="checkbox" id="sound" />
<input type="checkbox" id="first" />

<input type="checkbox" id="start" />

<form id="tictactoe">  
  <input type="radio" name="cell-0" id="cell-0-x" />
  <input type="radio" name="cell-0" id="cell-0-o" />
  <input type="radio" name="cell-1" id="cell-1-x" />
  <input type="radio" name="cell-1" id="cell-1-o" />
  <input type="radio" name="cell-2" id="cell-2-x" />
  <input type="radio" name="cell-2" id="cell-2-o" />
  <input type="radio" name="cell-3" id="cell-3-x" />
  <input type="radio" name="cell-3" id="cell-3-o" />
  <input type="radio" name="cell-4" id="cell-4-x" />
  <input type="radio" name="cell-4" id="cell-4-o" />
  <input type="radio" name="cell-5" id="cell-5-x" />
  <input type="radio" name="cell-5" id="cell-5-o" />
  <input type="radio" name="cell-6" id="cell-6-x" />
  <input type="radio" name="cell-6" id="cell-6-o" />
  <input type="radio" name="cell-7" id="cell-7-x" />
  <input type="radio" name="cell-7" id="cell-7-o" />
  <input type="radio" name="cell-8" id="cell-8-x" />
  <input type="radio" name="cell-8" id="cell-8-o" />

  <div id="menu" class="scrim">
    <div class="center">
      <h1>CSS Tic-Tac-Toe</h1>
      <div>
        <h2>Difficulty</h2>
        <div class="toggle-group">
          <span>Beginner</span>
          <label for="difficulty" class="toggle"></label>
          <span>Advanced</span>
        </div>
        <!-- Soon...
        <h2>Sound</h2>
        <div class="toggle-group">
          <span>Off</span>
          <label for="sound" class="toggle"></label>
          <span>On</span>
        </div>
        -->
        <h2>First turn</h2>
        <div class="toggle-group">
          <span>Player</span>
          <label for="first" class="toggle"></label>
          <span>Computer</span>
        </div>
        <label for="start" id="start-button" class="btn">Start Game</label>
      </div>
    </div>
  </div>

  <div id="board" class="center">
    <div class="tile" id="tile-0">
      <label for="cell-0-x"></label>
      <div></div>
    </div>
    <div class="tile" id="tile-1">
      <label for="cell-1-x"></label>
      <div></div>
    </div>
    <div class="tile" id="tile-2">
      <label for="cell-2-x"></label>
      <div></div>
    </div>
    <div class="tile" id="tile-3">
      <label for="cell-3-x"></label>
      <div></div>
    </div>
    <div class="tile" id="tile-4">
      <label for="cell-4-x"></label>
      <div></div>
    </div>
    <div class="tile" id="tile-5">
      <label for="cell-5-x"></label>
      <div></div>
    </div>
    <div class="tile" id="tile-6">
      <label for="cell-6-x"></label>
      <div></div>
    </div>
    <div class="tile" id="tile-7">
      <label for="cell-7-x"></label>
      <div></div>
    </div>
    <div class="tile" id="tile-8">
      <label for="cell-8-x"></label>
      <div></div>
    </div>
  </div>
  <div id="label-computer" class="btn">
    Computer Move!
    <label for="cell-0-o"></label>
    <label for="cell-1-o"></label>
    <label for="cell-2-o"></label>
    <label for="cell-3-o"></label>
    <label for="cell-4-o"></label>
    <label for="cell-5-o"></label>
    <label for="cell-6-o"></label>
    <label for="cell-7-o"></label>
    <label for="cell-8-o"></label>
  </div>
  <div id="end" class="scrim">
    <div id="message" class="center">
      <div>
        <input type="reset" for="tictactoe" value="Play again" />
      </div>
    </div>
  </div>
</form>
                           
        </div>

    </div>
   
    
   
</body>
</html>