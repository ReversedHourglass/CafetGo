<?php
require_once File::build_path(array('controller','ControllerProduit.php'));
require_once File::build_path(array('controller','ControllerUtilisateurs.php'));
require_once File::build_path(array('controller','ControllerCommande.php'));
//On met en place l'action de base
if(!isset($_GET['action'])) {
	$_GET['action'] = 'readAll';
}

//On met en place le controller de base
if(!isset($_GET['controller'])) {
	$_GET['controller'] = 'produit';
}
 
// On recupère l'action et le controleur passée dans l'URL
$action = $_GET['action'];
$controller = $_GET['controller'];

//création du nom de classe
$controller_class = 'Controller'.ucfirst($controller);

//On récupère toutes les méthodes de la classe Controller associée
$methodes = get_class_methods ($controller_class);

//vérification si la class et l'action existe bien
if(class_exists($controller_class) && in_array($_GET['action'], $methodes)) {
	$controller_class::$action();
}else{
    if(class_exists($controller_class)){
	$controller_class::error("Erreur 404, tous les chemins mènent à Rome, mais pas celui là");
    }   else{
        echo "Erreur 404, tous les chemins mènent à Rome, mais pas celui là";
    }
}
