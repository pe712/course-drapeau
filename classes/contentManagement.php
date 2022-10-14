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
        var_dump($_POST);
        $update = $conn->prepare("UPDATE content set contenu=? WHERE Sid=? and item=?");
        $update->execute(array($contenu, $Sid, $item));
        echo "Contenu mis à jour";
    }

    public static function contenu_total($full = false)
    {
        global $conn;
        $select = $conn->query("SELECT DISTINCT(page) FROM content_section");
        $select->setFetchMode(PDO::FETCH_CLASS, 'Content');
        $contenu_total = array();
        while ($page = $select->fetch()) {
            array_push($contenu_total, Content::getPage($page->page, $full));
        }
        return $contenu_total;
    }

    public static function getPage($page, $full = false)
    {
        global $conn;
        $select = $conn->query("SELECT COUNT(section), description FROM content_section WHERE page='$page'");
        $n_sec = $select->fetch()[0];
        $page_array = array();
        for ($i = 1; $i <= $n_sec; $i++) {
            $page_array[$i]=Content::getSection($page, $i, $full);
        }
        if ($full)
            return array(
                "sections" => $page_array,
                "name" => $page,
            );
        else
            return $page_array;
    }

    public static function getSection($page, $section, $full = false)
    {
        global $conn;
        $select = $conn->query("SELECT contenu, description FROM content JOIN content_section ON content.Sid=content_section.id WHERE page='$page' AND section='$section' ORDER BY item");
        $select->setFetchMode(PDO::FETCH_CLASS, 'Content');
        $section = array();
        while ($item = $select->fetch()) {
            array_push($section, $item->contenu);
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
}
