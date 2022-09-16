<?php
require("classes/connectDB.php");
require("classes/contentManagement.php");
$conn = Database::connect();
$select = $conn->prepare("select * from content where page=?");
$select->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Content');
$select->execute(array($name));
$sections=array();
while ($article = $select->fetch()) {
    array_push($sections, $article->contenu);
}

var_dump($sections);
