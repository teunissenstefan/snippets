<?php
  class GebruikersController {
    public function index() {
        if(!isset($_SESSION['id'])){
            header("Location:?controller=pages&action=login");
        }
        if($_SESSION['rol'] != "1"){
            return call('pages', 'error');
        }
        $rollen = Role::all();
        $users = User::all();

        require_once('views/gebruikers/index.php');
    }

    public function delete(){
        if(!isset($_SESSION['id'])){
            header("Location:?controller=pages&action=login");
        }
        if($_SESSION['rol'] != "1"){
            return call('pages', 'error');
        }
        if (!isset($_GET['id'])){
        return call('pages', 'error');
        }

        $gebruiker = User::findById($_GET['id']);
        if(isset($_GET['delete'])){
            $delete = User::Delete($_GET['id']);
            header("Location:?controller=gebruikers&action=index");
        }

        require_once('views/gebruikers/delete.php');
    }

    public function edit() {
        if(!isset($_SESSION['id'])){
            header("Location:?controller=pages&action=login");
        }
        if($_SESSION['rol'] != "1"){
            return call('pages', 'error');
        }
        if (!isset($_GET['id'])){
            return call('pages', 'error');
        }

      $rollen = Role::all();
      $gebruiker = User::findById($_GET['id']);

      $post_achternaam = $gebruiker->achternaam;
      $post_voornaam = $gebruiker->voornaam;
      $post_telefoonnummer = $gebruiker->telefoonnummer;
      $post_rol = $gebruiker->rol->id;
      $post_wachtwoord = "";
      $post = false;
      if(isset($_POST['submit'])){
          $row_salt = $gebruiker->salt;
          $row_wachtwoord = $gebruiker->wachtwoord;
          $post = true;
          $errorMsg = "Los de volgende problemen op:";
          $gelukt = true;

          $post_achternaam = strip_tags($_POST['achternaam']);
          if(!empty($_POST['achternaam'])){
          }else{
              $errorMsg .= "<br/>Vul uw achternaam in";
              $gelukt = false;
          }

          if(!empty($_POST['rol'])){
            $post_rol = strip_tags($_POST['rol']);
            $check_rol = Role::findById($post_rol);
            if(empty($check_rol->id)){
                $errorMsg .= "<br/>Ongeldige rol";
                $gelukt = false;
            }else{
              $submit_rol_id = $check_rol->id;
            }
          }else{
              $errorMsg .= "<br/>Vul een rol in";
              $gelukt = false;
          }

          $post_voornaam = strip_tags($_POST['voornaam']);
          if(!empty($_POST['voornaam'])){
          }else{
              $errorMsg .= "<br/>Vul uw voornaam in";
              $gelukt = false;
          }

          $post_telefoonnummer = strip_tags($_POST['telefoonnummer']);
          if(!empty($_POST['telefoonnummer'])){
          }else{
              $errorMsg .= "<br/>Vul uw telefoonnummer in";
              $gelukt = false;
          }

          $wachtwoord = "";
          $salt = "";
          if(!empty($_POST['wachtwoord'])){
              $post_wachtwoord = strip_tags($_POST['wachtwoord']);
              if( preg_match('([a-zA-Z].*[0-9]|[0-9].*[a-zA-Z])', $post_wachtwoord) ){
                $salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647)); 
                $wachtwoord = hash('sha256', strip_tags($post_wachtwoord) . $salt); 
                for($round = 0; $round < 65536; $round++) 
                { 
                    $wachtwoord = hash('sha256', $wachtwoord . $salt); 
                } 
                $updatepw = true;
              }else{ 
                $errorMsg .= "<br/>Wachtwoord moet cijfers en letters bevatten";
                $gelukt = false;
              }
          }else{
            $updatepw = false;
          }

          if($gelukt){
            $opgeslagen = User::Update($gebruiker->id, $post_voornaam, $post_achternaam, $post_telefoonnummer,$updatepw,$wachtwoord,$salt,$submit_rol_id);
          }
      }

      require_once('views/gebruikers/edit.php');
    }

    public function add(){
        if(!isset($_SESSION['id'])){
            header("Location:?controller=pages&action=login");
        }
        if($_SESSION['rol'] != "1"){
            return call('pages', 'error');
        }

        $rollen = Role::all();

      $post_achternaam = "";
      $post_email = "";
      $post_gebruikersnaam = "";
      $post_voornaam = "";
      $post_wachtwoord = "";
      $post_telefoonnummer = "";
      $post_rol = "";
      $post = false;
      if(isset($_POST['submit'])){
          $post = true;
          $errorMsg = "Los de volgende problemen op:";
          $gelukt = true;
          if(!empty($_POST['gebruikersnaam'])){
              $post_gebruikersnaam = strip_tags($_POST['gebruikersnaam']);
              $check_username = User::findByUsername($post_gebruikersnaam);
              if(!empty($check_username->gebruikersnaam)){
                  $errorMsg .= "<br/>Gebruikersnaam is al geregistreerd";
                  $gelukt = false;
              }
          }else{
              $errorMsg .= "<br/>Vul een gebruikersnaam in";
              $gelukt = false;
          }

          if(!empty($_POST['rol'])){
            $post_rol = strip_tags($_POST['rol']);
            $check_rol = Role::findById($post_rol);
            if(empty($check_rol->id)){
                $errorMsg .= "<br/>Ongeldige rol";
                $gelukt = false;
            }else{
              $submit_rol_id = $check_rol->id;
            }
          }else{
              $errorMsg .= "<br/>Vul een rol in";
              $gelukt = false;
          }  

          if(!empty($_POST['voornaam'])){
              $post_voornaam = strip_tags($_POST['voornaam']);
          }else{
              $errorMsg .= "<br/>Vul uw voornaam in";
              $gelukt = false;
          }

          if(!empty($_POST['achternaam'])){
              $post_achternaam = strip_tags($_POST['achternaam']);
          }else{
              $errorMsg .= "<br/>Vul uw achternaam in";
              $gelukt = false;
          }
          

          if(!empty($_POST['telefoonnummer'])){
              $post_telefoonnummer = strip_tags($_POST['telefoonnummer']);
          }else{
              $errorMsg .= "<br/>Vul uw telefoonnummer in";
              $gelukt = false;
          }

          if(!empty($_POST['email'])){
              $post_email = strip_tags($_POST['email']);
              $check_email = User::findByEmail($post_email);
              if(!empty($check_email->gebruikersnaam)){
                  $errorMsg .= "<br/>E-mail adres is al geregistreerd";
                  $gelukt = false;
              }
          }else{
              $errorMsg .= "<br/>Vul een e-mail adres in";
              $gelukt = false;
          }

          if(!empty($_POST['wachtwoord'])){
              $post_wachtwoord = strip_tags($_POST['wachtwoord']);
              if( preg_match('([a-zA-Z].*[0-9]|[0-9].*[a-zA-Z])', $post_wachtwoord) ){
                $salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647)); 
                $wachtwoord = hash('sha256', strip_tags($post_wachtwoord) . $salt); 
                for($round = 0; $round < 65536; $round++) 
                { 
                    $wachtwoord = hash('sha256', $wachtwoord . $salt); 
                } 
              }else{ 
                $errorMsg .= "<br/>Wachtwoord moet cijfers en letters bevatten";
                $gelukt = false;
              }
          }else{
              $errorMsg .= "<br/>Vul een wachtwoord in";
              $gelukt = false;
          }

          if($gelukt){
            $genId = base_convert(microtime(false), 10, 36);
            $registered = User::Register($genId, $post_gebruikersnaam, $post_voornaam, $post_achternaam, $wachtwoord, $salt, $post_email, $post_telefoonnummer, $submit_rol_id);
          }
      }

      require_once('views/gebruikers/add.php');
    }
  }
?>