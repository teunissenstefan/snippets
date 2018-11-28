<?php
  class User {
    public $id;
    public $gebruikersnaam;
    public $voornaam;
    public $achternaam;
    public $wachtwoord;
    public $salt;
    public $email;
    public $telefoonnummer;
    public $rol;

    public function __construct($id, $gebruikersnaam, $voornaam, $achternaam, $wachtwoord, $salt, $email, $telefoonnummer, $rol) {
      $this->id      = $id;
      $this->gebruikersnaam  = $gebruikersnaam;
      $this->voornaam = $voornaam;
      $this->achternaam = $achternaam;
      $this->wachtwoord = $wachtwoord;
      $this->salt = $salt;
      $this->email = $email;
      $this->telefoonnummer = $telefoonnummer;
      $this->rol = $rol;
    }

    public static function all() {
      $list = [];
      $db = Db::getInstance();
      $req = $db->query('SELECT * FROM gebruikers');

      foreach($req->fetchAll() as $gebruiker) {
        $rol = Role::findById($gebruiker['rol']);
        $list[] = new User($gebruiker['id'], $gebruiker['gebruikersnaam'], $gebruiker['voornaam'], $gebruiker['achternaam'], $gebruiker['wachtwoord'], $gebruiker['salt'], $gebruiker['email'], $gebruiker['telefoonnummer'], $rol);
      }

      return $list;
    }

    public static function findById($id) {
      $db = Db::getInstance();
      $req = $db->prepare('SELECT * FROM gebruikers WHERE id = :id');
      $req->bindParam(':id', $id, PDO::PARAM_STR);
      $req->execute();
      $gebruiker = $req->fetch();
      $rol = Role::findById($gebruiker['rol']);

      return new User($gebruiker['id'], $gebruiker['gebruikersnaam'], $gebruiker['voornaam'], $gebruiker['achternaam'], $gebruiker['wachtwoord'], $gebruiker['salt'], $gebruiker['email'], $gebruiker['telefoonnummer'], $rol);
    }

    public static function findByUsername($id) {
      $db = Db::getInstance();
      $req = $db->prepare('SELECT * FROM gebruikers WHERE gebruikersnaam = :uname');
      $req->bindParam(':uname', $id, PDO::PARAM_STR);
      $req->execute();
      $gebruiker = $req->fetch();
      $rol = Role::findById($gebruiker['rol']);

      return new User($gebruiker['id'], $gebruiker['gebruikersnaam'], $gebruiker['voornaam'], $gebruiker['achternaam'], $gebruiker['wachtwoord'], $gebruiker['salt'], $gebruiker['email'], $gebruiker['telefoonnummer'], $rol);
    }

    public static function findByUsernameOrEmail($id) {
      $db = Db::getInstance();
      $req = $db->prepare('SELECT * FROM gebruikers WHERE gebruikersnaam = :uname OR email = :uname');
      $req->bindParam(':uname', $id, PDO::PARAM_STR);
      $req->execute();
      $gebruiker = $req->fetch();
      $rol = Role::findById($gebruiker['rol']);

      return new User($gebruiker['id'], $gebruiker['gebruikersnaam'], $gebruiker['voornaam'], $gebruiker['achternaam'], $gebruiker['wachtwoord'], $gebruiker['salt'], $gebruiker['email'], $gebruiker['telefoonnummer'], $rol);
    }

    public static function findByName($name) {
      $name = explode(',',$name);
      if(count($name)>1){
        $voornaam = trim($name[1]);
        $achternaam = trim($name[0]);
      }else{
        $voornaam = "";
        $achternaam = "";
      }
      $db = Db::getInstance();
      $req = $db->prepare('SELECT * FROM gebruikers WHERE achternaam = :lname AND voornaam = :fname');
      $req->bindParam(':lname', $achternaam, PDO::PARAM_STR);
      $req->bindParam(':fname', $voornaam, PDO::PARAM_STR);
      $req->execute();
      $gebruiker = $req->fetch();
      $rol = Role::findById($gebruiker['rol']);

      return new User($gebruiker['id'], $gebruiker['gebruikersnaam'], $gebruiker['voornaam'], $gebruiker['achternaam'], $gebruiker['wachtwoord'], $gebruiker['salt'], $gebruiker['email'], $gebruiker['telefoonnummer'], $rol);
    }

    public static function findByEmail($id) {
      $db = Db::getInstance();
      $req = $db->prepare('SELECT * FROM gebruikers WHERE email = :email');
      $req->bindParam(':email', $id, PDO::PARAM_STR);
      $req->execute();
      $gebruiker = $req->fetch();
      $rol = Role::findById($gebruiker['rol']);

      return new User($gebruiker['id'], $gebruiker['gebruikersnaam'], $gebruiker['voornaam'], $gebruiker['achternaam'], $gebruiker['wachtwoord'], $gebruiker['salt'], $gebruiker['email'], $gebruiker['telefoonnummer'], $rol);
    }
    
    public static function Register($id,$gebruikersnaam,$voornaam,$achternaam,$wachtwoord,$salt,$email,$telefoonnummer,$rol){
      $db = Db::getInstance();
      $req = $db->prepare('INSERT INTO gebruikers (id,gebruikersnaam,voornaam,achternaam,wachtwoord,salt,email,telefoonnummer,rol) 
                            VALUES (:id,:gebruikersnaam,:voornaam,:achternaam,:wachtwoord,:salt,:email,:telefoonnummer,:rol)');
      $req->bindParam(':id', $id, PDO::PARAM_STR);
      $req->bindParam(':gebruikersnaam', $gebruikersnaam, PDO::PARAM_STR);
      $req->bindParam(':voornaam', $voornaam, PDO::PARAM_STR);
      $req->bindParam(':achternaam', $achternaam, PDO::PARAM_STR);
      $req->bindParam(':wachtwoord', $wachtwoord, PDO::PARAM_STR);
      $req->bindParam(':salt', $salt, PDO::PARAM_STR);
      $req->bindParam(':email', $email, PDO::PARAM_STR);
      $req->bindParam(':telefoonnummer', $telefoonnummer, PDO::PARAM_STR);
      $req->bindParam(':rol', $rol, PDO::PARAM_INT);
      $req->execute();

      return true;
    }

    public static function Update($id, $voornaam, $achternaam, $telefoonnummer, $updatepw, $wachtwoord, $salt, $rol) {
      $db = Db::getInstance();
      if($updatepw){
        $req = $db->prepare('UPDATE gebruikers 
                            SET voornaam=:voornaam,achternaam=:achternaam,telefoonnummer=:telefoonnummer,wachtwoord=:wachtwoord,salt=:salt,rol=:rol
                            WHERE id = :id');
        $req->bindParam(':wachtwoord', $wachtwoord, PDO::PARAM_STR);
        $req->bindParam(':salt', $salt, PDO::PARAM_STR);
      }else{
        $req = $db->prepare('UPDATE gebruikers 
                            SET voornaam=:voornaam,achternaam=:achternaam,telefoonnummer=:telefoonnummer,rol=:rol
                            WHERE id = :id');
      }
      $req->bindParam(':id', $id, PDO::PARAM_STR);
      $req->bindParam(':voornaam', $voornaam, PDO::PARAM_STR);
      $req->bindParam(':achternaam', $achternaam, PDO::PARAM_STR);
      $req->bindParam(':telefoonnummer', $telefoonnummer, PDO::PARAM_STR);
      $req->bindParam(':rol', $rol, PDO::PARAM_INT);
      $req->execute();

      return true;
    }

    public static function Delete($id){
      Snippet::DeleteAllByUser($id);
      $db = Db::getInstance();
      $req = $db->prepare('DELETE FROM gebruikers 
                           WHERE id = :id');
      $req->bindParam(':id', $id, PDO::PARAM_STR);
      $req->execute();

      return true;
    }
  }
?>