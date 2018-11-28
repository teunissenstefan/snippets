<?php
  class SnippetsController {
    public function index() {
      $alle_talen = Language::all();
      $search = false;
      $q = "";
      if(isset($_GET['q'])){
        $search = true;
        $q = $_GET['q'];
      }
      $page = 1;
      if(isset($_GET['page'])){
        $page = $_GET['page'];
      }
      if(filter_var($page, FILTER_VALIDATE_INT) === false || $page <= 0){
        $page = 1;
      }
      $amountPerPage = 15;
      $snippets = Snippet::all($search,$q,$page,$amountPerPage, true);
      $countWithoutPage = Snippet::all($search,$q,$page,$amountPerPage, false);
      $pagination = Snippet::pagination($search,$q,$page,$amountPerPage);
      $gettaal = "";
      if(isset($_GET['lang'])){
        $gettaal = $_GET['lang'];
      }
      require_once('views/snippets/index.php');
    }

    public function delete(){
        if(!isset($_SESSION['id'])){
            header("Location:?controller=pages&action=login");
        }
        if (!isset($_GET['id'])){
        return call('pages', 'error');
        }

        $snippet = Snippet::find($_GET['id']);
        if($_SESSION['rol']!="1" && !($_SESSION['rol']=="2" && $snippet->aangemaaktdoor->id==$_SESSION['id'])){
        return call('pages', 'error');
        }

        if(isset($_GET['delete'])){
            $delete = Snippet::Delete($_GET['id']);
            header("Location:?controller=snippets&action=index");
        }

        require_once('views/snippets/delete.php');
    }

    public function show() {
      if (!isset($_GET['id'])){
        return call('pages', 'error');
      }

      $snippet = Snippet::find($_GET['id']);

      require_once('views/snippets/show.php');
    }

    public function edit() {
      if(!isset($_SESSION['id'])){
          header("Location:?controller=pages&action=login");
      }
      if (!isset($_GET['id'])){
        return call('pages', 'error');
      }

      $snippet = Snippet::find($_GET['id']);
      if($_SESSION['rol']!="1" && !($_SESSION['rol']=="2" && $snippet->aangemaaktdoor->id==$_SESSION['id'])){
      return call('pages', 'error');
      }

      $alle_talen = Language::all();

      $post_taal = $snippet->language->id;
      $post_snippet = $snippet->snippet;
      $post_beschrijving = $snippet->beschrijving;
      $post = false;
      if(isset($_POST['submit'])){
          $post = true;
          $errorMsg = "Los de volgende problemen op:";
          $gelukt = true;
          
          if(!empty($_POST['snippet'])){
              $post_snippet = ($_POST['snippet']);
          }else{
              $errorMsg .= "<br/>Vul de snippet in";
              $gelukt = false;
          }

          if(!empty($_POST['beschrijving'])){
              $post_beschrijving = ($_POST['beschrijving']);
          }else{
              $errorMsg .= "<br/>Vul de beschrijving in";
              $gelukt = false;
          }

          if(!empty($_POST['taal'])){
            $post_taal = strip_tags($_POST['taal']);
            $check_taal = Language::findById($post_taal);
            if(empty($check_taal->id)){
                $errorMsg .= "<br/>Ongeldige taal";
                $gelukt = false;
            }else{
              $submit_taal_id = $check_taal->id;
            }
          }else{
              $errorMsg .= "<br/>Vul een taal in";
              $gelukt = false;
          }          

          if($gelukt){
            $opgeslagen = Snippet::Update($snippet->id, $post_snippet, $submit_taal_id, $post_beschrijving);
          }
      }

      require_once('views/snippets/edit.php');
    }

    public function add(){
      if(!isset($_SESSION['id'])){
          header("Location:?controller=pages&action=login");
      }
      if($_SESSION['rol'] != "1" && $_SESSION['rol'] != "2"){
          return call('pages', 'error');
      }
      
      $alle_talen = Language::all();

      $post_taal = "";
      $post_snippet = "";
      $post_beschrijving = "";
      $post = false;
      if(isset($_POST['submit'])){
          $post = true;
          $errorMsg = "Los de volgende problemen op:";
          $gelukt = true;

          if(!empty($_POST['snippet'])){
              $post_snippet = ($_POST['snippet']);
          }else{
              $errorMsg .= "<br/>Vul de snippet in";
              $gelukt = false;
          }

          if(!empty($_POST['beschrijving'])){
              $post_beschrijving = ($_POST['beschrijving']);
          }else{
              $errorMsg .= "<br/>Vul de beschrijving in";
              $gelukt = false;
          }

          if(!empty($_POST['taal'])){
            $post_taal = strip_tags($_POST['taal']);
            $check_taal = Language::findById($post_taal);
            if(empty($check_taal->id)){
                $errorMsg .= "<br/>Ongeldige taal";
                $gelukt = false;
            }else{
              $submit_taal_id = $check_taal->id;
            }
          }else{
              $errorMsg .= "<br/>Vul een taal in";
              $gelukt = false;
          }

          if($gelukt){
            $id = abs( crc32( uniqid() ) );
            if(strlen($id)>10){
              $id = substr($id,0,10);
            }
            if(strlen($id)<10){
              for($i = strlen($id);$i<10;$i++){
                $id .= substr($i,strlen($i)-1,1);
              }
            }
            $id = "M".date("Y").date("m").$id;

            $genId = base_convert(microtime(false), 10, 36);

            $toegevoegd = Snippet::Add($genId, $post_snippet, $submit_taal_id, $post_beschrijving);
          }
      }

      require_once('views/snippets/add.php');
    }
  }
?>