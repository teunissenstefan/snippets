<!doctype html>
<html lang="nl">
	<head>
        <title>Snippets</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" href="css/jquery-ui.min.css" />
        <link rel="stylesheet" href="css/main.css" />
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/default.min.css">
        <link rel="apple-touch-icon-precomposed" href="images/favicon/apple-touch-icon.png">
        <link rel="icon" href="images/favicon/favicon.png">
        <!--[if IE]><link rel="shortcut icon" href="images/favicon/favicon.ico"><![endif]-->
        <meta name="msapplication-TileColor" content="#a3a3a3">
        <meta name="msapplication-TileImage" content="images/favicon/tileicon.png">
	</head>
	<body>	
            <nav class="navbar fixed-top navbar-expand-lg navbar-light bg-light" style="min-height:55px;">
                <div class="container">
                    <a class="navbar-brand" href="?controller=snippets&action=index">Snippets</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="?controller=snippets&action=index">Snippets</a>
                        </li>
                        <?php
                            if(!isset($_SESSION['id'])){
                        ?>
                        <li class="nav-item">
                            <a class="nav-link" href="?controller=pages&action=login">Inloggen</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="?controller=pages&action=register">Registreren</a>
                        </li>
                        <?php
                            }else{
                                if($_SESSION['rol'] == "1"){
                        ?>
                        <li class="nav-item">
                            <a class="nav-link" href="?controller=gebruikers&action=index">Gebruikers</a>
                        </li>
                        <?php
                                }
                        ?>
                        <li class="nav-item">
                            <a class="nav-link" href="?controller=pages&action=logout">Uitloggen</a>
                        </li>
                        <?php
                            }
                        ?>
                        </ul>
                        <form class="form-inline my-2 my-lg-0" method="GET" action="" id="searchform">
                            <input type="hidden" name="controller" value="snippets"/>
                            <input type="hidden" name="action" value="index"/>
                            <select class="form-control col-12 col-md-3" id="inputTaalNavbar" name="lang">
                                <option value="-empty-">Alle talen</option>
                                <?php
                                    foreach($alle_talen as $htaal){
                                        if($htaal->id==$gettaal){
                                            echo "<option value='".$htaal->id."' selected>".$htaal->language."</option>";
                                        }else{
                                            echo "<option value='".$htaal->id."'>".$htaal->language."</option>";
                                        }
                                    }
                                ?>
                            </select>
                            <input class="form-control col-12 col-md-7" type="search" placeholder="Zoekterm" name="q" value="<?php if(isset($_GET['q'])){echo $_GET['q'];} ?>" id="zoekbalk" aria-label="Zoeken">
                            <button class="btn btn-outline-success my-2 my-sm-0 col-12 col-md-2" id="zoekbalkButton" type="submit">Zoeken</button>
                        </form>
                    </div>
                </div>
            </nav>
	
        <div class="container" style="margin-top:70px;">

			<?php require_once('routes.php'); ?>

		</div>

        <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
        <script src="js/jquery-ui.min.js"></script>
        <script src="js/responsive-paginate.js"></script>
        <script src="js/jquery.query-object.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/highlight.min.js"></script>
        <script>hljs.initHighlightingOnLoad();</script>
        <script src="js/clipboard.min.js"></script>
        <script src="js/snippets.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<body>
<html>