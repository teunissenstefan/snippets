<?php
  class Role {
    public $id;
    public $role;

    public function __construct($id, $role) {
      $this->id         = $id;
      $this->role   = $role;
    }

    public static function all() {
      $list = [];
      $db = Db::getInstance();
      $req = $db->query('SELECT * FROM rollen ORDER BY rol ASC');

      foreach($req->fetchAll() as $role) {
        $list[] = new Role($role['id'],$role['rol']);
      }

      return $list;
    }

    public static function findById($id) {
      $db = Db::getInstance();
      $req = $db->prepare('SELECT * FROM rollen WHERE id = :id');
      $req->bindParam(':id', $id, PDO::PARAM_STR);
      $req->execute();
      $role = $req->fetch();

      return new Role($role['id'],$role['rol']);
    }

    public static function Add($id,$role) {
      $db = Db::getInstance();
      $req = $db->prepare('INSERT INTO rollen (id,rol)
                           VALUES (:id,:rol)');
      $req->bindParam(':id', $id, PDO::PARAM_STR);
      $req->bindParam(':rol', $role, PDO::PARAM_STR);
      $req->execute();

      return true;
    }
  }
?>