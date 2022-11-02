<?php
class Database
{
    public static function connect()
    {
        //read from key file
        $db = "bordeauxx";
        $host = "localhost";
        $dsn = "mysql:dbname=$db; host=$host";
        $user = "root";
        $password = "";
        $conn = null;
        try {
            $conn = new PDO(
                $dsn,
                $user,
                $password,
                array(
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8", /* définit l'encodage pour récupérer et envoyer des données */
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
