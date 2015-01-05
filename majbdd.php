<?php
$mysqli = new mysqli("localhost" ,"root", "sslover", "jlm");
if ($mysqli->connect_errno) {
    echo "Echec lors de la connexion à MySQL : (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

$queries = file('dbupdate.sql');

foreach ($queries as $query)
if (!$mysqli->query($query))
{
  echo 'Erreur sur la requete "'.$query.'"';
}
