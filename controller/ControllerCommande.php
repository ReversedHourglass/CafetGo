<?php
$path = array("model", "ModelCommande.php");
require_once File::build_path($path);


class ControllerCommande {

    public static function historique() {
            $user = ModelUtilisateurs::select($_GET['userId']);
            if(!$user){
              echo("Cet utilisateur n'existe pas");
            }else{
                if(Session::is_user($user->getLogin())  || Session::is_admin()){
                    $tab = ModelCommande::readAllCommandes($_GET['userId']);


                    $controller='commande';
                    $view='historique';
                    $pagetitle='Historique des commandes';
                    $path = array("view", "view.php");
                    require File::build_path($path);  //"redirige" vers la vue
                }
                else{
                    echo("Vous n'êtes pas autorisé à faire cela");
                }
            }
        }

    public static function error() {
        $controller = 'commande';
        $view = 'error';
        $pagetitle = "Erreur";
        require_once File::build_path(array("view", "view.php"));
    }
}
