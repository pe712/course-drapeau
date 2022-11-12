<?php
class Database
{
    public static function connect()
    {
        if (basename(getcwd()) == "htdocs")
            require("../config.php");
        else
            require("../../config.php");

        $conn = null;
        try {
            $conn = new PDO(
                $dsn,
                $user,
                $password,
                array(
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4", /* définit l'encodage pour récupérer et envoyer des données */
                    PDO::ATTR_PERSISTENT => true
                )
            );
            $conn->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );
        } catch (PDOException $e) {
            echo "Connexion échouée: " . $e->getMessage();
            exit(0);
        }
        return $conn;
    }
}
