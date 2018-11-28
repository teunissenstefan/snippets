<?php
  function call($controller, $action) {
    require_once('controllers/' . $controller . '_controller.php');

    switch($controller) {
      case 'pages':
        require_once('models/snippet.php');
        require_once('models/user.php');
        $controller = new PagesController();
      break;
      case 'snippets':
        require_once('models/user.php');   
        require_once('models/snippet.php');
        $controller = new SnippetsController();
      break;
      case 'gebruikers':
        require_once('models/snippet.php');
        require_once('models/role.php');
        require_once('models/user.php');
        $controller = new GebruikersController();
      break;
    }

    $controller->{ $action }();
  }

  $controllers = array('pages' => ['home', 'login', 'register', 'logout', 'error'],
                       'snippets' => ['index', 'show', 'add', 'edit', 'delete'],
                       'gebruikers' => ['index', 'add', 'edit', 'delete']);

  if (array_key_exists($controller, $controllers)) {
    if (in_array($action, $controllers[$controller])) {
      call($controller, $action);
    } else {
      call('pages', 'error');
    }
  } else {
    call('pages', 'error');
  }
?>