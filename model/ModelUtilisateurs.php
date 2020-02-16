<?php
require_once File::build_path(array('model', 'Model.php'));
require_once File::build_path($path);
class ModelUtilisateurs extends Model
{
  private $id;
  private $nom;
  private $prenom;
  private $admin;
  private $mail;
  private $login;
  private $password;
  private $nonce;
  private $passwordNonce;
  protected static $object = 'utilisateurs';
  protected static $primary = 'id';
  //Setter
  //Getter

    public function getId(){
        return $this->id;
    }
    public function getNom(){
        return $this->nom;
    }
    public function getPrenom(){
        return $this->prenom;
    }
    public function getMail(){
        return $this->mail;
    }
    public function getLogin(){
        return $this->login;
    }
  public function getPassword(){
    return $this->password;
  }
  public function getNonce(){
    return $this->nonce;
  }
    public function getPasswordNonce(){
    return $this->passwordNonce;
  }
  public function getAdmin(){
    return $this->admin;
  }
  //Constructeur
  public function __construct($data = NULL)
  {
    if (!is_null($data) && !empty($data)) {
      foreach ($data as $key => $value) {
        $this->$key = $value;
      }
    }
  }
  //Ajout d'utilisateurs (Enregistrement)
  // public function save()
  // {
  //   $id = $this->id;
  //   $nom = $this->nom;
  //   $prenom = $this->prenom;
  //   $admin = false;
  //   $mail = $this->mail;
  //   $login = $this->login;
  //   $password = $this->password;
  //   $nonce = $this->nonce;
    
  //   //preparation de la requête
  //   $sql = "INSERT INTO utilisateurs (nom, prenom, admin, mail, login, password, nonce) VALUES (:nom, :prenom, :admin, :mail, :login, :password, :nonce)";
  //   $req_prep = Model::$pdo->prepare($sql);
  //   $values = array(
  //     "nom" => $nom,
  //     "prenom" => $prenom,
  //     "admin" => $admin,
  //     "mail" =>  $mail,
  //     "login" =>  $login,
  //     "password" =>  Security::chiffrer($password),
  //     "nonce" => $nonce,
  //   );
  //     $req_prep->execute($values);
  // }


  public static function checkPassword($login,$mot_de_passe_chiffre) {
    $sql = "SELECT * FROM utilisateurs WHERE login=:login AND password=:password";
    $req_prep = Model::$pdo->prepare($sql);
    $sql2 = "SELECT * FROM utilisateurs WHERE mail=:login AND password=:password";
    $req_prep2 = Model::$pdo->prepare($sql2);
    $values = array(
      "login" => $login,
      "password" => $mot_de_passe_chiffre,
    );
    $req_prep->execute($values);
    $req_prep2->execute($values);
    $req_prep->setFetchMode(PDO::FETCH_CLASS, "ModelUtilisateurs");
    $tab = $req_prep->fetchAll();
    $req_prep2->setFetchMode(PDO::FETCH_CLASS, "ModelUtilisateurs");
    $tab2 = $req_prep2->fetchAll();
    if(empty($tab) && empty($tab2)){
      return false;
    }else{
      return true;
    }
  }
  
  public static function getUserbyLogin($login)
  {
    $sql = "SELECT * FROM utilisateurs WHERE login=:log";
    $req_prep = Model::$pdo->prepare($sql);
    $values = array(
      "log" => $login,
    );
    $req_prep->execute($values);
    $req_prep->setFetchMode(PDO::FETCH_CLASS, "ModelUtilisateurs");
    $tab = $req_prep->fetchAll();
    if (empty($tab))
      return false;
    return $tab[0];
  }

    public static function getUserByEmail($email)
  {
    $sql = "SELECT * FROM utilisateurs WHERE email=:email";
    $req_prep = Model::$pdo->prepare($sql);
    $values = array(
      "email" => $email,
    );
    $req_prep->execute($values);
    $req_prep->setFetchMode(PDO::FETCH_CLASS, "ModelUtilisateurs");
    $tab = $req_prep->fetchAll();
    if (empty($tab))
      return false;
    return $tab[0];
  }

  public static function exist($login)
  {
    $sql = 'SELECT * FROM utilisateurs WHERE login=:login';
    $req_prep = Model::$pdo->prepare($sql);
    $values = array(
      "login" => $login,
    );
    $req_prep->execute($values);
    $req_prep->setFetchMode(PDO::FETCH_CLASS, "ModelUtilisateurs");
    $tab = $req_prep->fetchAll();
    if (empty($tab)) {
      return false;
    } else {
      return true;
    }
  }
  public static function setNonceNULL($user)
  {
      $id = $user->id;
    $sql = "UPDATE utilisateurs SET nonce = 'NULL' WHERE id = :id";
    $req_prep = Model::$pdo->prepare($sql);
    $values = array(
      "id" => $id,
    );
    $req_prep->execute($values);
  }

    public static function setPasswordNonceNULL($user)
  {
      $id = $user->id;
    $sql = "UPDATE utilisateurs SET passwordNonce = 'NULL' WHERE id = :id";
    $req_prep = Model::$pdo->prepare($sql);
    $values = array(
      "id" => $id,
    );
    $req_prep->execute($values);
  }

      public static function setPasswordNonce($user, $passwordNonce)
  {
    $sql = "UPDATE utilisateurs SET passwordNonce = :passwordNonce WHERE id = :id";
    $req_prep = Model::$pdo->prepare($sql);
    $values = array(
      "id" => $user->getId(),
      "passwordNonce" => $passwordNonce,
    );
    $req_prep->execute($values);
  }
  
        // public function update($data)
        // {
        //   try {
        //     $sql = "UPDATE utilisateurs SET nom=:nom, prenom=:prenom, password=:password WHERE id=:id";
        //     $req_prep = Model::$pdo->prepare($sql);
        //     $values = array(
        //       "id" => $this->id,
        //       "nom" => $data['nom'],
        //       "prenom" => $data['prenom'],
        //       "password" => Security::chiffrer($data['password']),
        //       //nomdutag => valeur, ...
        //     );
        //     // On donne les valeurs et on exécute la requête   
        //     $req_prep->execute($values);
        //     return true;
        //   } catch (PDOException $e) {
        //     return false;
        //   }
        // }

         public function changePassword($password)
        {
          try {
            $sql = "UPDATE utilisateurs SET password=:password WHERE id=:id";
            $req_prep = Model::$pdo->prepare($sql);
            $values = array(
              "id" => $this->id,
              "password" => Security::chiffrer($password),
              //nomdutag => valeur, ...
            );
            // On donne les valeurs et on exécute la requête   
            $req_prep->execute($values);
            return true;
          } catch (PDOException $e) {
            return false;
          }
        }
}