<?php
require_once File::build_path(array('model', 'Model.php'));

class ModelProduit extends Model
{

  private $id;
  private $nomproduit;
  private $prixproduit;
  private $description;
  private $imageURL;
  protected static $object = 'produit';
  protected static $primary = 'id';

  //Getter
  public function getNom()
  {
    return $this->nomproduit;
  }

  public function getPrix()
  {
    return $this->prixproduit;
  }

  public function getDescription()
  {
    return $this->description;
  }

  public function getImage()
  {
    return $this->imageURL;
  }

    public function getId()
    {
        return $this->id;
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

}
