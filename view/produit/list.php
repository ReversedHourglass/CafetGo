<?php
echo('<div class="row">');
foreach($tab as $p) {
    $id = htmlspecialchars($p->getId());
	$nom = htmlspecialchars($p->getNom());
	$prix = htmlspecialchars($p->getPrix());
	$description = htmlspecialchars($p->getDescription());
    $image = "http://webinfo.iutmontp.univ-montp2.fr/~alegret/PHP/CafetGo/images/" . htmlspecialchars($p->getImage());

    if(Session::is_admin()){
		$modifier = '<a class="waves-effect waves-light btn-small" href="index.php?action=update&id='.$id.'"><i class="material-icons left">edit</i>update</a>';
		$supprimer = '<a class="waves-effect waves-light btn-small" href="index.php?action=delete&id='.$id.'" onClick="return confirm(\'Supprimer ce produit ?\')"><i class="material-icons left">delete</i>delete</a>';
    }else{
    	$modifier = "";
    	$supprimer = "";
    }

$bar = <<<EOT
<div class="col s6 m3">
	<div class="card center">
		<div class="card-image waves-effect waves-block waves-light">
			<img class="activator responsive-img" src="$image" alt="produit">
		</div>
		<div class="card-content">
			<span class="card-title activator grey-text text-darken-4">$nom<i class="material-icons right">more_vert</i></span>
			<p>
			$prix €
			<a class="waves-effect waves-light btn-small green" href="index.php?action=addToCart&id=$id"><i class="material-icons left">add</i>add</a>
			</p>
			$modifier
			$supprimer
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
