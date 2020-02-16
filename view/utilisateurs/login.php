<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<form method="post" action="index.php?controller=utilisateurs&action=connected">
    <fieldset>
        <legend>Formulaire de connexion</legend>
        <input type='hidden' name='controller' value='utilisateurs'>
        <input type='hidden' name='action' value='connected'>
        <p>
            <label for="login">Nom d'utilisateur / E-mail</label> :
            <input type="text" placeholder="jeandup" name="login" id="login" value="<?php echo $login?>" required />
        </p>
        <p>
            <label for="password">Mot de passe</label> :
            <input type="password" placeholder="JeF3BzI4Dzddz@2_" name="password" id="password" required />
        </p>
        <p>
            <a href="index.php?controller=utilisateurs&action=forgotPassword">Mot de passe oublié ?</a>
        </p>
        <p>
            <div class="g-recaptcha" data-sitekey="6LdQyMEUAAAAANOtdbpRJugJs43-IFgTBQyPYsNq"></div>
        </p>
        <p>
            <input type="submit" value="Envoyer" />
        </p>
    </fieldset>
</form>