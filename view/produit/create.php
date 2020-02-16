<form method="post" action="index.php?action=<?php echo $action?>" enctype="multipart/form-data">
        <fieldset>
            <legend>Mon formulaire :</legend>
            <input type='hidden' name='action' value='<?php echo $action?>'>
            <input type='hidden' name='id' value='<?php echo $id?>'>
            <p>
                <label for="nomproduit">Nom produit</label> :
                <input type="text" placeholder="Panini Jambon" name="nomproduit" value="<?php echo $nomproduit?>" id="nomproduit" required />
            </p>
            <p>
                <label for="prixproduit">Prix</label> :
                <input type="text" placeholder="10" name="prixproduit" value="<?php echo $prixproduit?>" id="prixproduit" required />
            </p>
            <p>
                <label for="description">Description</label> :
                <input type="text" placeholder="Le meilleur des paninis" value="<?php echo $description?>" name="description" id="description" required />
            </p>
            <p>
                <label for="img">Image</label> :
                <input type="file" name="img" id="img" <?php echo $required ?>>
            </p>
            <p>
                <input type="submit" value="Envoyer" />
            </p>
        </fieldset>
    </form>