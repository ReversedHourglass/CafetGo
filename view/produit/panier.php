<?php
echo('<div class="row">');
foreach($_SESSION['panier'] as $prod) {
    $p = ModelProduit::select($prod[0]);
    $id = htmlspecialchars($p->getId());
    $nom = htmlspecialchars($p->getNom());
    $prix = htmlspecialchars($p->getPrix());
    $description = htmlspecialchars($p->getDescription());
    $image = "http://webinfo.iutmontp.univ-montp2.fr/~alegret/PHP/CafetGo/images/" . htmlspecialchars($p->getImage());
    $quantite = $prod[1];
    $prixTotalArticle = $quantite * $prix;

    $bar = <<<EOT
<div class="col s6 m3">
	<div class="card center">
		<div class="card-image waves-effect waves-block waves-light">
			<img class="activator responsive-img" src="$image" alt="produit">
		</div>
		<div class="card-content">
			<span class="card-title activator grey-text text-darken-4">$nom<i class="material-icons right">more_vert</i></span>
			<a class="waves-effect waves-light btn-small grey" href="index.php?action=removeFromCart&id=$id"><i class="material-icons left">remove</i>Remove</a>
            <p>Quantité : $quantite</p>
			<p>$prixTotalArticle €</p>
		</div>
		<div class="card-reveal">
			<span class="card-title grey-text text-darken-4">$nom<i class="material-icons right">close</i></span>
			<p class="desc">$description</p>
		</div>
	</div>
</div>
EOT;

    echo $bar;
}
echo('</div>');
?>
<a class="waves-effect waves-light btn-small red" href="index.php?action=viderPanier"><i class="material-icons left">clear_all</i>Vider</a>
<a class="waves-effect waves-light btn-small green" href="index.php?action=acheter"><i class="material-icons left">store</i>Acheter</a>