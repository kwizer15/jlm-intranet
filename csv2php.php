<?php
$lines = file('out.txt');
$dsn = 'mysql:dbname=jlm;host=localhost';
$user = 'jlm';
$password = 'Hary_99';
try {
	$pdo = new PDO($dsn,$user,$password);
	$query = $pdo->prepare('INSERT INTO `jlm`.`cities` (`id`, `country_code`, `zip`, `name`) VALUES (NULL, ?, ?, ?)');
} catch (PDOException $e) {
	echo 'Connexion échouée : ' . $e->getMessage();
	exit;
}
$i = 0;
foreach ($lines as $line)
{
    $tab = explode(';',$line);
    foreach($tab as $key=>$t)
    	$tab[$key] = trim(utf8_decode(str_replace('"','',$t)));
    $query->execute($tab);
    $i++;
}
echo $i;
