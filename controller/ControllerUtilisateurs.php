<?php
$path = array("model", "ModelUtilisateurs.php");
require_once File::build_path($path);
$path = array("lib", "Security.php");
require_once File::build_path($path);

class ControllerUtilisateurs
{
    public static function readAll()
    {
        if (Session::is_admin()) {
            $tab = ModelUtilisateurs::selectAll();     //appel au modèle pour gerer la BD
            $controller = 'utilisateurs';
            $view = 'list';
            $pagetitle = 'Liste des produits';
            $path = array("view", "view.php");
            require File::build_path($path);  //"redirige" vers la vue
        } else {
            ControllerUtilisateurs::error();
        }
    }

    public static function register()
    {
        // $action = "registered";
        if (isset($_POST["prenom"])) {
            $prenom = $_POST["prenom"];
            $nom = $_POST["nom"];
            $mail = $_POST["mail"];
            $mail2 = $_POST["mail2"];
            $login = $_POST["login"];
            $option = $_POST["option"];
            $option2 = $_POST["option2"];
        } else {
            $prenom = "";
            $nom = "";
            $mail = "";
            $mail2 = "";
            $login = "";
            $option = "hidden";
            $option2 = "hidden";
        }

        $controller = 'utilisateurs';
        $view = 'register';
        $pagetitle = 'Créer un compte';
        $path = array("view", "view.php");
        require File::build_path($path);  //"redirige" vers la vue
    }

    public static function registered()
    {

        $controller = 'utlisateurs';
        if (filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {


            // echo($_GET['mail'] . " est une adresse valide");
            if ($_POST['password'] != $_POST['password2'] && $_POST['mail'] != $_POST['mail2']) {
                $_POST["mail2"] = "";
                $_POST["mail"] = "";
                $_POST["option2"] = "";
                $_POST["option"] = "";
                self::register();
            } else {
                if ($_POST['password'] == $_POST['password2']) {
                    if ($_POST['mail'] == $_POST['mail2']) {
                        $nonce = Security::generateRandomHex();
                        $_POST['nonce'] = $nonce;
                        $mv = new ModelUtilisateurs($_POST);
                        $data = array(
                            "nom" => $mv->getNom(),
                            "prenom" => $mv->getPrenom(),
                            "login" => $mv->getLogin(),
                            "password" => Security::chiffrer($mv->getPassword()),
                            "mail" => $mv->getMail(),
                            "nonce" => $mv->getNonce(),
                        );
                        ModelUtilisateurs::save($data);
                        // ControllerProduit::readAll();
                        $controller = 'utilisateurs';
                        $view = 'mailConfirmation';
                        $pagetitle = 'Confirmation par mail';
                        $path = array("view", "view.php");
                        require File::build_path($path);  //"redirige" vers la vue

                        mail($mv->getMail(), "Inscription à CafetGo", "http://webinfo.iutmontp.univ-montp2.fr/~alegret/PHP/CafetGo/index.php?controller=utilisateurs&action=validate&login=" . $mv->getLogin() . "&nonce=" . $mv->getNonce());
                    } else {

                        $_POST["mail2"] = "";
                        $_POST["mail"] = "";
                        $_POST["option2"] = "";
                        $_POST["option"] = "hidden";
                        self::register();
                    }
                } else {

                    $_POST["option2"] = "hidden";
                    $_POST["option"] = "";
                    self::register();
                }
            }
        } else {
            self::error($_POST['mail'] . " n'est pas une adresse valide");
        }
    }

    public static function login()
    {
        $controller = 'utilisateurs';
        $view = 'login';
        $pagetitle = 'Connexion';
        if (isset($_POST['login'])) {
            $login = $_POST['login'];
        } else {
            $login = "";
        }
        $path = array("view", "view.php");
        require File::build_path($path);  //"redirige" vers la vue
    }

    public static function deconnect()
    {
        $controller = 'utilisateurs';
        $view = 'deconnect';
        $pagetitle = 'Déconnexion';
        $path = array("view", "view.php");
        session_unset();     // unset $_SESSION variable for the run-time
        session_destroy();   // destroy session data in storage
        setcookie(session_name(), '', time() - 1); // deletes the session cookie containing the session ID
        require File::build_path($path);  //"redirige" vers la vue
    }

    public static function connected()
    {
        $controller = 'utilisateurs';
        $view = 'connected';
        $pagetitle = 'Connexion';

        $login = $_POST['login'];
        $password = Security::chiffrer($_POST['password']);

        if (ModelUtilisateurs::checkPassword($login, $password)) {
            $user = ModelUtilisateurs::getUserbyLogin($login);
            if ($user == false) {
                $user = ModelUtilisateurs::getUserByEmail($login);
            }
            if ($user->getNonce() == 'NULL') {
                $admin = $user->getAdmin();
                if ($admin) {
                    $_SESSION['admin'] = true;
                }
                $path = array("view", "view.php");
                $_SESSION['logged'] = 'true';
                $_SESSION['login'] = $login;
                require File::build_path($path);  //"redirige" vers la vue
            } else {
                self::login();
            }
        } else {
            self::login();
        }
        /*  $response = $_GET['g-recaptcha-response'];
if (Security::getCaptchaValidation($response)) {
$mv = new ModelUtilisateurs($_GET);
$mv->save();}
else {
echo"Captcha error";
} */
    }

    public static function profile()
    {
        $user = ModelUtilisateurs::select($_GET['login']);
        $controller = 'utilisateurs';
        $view = 'profil';
        $pagetitle = 'Profil de' . $_GET['login'];
        $path = array("view", "view.php");
        require File::build_path($path);  //"redirige" vers la vue
    }

    public static function update()
    {
        if (Session::is_user($_GET['login'])  || Session::is_admin()) {
            // $action = "updated";
            $user = ModelUtilisateurs::getUserbyLogin($_GET['login']);
            $id = $user->getId();
            $prenom = $user->getPrenom();
            $nom = $user->getNom();
            $mail = $user->getMail();
            $login = $user->getLogin();
            $admin = $user->getAdmin();
            $user = ModelUtilisateurs::select($_GET['login']);
            $controller = 'utilisateurs';
            $view = 'update';
            $pagetitle = 'Modifier mon profil';
            $path = array("view", "view.php");
            require File::build_path($path);  //"redirige" vers la vue
        } else {
            ControllerProduit::readAll();
        }
    }

    public static function updated()
    {
        $login = $_GET['login'];
        $user = ModelUtilisateurs::select($_GET["id"]);

        if (Session::is_user($login)) {
            $data = array(
                "id" => $_GET['id'],
                "prenom" => $_GET['prenom'],
                "nom" => $_GET['nom'],
                "mail" => $_GET['mail'],
                "login" => $_GET['login'],
            );
            if (!empty($_GET["oldpassword"])) {
                if (ModelUtilisateurs::checkPassword($_SESSION['login'], Security::chiffrer($_GET["oldpassword"]))) {
                    if ($_GET["password"] == $_GET["password2"]) {
                        $data["password"] = Security::chiffrer($_GET['password']);
                    } else {
                        ControllerUtilisateurs::update();
                    }
                } else {
                    ControllerUtilisateurs::update();
                }
            }
            $user->update($data);
            $_SESSION['login'] = $_GET['login'];
            ControllerUtilisateurs::profile();
        } else {
            ControllerUtilisateurs::update();
        }
    }

    public static function adminUpdated()
    {
        // $login = $_GET['login'];
        $user = ModelUtilisateurs::select($_GET["id"]);

        if (Session::is_admin()) {
            $data = array(
                "id" => $_GET['id'],
                "prenom" => $_GET['prenom'],
                "nom" => $_GET['nom'],
                "mail" => $_GET['mail'],
                "login" => $_GET['login'],
                "admin" => $_GET['admin'],
            );
            if (!empty($_GET["oldpassword"])) {
                if (ModelUtilisateurs::checkPassword($_SESSION['login'], Security::chiffrer($_GET["oldpassword"]))) {
                    if ($_GET["password"] == $_GET["password2"]) {
                        $data["password"] = Security::chiffrer($_GET['password']);
                    } else {
                        ControllerUtilisateurs::update();
                    }
                } else {
                    ControllerUtilisateurs::update();
                }
            }
            if ($_GET['is_user'] == true) {
                $_SESSION['login'] = $_GET['login'];
                if ($_GET['admin'] == 0) {
                    $_SESSION['admin'] = false;
                }
            }
            $user->update($data);
            ControllerProduit::readAll();
        } else {
            ControllerUtilisateurs::update();
        }
    }

    public static function forgotPassword()
    {
        $controller = 'utilisateurs';
        $view = 'forgot';
        $pagetitle = "Oubli de mot de passe";
        $path = array("view", "view.php");
        require_once File::build_path($path);
    }

    public static function forgottedPassword()
    {
        $mv = ModelUtilisateurs::getUserbyLogin($_POST['login']);
        if ($mv != false) {

            $passwordNonce = Security::generateRandomHex();
            ModelUtilisateurs::setPasswordNonce($mv, $passwordNonce);

            mail($mv->getMail(), "Oubli de mot de passe pour CafetGo", "http://webinfo.iutmontp.univ-montp2.fr/~alegret/PHP/CafetGo/index.php?controller=utilisateurs&action=changePassword&login=" . $mv->getLogin() . "&passwordNonce=" . $passwordNonce);
            self::login();
        } else {
            self::login();
        }
    }

    public static function changePassword()
    {
        $user = ModelUtilisateurs::getUserbyLogin($_GET['login']);
        if ($user != false & $_GET['passwordNonce'] == $user->getPasswordNonce()) {
            $id = $user->getId();
            $controller = 'utilisateurs';
            $view = 'changePassword';
            $pagetitle = "Changement de mot de passe";
            $path = array("view", "view.php");
            $passwordNonce = $_GET['passwordNonce'];
            require_once File::build_path($path);
        } else {
            self:error("Cet utilisateur n'existe pas ou vous avez utilisé un mauvais lien de confirmation");
        }
    }

    public static function changePasswordForm()
    {
        $user = ModelUtilisateurs::select($_POST['id']);
        if ($_POST['password'] == $_POST['password2'] & $_POST['passwordNonce'] == $user->getPasswordNonce()) {

            $user->changePassword($_POST['password']);
            ModelUtilisateurs::setPasswordNonceNULL($user);
            self::login();
        }
    }


    public static function error($error)
    {
        $controller = 'utilisateurs';
        $view = 'error';
        $pagetitle = "Erreur";
        require_once File::build_path(array("view", "view.php"));
    }

    public static function validate()
    {
        $user = ModelUtilisateurs::getUserbyLogin($_GET['login']);
        if (ModelUtilisateurs::exist($_GET['login']) & $_GET['nonce'] == $user->getNonce()) {
            ModelUtilisateurs::setNonceNULL($user);
            ControllerUtilisateurs::login();
        } else {
            self::error("Cet utilisateur n'existe pas ou vous avez utilisé un mauvais lien de confirmation");
        }
    }

    public static function delet(){
        $login = $_SESSION['login'];
        if(Session::is_admin() || Session::is_user($login)){
            $user = ModelUtilisateurs::getUserbyLogin($login);
            if($user != false){
                ModelUtilisateurs::delete($user->getId());
                if(Session::is_user($login)){
                    ControllerUtilisateurs::deconnect();
                }else{
                    ControllerProduit::readAll();
                }
            }else{
                ControllerUtilisateurs::error();
            }
        }else{
            ControllerProduit::readAll();
        }
    }
}
