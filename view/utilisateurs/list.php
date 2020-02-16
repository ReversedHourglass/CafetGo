<?php
	echo('<table class="striped">
			<thead>
				<tr>
					<th>Nom</th>
					<th>Prenom</th>
					<th>Login</th>
					<th>Admin</th>
					<th></th>
					<th></th>
				</tr>
			</thead>
			<tbody>');
	

	foreach($tab as $p) {

		$login = htmlspecialchars($p->getLogin());
		$nom = htmlspecialchars($p->getNom());
		$prenom = htmlspecialchars($p->getPrenom());
		$admin = htmlspecialchars($p->getAdmin());

$bar = <<<EOT
<tr>	
<td>$nom</td>
<td>$prenom</td>
<td>$login</td>
<td>$admin</td>
<td><a href="index.php?controller=utilisateurs&action=update&login=$login">Modifier</a></td>
<td><a href="index.php?controller=utilisateurs&action=delet&login=$login">Supprimer</a></td>
</tr>
EOT;
				
		echo $bar;
	};
	echo('</tbody></table>')
	?>
