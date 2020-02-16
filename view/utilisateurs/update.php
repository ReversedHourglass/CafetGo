<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<form method="get" action="index.php?">
    <fieldset>
        <!-- <legend>Formulaire de modification de compte :</legend> -->
        <input type='hidden' name='controller' value='utilisateurs'>
        <input type='hidden' name='action' value='<?php echo(Session::is_admin()?"adminUpdated":"updated")?>'>
        <input type='hidden' name="id" value="<?php echo $id ?>">
        <input type='hidden' name="is_user" value="<?php echo Session::is_user($login)?>">

        <?php 
        $false = "";
        $true = "";
        if($admin == 1){
            $true = "checked";
        }else{
            $false="checked";
        }
        echo(Session::is_admin()?
        '<label>Admin</label> :
            <p>
                <label>
                    <input type="radio" name="admin" value="1" '.$true.'/>
                    <span>True</span>
                </label>
            </p>
            <p>
                <label>
                    <input type="radio" name="admin"  value="0" '.$false.'/>
                    <span>False</span>
                </label>
            </p>'
        :"")?>

        
        <p>
            <label for="prenom">Prénom</label> :
            <input type="text" placeholder="Jean" name="prenom" id="prenom" value="<?php echo htmlspecialchars($prenom) ?>" />
        </p>
        <p>
            <label for="nom">Nom</label> :
            <input type="text" placeholder="Dupont" name="nom" value="<?php echo htmlspecialchars($nom) ?>" id="nom" />
        </p>
        <p>
            <label for="mail">Mail</label> :
            <input type="text" placeholder="jean.dupont@example.com" name="mail" value="<?php echo htmlspecialchars($mail) ?>" id="mail" />
        </p>
        <p>
            <label for="login">Nom d'utilisateur</label> :
            <input type="text" placeholder="jeandup" name="login" value="<?php echo htmlspecialchars($login) ?>" id="login" />
        </p>
        <p>
            <label for="oldpassword">Ancien mot de passe</label> :
            <input type="password" placeholder="JeF3BzI4Dzddz@2_" name="oldpassword" id="oldpassword" />
        </p>
        <p>
            <label for="password">Mot de passe</label> :
            <input type="password" placeholder="JeF3BzI4Dzddz@2_" name="password" id="password" />
        </p>
        <p>
            <label for="password2">Confirmation du mot de passe</label> :
            <input type="password" placeholder="JeF3BzI4Dzddz@2_" name="password2" id="password2" />
        </p>
        <p>
            <input type="submit" value="Envoyer" />
        </p>
    </fieldset>
</form>