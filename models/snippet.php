<?php
  class Snippet {
    public $id;
    public $beschrijving;
    public $snippet;
    public $aangemaaktdoor;
    public $language;
    public $datum_aangemaakt;
    public $datum_update;

    public function __construct($id, $beschrijving, $snippet, $aangemaaktdoor, $language, $datum_aangemaakt, $datum_update) {
      $this->id      = $id;
      $this->beschrijving = $beschrijving;
      $this->snippet  = $snippet;
      $this->aangemaaktdoor = $aangemaaktdoor;
      $this->language = $language;
      $this->datum_aangemaakt = $datum_aangemaakt;
      $this->datum_update = $datum_update;
    }

    public static function all($doSearch, $q, $page, $amountPerPage, $pagination) {
      $list = [];
      $db = Db::getInstance();
      $query = 'SELECT * FROM snippets ';
      if($doSearch || (isset($_GET['lang']) && $_GET['lang']!="-empty-")){
        $query.= " WHERE ";
      }
      if($doSearch){
        $query.= " (snippet LIKE :sq OR beschrijving LIKE :sq)";
      }
      if($doSearch && (isset($_GET['lang']) && $_GET['lang']!="-empty-")){
        $query.= " AND ";
      }
      if(isset($_GET['lang']) && $_GET['lang']!="-empty-"){
        $query.= ' language=:language';
      }
      $query.= ' ORDER BY datum_aangemaakt DESC';
      if($pagination==true){
        $query.= ' LIMIT :limitStart,:limitAmount';
        $req = $db->prepare($query);
        $limitStart = ($page-1) * $amountPerPage;
        $req->bindParam(':limitStart', $limitStart, PDO::PARAM_INT);
        $req->bindParam(':limitAmount', $amountPerPage, PDO::PARAM_INT);
      }else{
        $req = $db->prepare($query);
      }
      $q = "%".$q."%";
      if(isset($_GET['lang']) && $_GET['lang']!="-empty-"){
        $req->bindParam(':language', $_GET['lang'], PDO::PARAM_STR);
      }
      if($doSearch){
        $req->bindParam(':sq', $q, PDO::PARAM_STR);
      }
      $req->execute();

      foreach($req->fetchAll() as $snippet) {
        $aangemaaktdoor = User::findById($snippet['aangemaaktdoor']);
        $language = Language::findById($snippet['language']);
        $list[] = new Snippet($snippet['id'], $snippet['beschrijving'], $snippet['snippet'], $aangemaaktdoor, $language->language, $snippet['datum_aangemaakt'], $snippet['datum_update']);
      }

      return $list;
    }

    public static function pagination($doSearch, $q, $page, $amountPerPage){
      $list = [];
      $amountOfPages = count(Snippet::all($doSearch,$q,$page,$amountPerPage, false)) / $amountPerPage;
      $list[] = ceil($amountOfPages);
      return $list;
    }

    public static function allLanguage($lang, $doSearch, $q) {
      $list = [];
      $db = Db::getInstance();
      $req = $db->prepare('SELECT * FROM snippets WHERE language = :language ORDER BY datum_aangemaakt DESC');
      $req->bindParam(':language', $lang, PDO::PARAM_STR);
      $req->execute();

      foreach($req->fetchAll() as $snippet) {
        $aangemaaktdoor = User::findById($snippet['aangemaaktdoor']);
        $language = Language::findById($snippet['language']);
        $list[] = new Snippet($snippet['id'], $snippet['beschrijving'], $snippet['snippet'], $aangemaaktdoor, $language->language, $snippet['datum_aangemaakt'], $snippet['datum_update']);
      }

      return $list;
    }

    public static function find($id) {
      $db = Db::getInstance();
      $req = $db->prepare('SELECT * FROM snippets WHERE id = :id');
      $req->bindParam(':id', $id, PDO::PARAM_STR);
      $req->execute();
      $snippet = $req->fetch();

      $aangemaaktdoor = User::findById($snippet['aangemaaktdoor']);
      $language = Language::findById($snippet['language']);
                            
      return new Snippet($snippet['id'], $snippet['beschrijving'], $snippet['snippet'], $aangemaaktdoor, $language, $snippet['datum_aangemaakt'], $snippet['datum_update']);
    }

    public static function Add($id, $snippet, $language, $beschrijving) {
      $db = Db::getInstance();
      $req = $db->prepare('INSERT INTO snippets (id,beschrijving,snippet,language,aangemaaktdoor,datum_aangemaakt,datum_update)
                           VALUES (:id,:beschrijving,:snippet,:language,:aangemaaktdoor,:datum_aangemaakt,:datum_update)');
      $req->bindParam(':id', $id, PDO::PARAM_STR);
      $req->bindParam(':beschrijving', $beschrijving, PDO::PARAM_STR);
      $req->bindParam(':snippet', $snippet, PDO::PARAM_STR);
      $req->bindParam(':aangemaaktdoor', $_SESSION['id'], PDO::PARAM_STR);
      $req->bindParam(':language', $language, PDO::PARAM_INT);
      $datenow = date("Y-m-d H:i:s");
      $req->bindParam(':datum_aangemaakt', $datenow, PDO::PARAM_STR);
      $req->bindParam(':datum_update', $datenow, PDO::PARAM_STR);
      $req->execute();

      return true;
    }

    public static function Update($id, $snippet, $language, $beschrijving) {
      $db = Db::getInstance();
      $req = $db->prepare('UPDATE snippets 
                           SET snippet=:snippet,beschrijving=:beschrijving,language=:language,datum_update=:datum_update
                           WHERE id = :id');
      $req->bindParam(':id', $id, PDO::PARAM_STR);
      $req->bindParam(':beschrijving', $beschrijving, PDO::PARAM_STR);
      $req->bindParam(':snippet', $snippet, PDO::PARAM_STR);
      $req->bindParam(':language', $language, PDO::PARAM_STR);
      $datenow = date("Y-m-d H:i:s");
      $req->bindParam(':datum_update', $datenow, PDO::PARAM_STR);
      $req->execute();

      return true;
    }
    
    public static function Delete($id){
      $db = Db::getInstance();
      $req = $db->prepare('DELETE FROM snippets 
                           WHERE id = :id');
      $req->bindParam(':id', $id, PDO::PARAM_STR);
      $req->execute();

      return true;
    }
    
    
    public static function DeleteAllByUser($id){
      $db = Db::getInstance();
      $req = $db->prepare('DELETE FROM snippets 
                           WHERE aangemaaktdoor = :uid');
      $req->bindParam(':uid', $id, PDO::PARAM_STR);
      $req->execute();

      return true;
    }
  }
?>