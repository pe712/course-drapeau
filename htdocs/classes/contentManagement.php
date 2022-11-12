<?php
class Content
{
    public $page;
    public $section;
    public $item;
    public $contenu;
    public $description;

    public static function update_db()
    {
        global $conn;
        extract($_POST);
        $select = $conn->query("SELECT id from content_section WHERE page='$page' and section='$section'");
        $Sid = $select->fetch()[0];
        $update = $conn->prepare("UPDATE content set contenu=? WHERE Sid=? and item=?");
        $contenu = Content::creationLien(htmlspecialchars($contenu));
        $update->execute(array($contenu, $Sid, htmlspecialchars($item)));
        echo "Contenu mis à jour";
    }

    public static function contenu_total($full = false, $raw=false)
    {
        global $conn;
        $select = $conn->query("SELECT DISTINCT(page) FROM content_section");
        $select->setFetchMode(PDO::FETCH_CLASS, 'Content');
        $contenu_total = array();
        while ($page = $select->fetch()) {
            array_push($contenu_total, Content::getPage($page->page, $full, $raw));
        }
        return $contenu_total;
    }

    public static function getPage($page, $full = false, $raw=false)
    {
        global $conn;
        $select = $conn->query("SELECT COUNT(section), description FROM content_section WHERE page='$page'");
        $n_sec = $select->fetch()[0];
        $page_array = array();
        for ($i = 1; $i <= $n_sec; $i++) {
            $page_array[$i] = Content::getSection($page, $i, $full, $raw);
        }
        if ($full)
            return array(
                "sections" => $page_array,
                "name" => $page,
            );
        else
            return $page_array;
    }

    public static function getSection($page, $section, $full = false, $raw = false)
    {
        global $conn;
        $select = $conn->query("SELECT contenu, description FROM content JOIN content_section ON content.Sid=content_section.id WHERE page='$page' AND section='$section' ORDER BY item");
        $select->setFetchMode(PDO::FETCH_CLASS, 'Content');
        $section = array();
        $description = "La description sera activée dès qu'il y aura un premier item dans la section";
        while ($item = $select->fetch()) {
            $contenu = $item->contenu;
            if ($raw)
                $contenu = Content::reverseCreationLien($contenu);
            array_push($section, $contenu);
            $description = $item->description;
        }
        if ($full)
            return array(
                "items" => $section,
                "desc" => $description
            );
        else
            return $section;
    }

    public static function addSection()
    {
        extract($_POST);
        global $conn;
        $insert = $conn->prepare("INSERT into content_section (page, section, description) values (?,?,?)");
        $insert->execute(array($page, htmlspecialchars($section_num), htmlspecialchars($section_description)));
        $_SESSION["displayValid"] = "Section ajoutée avec succès !";
    }

    public static function addItem()
    {
        extract($_POST);
        global $conn;
        $select = $conn->query("SELECT id FROM content_section WHERE page='$page' and section='$section_num'");
        $Sid = $select->fetch()[0];

        $insert = $conn->prepare("INSERT into content (Sid, item, contenu) values (?,?,?)");
        $item_contenu = Content::creationLien(htmlspecialchars($item_contenu));
        $insert->execute(array($Sid, htmlspecialchars($item_num),  $item_contenu));
        $_SESSION["displayValid"] = "Item ajoutée avec succès !";
    }

    private static function reverseCreationLien($string)
    {
        $splits = preg_split('/[<>]/', $string);
        if (sizeof($splits) == 5 && $splits[3] == "/a") {
            $url = substr($splits[1], 7);
            return $splits[0] . "!lien!$url!" . $splits[2] . "!" . $splits[4];
        }
        return $string;
    }

    private static function creationLien($string)
    {
        $splits = preg_split('/!/', $string);
        if (sizeof($splits) == 5 && $splits[1] == "lien") {
            $url = filter_var($splits[2], FILTER_VALIDATE_URL);
            if ($url) {
                $value = $splits[3];
                $lien = "<a href=$url>$value</a>";
                return $splits[0] . $lien . $splits[4];
            }
        }
        return $string;
    }

    public static function deleteSection()
    {
        global $conn;
        $delete = $conn->query("DELETE from content_section where page= id=");
    }

    public static function deleteItem()
    {
        global $conn;
        $delete = $conn->query("DELETE from content where =");
    }
}
