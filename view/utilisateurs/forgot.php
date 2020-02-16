<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<form method="post" action="index.php?controller=utilisateurs&action=forgottedPassword">
    <fieldset>
        <legend>Formulaire d'oubli de mot de passe :</legend>
        <input type='hidden' name='controller' value='utilisateurs'>
        <input type='hidden' name='action' value=forgottedPassword>
        <p>
            <label for="login">Nom d'utilisateur</label> :
            <input type="text" placeholder="jeandup" name="login" id="login" />
        </p>
        <p>
        <div class="g-recaptcha" data-sitekey="6LdQyMEUAAAAANOtdbpRJugJs43-IFgTBQyPYsNq"></div>
        </p>
        <p>
            <input type="submit" value="Envoyer" />
        </p>
    </fieldset>
</form>

