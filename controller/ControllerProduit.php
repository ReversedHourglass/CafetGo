<?php
$path = array("model", "ModelProduit.php");
require_once File::build_path($path);

class ControllerProduit {
    public static function readAll() {
        $tab = ModelProduit::selectAll();     //appel au modèle pour gerer la BD
        $controller='produit';
        $view='list';
        $pagetitle='Liste des produits';
        $path = array("view", "view.php");
        require File::build_path($path);  //"redirige" vers la vue
    }

    public static function create() {
        if(Session::is_admin()){
            $id = "";
            $required = 'required';
            $controller='produit';
            $view='create';
            $pagetitle='Création de produit';
            $action = 'created';
            $nomproduit = '';
            $prixproduit = '';
            $description = '';
            $path = array("view", "view.php");
            require File::build_path($path);  //"redirige" vers la vue
        }else{
            self::error("Vous n'êtes pas administrateur");
        }

    }

    public static function created() {
        if(Session::is_admin()){
            if (!empty($_FILES['img']) && is_uploaded_file($_FILES['img']['tmp_name'])){
                $allowed_ext = array("jpg", "jpeg", "png");
                $explosion = explode('.',$_FILES['img']['name']);
                if (!in_array(end($explosion), $allowed_ext)) {
                    self::error("Mauvais type de fichier");
                }else{
                    $name = $_FILES['img']['name'];
                    $path = array("images", "$name");
                    $pic_path = File::build_path($path);
                    if (!move_uploaded_file($_FILES['img']['tmp_name'], $pic_path)) {
                        self::error("la copie du fichier a échoué ");
                    }else{

                         $mv = new ModelProduit($_POST);
                         $data = array(
                            "nomproduit" => $mv->getNom(),
                            "prixproduit" => $mv->getPrix(),
                            "description" => $mv->getDescription(),
                            "imageURL" => $name,
                    );
                    ModelProduit::save($data);
                    self::readAll();
                    }
                }
            }
        }else{
            self::error("Vous n'êtes pas administrateur");
        }
    }

    public static function update() {
        if(Session::is_admin()){
            $required = "";
            $controller='produit';
            $view='create';
            $pagetitle='Modification de produit';
            $action = 'updated';
            $prod = ModelProduit::select($_GET['id']);
            $id=$_GET['id'];
            $nomproduit = $prod->getNom();
            $prixproduit = $prod->getPrix();
            $description = $prod->getDescription();
            $path = array("images", $prod->getImage()); 
            $image = File::build_path($path);;
            $path = array("view", "view.php");
            require File::build_path($path);  //"redirige" vers la vue
        }else{
            self::error("Vous n'êtes pas administrateur");
        }
    }

    public static function updated() {
        if(Session::is_admin()){
            if (!empty($_FILES['img']) && is_uploaded_file($_FILES['img']['tmp_name'])){
                $allowed_ext = array("jpg", "jpeg", "png");
                $explosion = explode('.',$_FILES['img']['name']);
                if (!in_array(end($explosion), $allowed_ext)) {
                    self::error("Mauvais type de fichier");
                }else{
                    $name = $_FILES['img']['name'];
                    $path = array("images", "$name");
                    $pic_path = File::build_path($path);
                    if (!move_uploaded_file($_FILES['img']['tmp_name'], $pic_path)) {
                        self::error("La copie a échoué");
                    }else{
                    $mv = new ModelProduit($_POST);
                    $data = array(
                        "id" => $mv->getId(),
                        "nomproduit" => $mv->getNom(),
                        "prixproduit" => $mv->getPrix(),
                        "description" => $mv->getDescription(),
                        "imageURL" => $name,
                    );
                    ModelProduit::update($data);
                    self::readAll();
                    }
                 
                }
            }else{
                $mv = new ModelProduit($_POST);
                $data = array(
                        "id" => $mv->getId(),
                        "nomproduit" => $mv->getNom(),
                        "prixproduit" => $mv->getPrix(),
                        "description" => $mv->getDescription(),
                    );
                ModelProduit::update($data);
                self::readAll();
            }
        }else{
            self::error("Vous n'êtes pas administrateur");
        }
    }

    public static function addToCart(){
        $count = 0;
        $isIn =  false;
        foreach($_SESSION['panier'] as $p) {
            if(strcmp($p[0], $_GET['id']) == 0){
                $_SESSION['panier'][$count][1] = $p[1] + 1;
                $isIn = true;
            }
            $count = $count + 1;
        }

        if (!$isIn){
            $_SESSION['panier'][] = array($_GET['id'], 1);
        }

        ControllerProduit::readAll();
    }

    public static function panier(){
        $controller='produit';
        $view='panier';
        $pagetitle='Panier';
        $path = array("view", "view.php");
        require File::build_path($path);  //"redirige" vers la vue
    }

    public static function viderPanier(){
        $_SESSION['panier'] = [];
        ControllerProduit::readAll();
    }

    public static function removeFromCart(){
        $count = 0;
        foreach($_SESSION['panier'] as $p) {
            if(strcmp($p[0], $_GET['id']) == 0){
                if($_SESSION['panier'][$count][1] - 1 == 0){
                    unset($_SESSION['panier'][$count]);
                }else{
                    $_SESSION['panier'][$count][1] = $p[1] - 1;
                }
            }
            $count = $count + 1;
        }

        ControllerProduit::panier();
}

    public static function acheter() {
        if(!empty($_SESSION['login'])){
            ModelCommande::createCommande(ModelUtilisateurs::getUserbyLogin($_SESSION['login'])->getId());
            $lastOrder = ModelCommande::getLastOrder(ModelUtilisateurs::getUserbyLogin($_SESSION['login'])->getId());
            foreach ($_SESSION['panier'] as $p){
                $values = array(
                    "idCommande" => $lastOrder,
                    "idProduit" => $p[0],
                    "quantite" => $p[1],
                );
                ModelCommande::save($values);
            }
            self::viderPanier();
        }else{
            ControllerUtilisateurs::login();
        }

    }

    public static function error($error) {
        $controller = 'produit';
        $view = 'error';
        $pagetitle = "Erreur";
        require_once File::build_path(array("view", "view.php"));
    }

    public static function delete(){
        if(Session::is_admin()){
            ModelProduit::delete($_GET['id']);
        }
        ControllerProduit::readAll();
    }
}
