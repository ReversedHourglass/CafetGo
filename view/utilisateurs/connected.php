<?php
$tab = ModelProduit::selectAll();     
$controller='produit';
$view='list';
$pagetitle='Liste des produits';
$path = array("view", "produit", "list.php");
require File::build_path($path);
echo("<script> M.AutoInit();</script>");
echo("<script> M.toast({html: 'Bienvenue !'})</script>");
?>