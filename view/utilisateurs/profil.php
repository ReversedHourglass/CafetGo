<?php
$user = ModelUtilisateurs::getUserbyLogin($_GET['login']);
$login = urlencode($_GET['login']);
$nom = htmlspecialchars($user->getNom());
$prenom = htmlspecialchars($user->getPrenom());
$email = htmlspecialchars($user->getMail());

    if(Session::is_user($_GET['login'])  || Session::is_admin()){

$modif = <<<EOT
    <div class="card-action">
        <a href="index.php?controller=utilisateurs&action=update&login=$login">Modifier profil</a>
    </div>
EOT;

}else{
    $modif = "";
}


$bar = <<<EOT

<div class="row">
    <div class="col s12 m6">
        <div class="card  blue-grey lighten-2s">
            <div class="card-content white-text">
            <p>Nom: $nom</p>
            <p>Prenom: $prenom</p>
            <p>Login: $login</p>
            <p>Email: $email</p>
            </div>
            $modif
        </div>
    </div>
</div>         
EOT;
echo($bar);
?>