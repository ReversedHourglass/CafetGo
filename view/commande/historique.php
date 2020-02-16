<?php
if(!$tab){
    echo("Vous n'avez passé aucune commande");
}else{
    $count = 0;
    echo("<table class=\"striped centered\"><thead><tr><th>Commandes</th></tr></thead><tbody>");
    foreach($tab as $comm) {
        echo("<tr><td>");
        echo("Commande " . $count);
        echo('<div class="row">');
        foreach($comm as $commandeProduit) {
            $p = ModelProduit::select($commandeProduit->getIdProduit());
            $id = htmlspecialchars($p->getId());
            $nom = htmlspecialchars($p->getNom());
            $prix = htmlspecialchars($p->getPrix());
            $description = htmlspecialchars($p->getDescription());
            $image = "http://webinfo.iutmontp.univ-montp2.fr/~alegret/PHP/CafetGo/images/" . htmlspecialchars($p->getImage());
            $quantite = $commandeProduit->getQuantite();
            $prixTotalArticle = $quantite * $prix;
            $bar = <<<EOT
                    <div class="col s6 m3">
                        <div class="card">
                            <div class="card-image waves-effect waves-block waves-light">
                                <img class="activator responsive-img" src="$image" alt="produit">
                            </div>
                            <div class="card-content">
                                <span class="card-title activator grey-text text-darken-4">$nom<i class="material-icons right">more_vert</i></span>
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
        $count = $count + 1;
        echo("</td></tr>");
}
echo("</tbody></table>");
}