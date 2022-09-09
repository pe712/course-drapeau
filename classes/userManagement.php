
<?php
require("ConnectDB.php");

class Users
{
    public $id;
    public $mail;
    public $hash;
    public $creationTime;
    public $valid;
    public $lastConn;
    public $nom;
    public $prenom;
    public $age;

    public static function connectUser()
    {
        extract($_POST);
        $conn = Database::connect();
        $select = $conn->prepare("select * from login where mail=?");
        $select->setFetchMode(PDO::FETCH_CLASS,'Users');
        $select->execute(array($mail));
        $n = $select->rowCount();

        if ($n == 0) {
            //Il n'y a pas de mail comme celui-ci dans la BDD
            $_SESSION["displayError"] = "Erreur de connexion, il n'y a pas de compte associé à ce mail";
            header("location:index.php?page=Connect");
            die();
        } elseif ($n > 1) {
            $_SESSION["displayError"] = "Erreur côté serveur contacter l'admin";
            header("location:index.php?page=Connect");
            die();
        } else {
            $user = $select->fetch();
            if (password_verify($mdp, $user->hash)) {

                session_regenerate_id(true);
                $_SESSION["id"] = $user->id;

                $update = $conn->prepare("update login set lastConn=CURRENT_TIMESTAMP where id=?");
                $update->execute(array($user->id));

                $_SESSION["displayValid"] = "Vous êtes bien connecté";
                header("location:index.php?page=Acceuil");
                die();
            } else {
                $_SESSION["displayError"] = "Mot de passe incorrect, veuillez réessayer";
                header("location:index.php?page=Connect");
                die();
            }
        }
        $conn = null;
    }

    public static function newUser()
    {
        extract($_POST);
        $conn = Database::connect();

        if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
            $_SESSION["displayError"] = "Le mail n'est pas valide. Veuillez vérifier votre mail.";
            header("location:index.php?page=Inscription");
            die();
        }
        extract(Users::CorrectPWD($mdp1, $mdp2)); /* on récupère $corr et $msg */
        if (!$corr) {
            $_SESSION["displayError"] = $msg;
            header("location:index.php?page=Inscription");
            die();
        } else {
            $select = $conn->prepare('select * from login where mail=?');
            $select->execute(array($mail));
            if ($select->rowCount() > 0) {
                $_SESSION["displayError"] = "Il y a déjà un compte associé à ce mail.";
                header("location:index.php?page=Acceuil.php");
                die();
            } else {
                $options = ["cost" => 14,];
                $hash = password_hash($mdp1, PASSWORD_BCRYPT, $options);

                $insert = $conn->prepare("insert into login (mail, hash) values (?,?)");
                $insert->execute(array($mail, $hash));

                $select = $conn->prepare('select id from login where mail=?');
                $select->execute(array($mail));
                $id = $select->fetch()[0];

                $_SESSION["id"] = $id;

                $_SESSION["displayValid"] = "Votre compte a bien été créé.";
                header("location:index.php?page=Acceuil");
                die();
            }
        }
        $conn = null;
    }

    private static function CorrectPWD($mdp1, $mdp2)
    {
        $n = strlen($mdp1);
        $min = "~[a-z]~";
        $maj = "~[A-Z]~";
        $chiffre = "~[0-9]~";
        $special = "~[^a-zA-Z0-9]~";
        if ($mdp1 != $mdp2) {
            $corr = false;
            $msg = 'Les mots de passe ne sont pas identiques. ';
        } elseif ($n < 8) {
            $corr = false;
            $msg = 'Le mot de passe doit faire au moins 8 caractères. ';
        } elseif (!preg_match($maj, $mdp1) or !preg_match($min, $mdp1)) {
            $corr = false;
            $msg = 'Il faut au moins une minucscule et une majuscule. ';
        } elseif (!preg_match($chiffre, $mdp1)) {
            $corr = false;
            $msg = 'Il faut au moins un chiffre. ';
        } elseif (!preg_match($special, $mdp1)) {
            $corr = false;
            $msg = 'Il faut au moins un caractère spécial. ';
        } else {
            $corr = true;
            $msg = null;
        }

        $ret = array(
            "corr" => $corr,
            "msg" => $msg,
        );
        return $ret;
    }

}
