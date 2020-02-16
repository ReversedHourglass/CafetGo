<?php
$DS = DIRECTORY_SEPARATOR;
$test = __DIR__ . $DS . ".";
require_once $test . '/lib/File.php';
$path = array("lib", "Session.php");
require_once File::build_path($path);
session_start();
// if(!isset($_SESSION['logged'])){
// 	$_SESSION['logged'] = 'false';
// }
if(!isset($_SESSION['panier'])){
    $_SESSION['panier'] = [];
}
$path = array("controller", "routeur.php");
require_once File::build_path($path);
