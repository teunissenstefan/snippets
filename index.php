<?php
  ob_start();
  require_once('functions.php');
  require_once('connection.php');
  require_once('models/role.php');
  require_once('models/user.php');
  require_once('session.php');

  if (isset($_GET['controller']) && isset($_GET['action'])) {
    $controller = $_GET['controller'];
    $action     = $_GET['action'];
  } else {
    $controller = 'snippets';
    $action     = 'index';
  }

  $gettaal = "";
  if(isset($_GET['lang'])){
    $gettaal = $_GET['lang'];
  }
  require_once('models/language.php');
  $alle_talen = Language::all();

  require_once('views/layout.php');
?>