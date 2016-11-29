<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>NPDI</title>
  <link rel="icon" href="../img/npdi25cartazmin.png" type="image/gif">
  <link rel="stylesheet" href="../materialize/css/materialize.min.css" media="screen" title="no title" charset="utf-8">
  <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
  <script src="../materialize/js/materialize.min.js"></script>
  <link rel="stylesheet" href="../css/stylesheet.css"/>
  <script src="https://use.fontawesome.com/e87f3c4a42.js"></script>
  <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/js/materialize.min.js"></script>
  <script src="../js/app.js" type="text/javascript"></script>
</head>
<body class="bg-pix" >
  <!--Navbar desktop-->
  <div class="navbar-fixed nav-desk" >
  <nav>
    <div class="nav-wrapper bg-blue">
      <ul class="left hide-on-med-and-down">
        <li><a href="/frontend/templates/sobre.php">Sobre o NPDI</a></li>
        <li><a href="/frontend/templates/projetos.php">Projetos</a></li>
        <li><a href="/frontend/templates/disciplinas.php">Disciplinas</a></li>
        <li><a href="/frontend/templates/galeria.php">Galeria</a></li>
        <li><a href="/frontend/templates/links.php">Links</a></li>
      </ul>
      <ul class="right hide-on-med-and-down" ng-app="clock" ng-controller="clockController as cc">
        <li><a href="/frontend/templates/login.php">Login</a></li>
      </ul>
    </div>
  </nav>
</div>
<!--Nav Mobile-->
<div class="nav-mobile">
  <a href="/frontend/templates/sobre.php"><center><h4 class="fill bg-blue white-font mobile-menu">Sobre o NPDI</h4></center></a>
  <a href="/frontend/templates/projetos.php"><center><h4 class="fill bg-blue white-font mobile-menu">Projetos</h4></center></a>
  <a href="/frontend/templates/disciplinas.php"><center><h4 class="fill bg-blue white-font mobile-menu">Disciplinas</h4></center></a>
  <a href="/frontend/templates/galeria.php"><center><h4 class="fill bg-blue white-font mobile-menu">Galeria</h4></center></a>
  <a href="/frontend/templates/links.php"><center><h4 class="fill bg-blue white-font mobile-menu">Links</h4></center></a>
  <a href="/frontend/templates/login.php"><center><h4 class="fill bg-blue white-font mobile-menu">Login</h4></center></a>
</div>
<!--Fim da navbar-->
<div class="outdor clearfix">
    <a href="index.php"><img class="left" src="../img/npdi25cartaz.png" alt="Cartaz do NPDI" /></a>
    <div class="input-field right col2 busca">
        <input placeholder="Busca" type="text" name="busca">
    </div>
</div>
