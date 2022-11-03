<?php

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
    public $promotion;
    public $chauffeur;
    public $num_places;
    public $paid;
    public $certificat;
    public $root;

    public static function connectUser()
    {
        global $conn;
        extract($_POST);
        $select = $conn->prepare("SELECT * FROM users WHERE mail=?");
        $select->setFetchMode(PDO::FETCH_CLASS, 'Users');
        $select->execute(array($mail));
        $n = $select->rowCount();

        if ($n == 0) {
            //Il n'y a pas de mail comme celui-ci dans la BDD
            $_SESSION["displayError"] = "Erreur de connexion, il n'y a pas de compte associé à ce mail";
            return false;
        } elseif ($n > 1) {
            $_SESSION["displayError"] = "Erreur côté serveur contacter l'admin";
            return false;
        } else {
            $user = $select->fetch();
            if (password_verify($mdp, $user->hash)) {
                session_unset();
                $_SESSION["id"] = $user->id;
                $_SESSION["root"] = $user->root;
                if ($user->prenom != null) {
                    $_SESSION["name"] = $user->prenom;
                }
                $update = $conn->prepare("update users set lastConn=CURRENT_TIMESTAMP WHERE id=?");
                $update->execute(array($user->id));

                $_SESSION["displayValid"] = "Vous êtes bien connecté";
                return true;
            } else {
                $_SESSION["displayError"] = "Mot de passe incorrect, veuillez réessayer";
                return false;
            }
        }
    }

    public static function newUser()
    {
        global $conn;
        extract($_POST);
        if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
            $_SESSION["displayError"] = "Le mail n'est pas valide. Veuillez vérifier votre mail.";
            return false;
        }
        extract(Users::CorrectPWD($mdp1, $mdp2)); /* on récupère $corr et $msg */
        if (!$corr) {
            $_SESSION["displayError"] = $msg;
            return false;
        } else {
            $mail = htmlspecialchars($mail);
            $select = $conn->prepare('SELECT * FROM users WHERE mail=?');
            $select->execute(array($mail));
            if ($select->rowCount() > 0) {
                $_SESSION["displayError"] = "Il y a déjà un compte associé à ce mail.";
                return false;
            } else {
                $options = ["cost" => 14,];
                $hash = password_hash($mdp1, PASSWORD_BCRYPT, $options);

                $insert = $conn->prepare("insert into users (mail, hash) values (?,?)");
                $insert->execute(array($mail, $hash));

                $select = $conn->prepare('SELECT id FROM users WHERE mail=?');
                $select->execute(array($mail));
                $select->setFetchMode(PDO::FETCH_CLASS, 'Users');
                $id = $select->fetch()->id;

                $_SESSION["id"] = $id;

                $_SESSION["displayValid"] = "Votre compte a bien été créé.";
                return true;
            }
        }
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

    public static function uploadCertificat($dossier, $name)
    {
        global $conn;
        $certif = new Upload(array("pdf", "PDF"), 500000, $dossier);
        $file = $_FILES['certificat'];
        if ($certif->upload($name, $file)) {
            $update = $conn->prepare("UPDATE users SET certificat=true WHERE id=?");
            $update->execute(array($_SESSION["id"]));
        }
    }

    public static function updateInfos()
    {
        global $conn;
        $id = $_SESSION["id"];
        foreach ($_POST as $key => $value) {
            $_POST[$key] = htmlspecialchars($value);
        }
        extract($_POST);
        if ($type == "chauffeur") {
            $update = $conn->prepare("UPDATE users SET prenom=?, nom=?, promotion=?, chauffeur=?, num_places=?  WHERE id=?");
            $update->execute(array($firstname, $surname, $promo, 1, $num_places, $id));
        } else {
            //je vérifie que c'est bien un coureur
            $update = $conn->prepare("UPDATE users SET prenom=?, nom=?, promotion=?, chauffeur=?  WHERE id=?");
            $update->execute(array($firstname, $surname, $promo, 0, $id));
        }
        $_SESSION["name"] = $firstname;
    }

    public static function getUserPersonnalData()
    {
        global $conn;
        $select = $conn->prepare("SELECT nom, prenom, hash, promotion, chauffeur, paid, certificat FROM users WHERE id=?");
        $select->setFetchMode(PDO::FETCH_CLASS, 'Users');
        $select->execute(array($_SESSION["id"]));
        return $select->fetch();
    }

    public function avancement()
    {
        $score = 0;
        if (!$this->chauffeur)
            $n = 4; // nombre d'onglets
        else
            $n = 2;
        $x = 1 / $n;
        if ($this->prenom != null && $this->nom != null && $this->promotion != null)
            $score += $x;
        if ($this->paid)
            $score += $x;
        if ($this->certificat)
            $score += $x;
        return $score;
    }

    public static function isRoot()
    {
        global $name;
        if (!array_key_exists("root", $_SESSION) || !$_SESSION["root"]) {
            $_SESSION["displayError"] = "Vous devez avoir les droits d'administrateur pour accéder à la page $name";
            return false;
        } else
            return true;
    }

    public static function isConnected()
    {
        global $name;
        if (!array_key_exists("id", $_SESSION)) {
            $_SESSION["displayError"] = "Vous devez être connecté pour accéder à la page $name";
            return false;
        } else
            return true;
    }
}
