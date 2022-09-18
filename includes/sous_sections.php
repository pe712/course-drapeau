<?php
require("classes/connectDB.php");
require("classes/contentManagement.php");
$conn = Database::connect();
$select = $conn->prepare("SELECT COUNT(DISTINCT(section)) FROM content WHERE page=?");
$select->execute(array($name));
$n_sec = $select->fetch()[0];

$sections=array();
for ($i=0; $i < $n_sec; $i++) { 
    $select = $conn->prepare("SELECT * FROM content WHERE page=? AND section=$i+1");
    $select->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Content');
    $select->execute(array($name));
    $sous_section = array();
    while ($article = $select->fetch()) {
        array_push($sous_section, $article->contenu);
    }
    array_push($sections, $sous_section);
}




