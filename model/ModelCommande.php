<?php
require_once File::build_path(array('model', 'Model.php'));

class ModelCommande extends Model
{

  private $idCommande;
  private $idProduit;
  private $quantite;
  protected static $object = 'commande';
  protected static $primary = 'idCommande';

  //Getter
  public function getidCommande()
  {
    return $this->idCommande;
  }

  public function getIdProduit()
  {
    return $this->idProduit;
  }

  public function getQuantite()
  {
    return $this->quantite;
  }

  //Setter
  //...

  //Constructeur
  public function __construct($data = NULL)
  {

    if (!is_null($data) && !empty($data)) {
      // Si aucun de $m, $c et $i sont nuls,
      // c'est forcement qu'on les a fournis
      // donc on retombe sur le constructeur à 3 arguments
      foreach ($data as $key => $value) {
        $this->$key = $value;
      }
    }
  }

    public static function readAllCommandes($userId)
    {
        $sql = "SELECT * FROM commandes C1 JOIN commande C2 ON C1.idCommande = C2.idCOmmande WHERE idUtilisateur = :idUtilisateur";
        $req_prep = Model::$pdo->prepare($sql);
        $values = array(
            "idUtilisateur" => $userId,
        );

        $req_prep->execute($values);
        $req_prep->setFetchMode(PDO::FETCH_CLASS, "ModelCommande");
        $tab = $req_prep->fetchAll();
        if (empty($tab)){
            return false;
        }else{
            $tabCommandes = array();

            foreach($tab as $prodCommande) {
                $isIn =  false;
                $count = 0;
                $countValue = 0;

                foreach($tabCommandes as $comm) {
                    if($prodCommande->getidCommande() == $comm[0]->getidCommande()){
                        $isIn = true;
                        $countValue= $count;
                    }
                    $count = $count + 1;
                }

                if (!$isIn){
                    $tabCommandes[] = array($prodCommande);
                }else{
                    $tabCommandes[$countValue][] = $prodCommande;
                }
            }
            return $tabCommandes;
        }
    }
public static function createCommande($user){
    $sql = "INSERT INTO commandes (idUtilisateur) VALUES (:idUtilisateur)";
    $req_prep = Model::$pdo->prepare($sql);

    $values = array(
        "idUtilisateur" => $user,
    );
    $req_prep->execute($values);
}

 public static function getLastOrder($user)
     {
         $sql = "SELECT MAX(idCommande) FROM commandes";
         $req_prep = Model::$pdo->prepare($sql);

         $values = array(
             "idUtilisateur" => $user,
         );
         $req_prep->execute();
         $idCommande = $req_prep->fetch();
         return $idCommande[0];}
}
