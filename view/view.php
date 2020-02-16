<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <title><?php echo $pagetitle; ?></title>
  <!--Import Google Icon Font-->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <!-- Compiled and minified CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
  <link rel="stylesheet" href="./view/style.css">
  <script type = "text/javascript" src = "https://code.jquery.com/jquery-2.1.1.min.js"> </script>   
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>           
  <!--Let browser know website is optimized for mobile-->
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>

<body>

<header>
  <nav>
    <div class="nav-wrapper red">
      <a href="#" class="brand-logo">CafetGo</a>
      <ul id="nav-mobile" class="right hide-on-med-and-down">
        <li><a href="index.php">Produits</a></li>
        <li><a href="index.php?action=panier">Mon panier</a></li>
        <?php 
        if(Session::is_admin()){
          echo('<li><a href="index.php?controller=produit&action=create">Créer un produit</a></li>');
          echo('<li><a href="index.php?controller=utilisateurs&action=readAll">Liste des utilisateurs</a></li>');
        }
        if(!isset($_SESSION['login'])){
          echo('<li><a href="index.php?controller=utilisateurs&action=register">Créer un compte</a></li>');
          echo('<li><a href="index.php?controller=utilisateurs&action=login">Connexion</a></li>');
        }else{
            echo('<li><a href="index.php?controller=utilisateurs&action=profile&login=' . urlencode($_SESSION['login']) .'"' . '>Mon profil</a></li>');
            echo('<li><a href="index.php?controller=commande&action=historique&userId=' . ModelUtilisateurs::getUserbyLogin($_SESSION['login'])->getId() .'"' . '>Historique</a></li>');
            echo('<li><a href="index.php?controller=utilisateurs&action=deconnect">Déconnexion</a></li>');
        }
        ?>
      </ul>
    </div>
  </nav>
</header>

<main>
  <div class="container">
    <?php
      $filepath = File::build_path(array("view", $controller, "$view.php"));
      require $filepath;
    ?>
  </div>
</main>

<footer class="page-footer red">
  <div class="container">
    <div class="row">
      <div class="col l6 s12">
        <h5 class="white-text">CafetGo</h5>
        <p class="grey-text text-lighten-4">Achetez vos produits de la cafétéria en ligne</p>
      </div>
    </div>
  </div>
  <div class="footer-copyright">
    <div class="container">
      ©<?php echo date("Y"); ?> CafetGo
    </div>
  </div>
</footer>
</body>

</html>