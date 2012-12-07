<?php
$lines = file('out.txt');
$dsn = 'mysql:dbname=jlm;host=localhost';
$user = 'root';
$password = 'sslover';
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
    $line = utf8_decode(str_replace('"','',$line));
    $query->execute(explode(';',$line));
    $i++;
}
echo $i;
