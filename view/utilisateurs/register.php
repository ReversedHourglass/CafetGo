        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
        <form method="post" action="index.php?controller=utilisateurs&action=registered">
            <fieldset>
                <legend>Formulaire de création de compte :</legend>
                <input type='hidden' name='controller' value='utilisateurs'>
                <input type='hidden' name='action' value='registered'>
                <p>
                    <label for="prenom">Prénom</label> :
                    <input type="text" placeholder="Jean" name="prenom"  id="prenom" value = "<?php echo $prenom?>" required />
                </p>
                <p>
                    <label for="nom">Nom</label> :
                    <input type="text" placeholder="Dupont" name="nom" value="<?php echo $nom?>" id="nom" required />
                </p>
                <p>
                                    <label for="mail">Mail</label> :
                    <input type="email" placeholder="jean.dupont@example.com" name="mail" value="<?php echo $mail?>" id="mail" required />
                </p>
                <p>
                    <label for="mail2">Confirmation mail</label> :
                    <input type="text" placeholder="jean.dupont@example.com" name="mail2" value="<?php echo $mail2?>" id="mail2" required />
                </p>
                         </p>
                        <p class="red-text" <?php echo " $option2"?>>
                    Les emails insérés ne correspondent pas !
                </p>
                <p>
                    <label for="login">Nom d'utilisateur</label> :
                    <input type="text" placeholder="jeandup" name="login" value="<?php echo $login?>" id="login" required />
                </p>
                <p>
                    <label for="password">Mot de passe</label> :
                    <input type="password" placeholder="JeF3BzI4Dzddz@2_" name="password" id="password" required />
                </p>
                <p>
                    <label for="password2">Confirmation du mot de passe</label> :
                    <input type="password" placeholder="JeF3BzI4Dzddz@2_" name="password2" id="password2" required />
                </p>
                        <p class="red-text" <?php echo " $option"?>>
                    Les mots de passes insérés ne correspondent pas !
                </p>
                <p>
                    <div class="g-recaptcha" data-sitekey="6LdQyMEUAAAAANOtdbpRJugJs43-IFgTBQyPYsNq"></div>
                </p>

                <p>
                    <input type="submit" value="Envoyer" />
                </p>
            </fieldset>
        </form>