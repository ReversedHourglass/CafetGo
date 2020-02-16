<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<form method="post" action="index.php?controller=utilisateurs&action=changePasswordForm">
    <fieldset>
        <legend>Formulaire de modification de mot de passe :</legend>
        <input type='hidden' name='controller' value='utilisateurs'>
        <input type='hidden' name='action' value='changePasswordForm'>
        <input type='hidden' name="id" value=<?php echo $id?>>
        <input type='hidden' name="passwordNonce" value=<?php echo $passwordNonce?>>
        <p>
            <label for="password">Mot de passe</label> :
            <input type="password" placeholder="JeF3BzI4Dzddz@2_" name="password" id="password" />
        </p>
        <p>
            <label for="password2">Confirmation du mot de passe</label> :
            <input type="password" placeholder="JeF3BzI4Dzddz@2_" name="password2" id="password2" />
        </p>
        <p>
        <div class="g-recaptcha" data-sitekey="6LdQyMEUAAAAANOtdbpRJugJs43-IFgTBQyPYsNq"></div>
        </p>
        <p>
            <input type="submit" value="Envoyer" />
        </p>
    </fieldset>
</form>