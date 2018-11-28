<?php
  class Language {
    public $id;
    public $language;

    public function __construct($id, $language) {
      $this->id         = $id;
      $this->language   = $language;
    }

    public static function all() {
      $list = [];
      $db = Db::getInstance();
      $req = $db->query('SELECT * FROM languages ORDER BY language ASC');

      foreach($req->fetchAll() as $language) {
        $list[] = new Language($language['id'],$language['language']);
      }

      return $list;
    }

    public static function findById($id) {
      $db = Db::getInstance();
      $req = $db->prepare('SELECT * FROM languages WHERE id = :id');
      $req->bindParam(':id', $id, PDO::PARAM_STR);
      $req->execute();
      $language = $req->fetch();

      return new Language($language['id'],$language['language']);
    }

    public static function Add($id,$language) {
      $db = Db::getInstance();
      $req = $db->prepare('INSERT INTO languages (id,language)
                           VALUES (:id,:language)');
      $req->bindParam(':id', $id, PDO::PARAM_STR);
      $req->bindParam(':language', $language, PDO::PARAM_STR);
      $req->execute();

      return true;
    }
  }
?>