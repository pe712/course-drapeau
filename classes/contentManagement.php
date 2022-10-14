<?php
class Content
{
    public $page;
    public $section;
    public $item;
    public $contenu;
    public $description;

    //les paramètres sont à null pour match la méthode sql de récupération de données
    public function __construct(
        $page = null,
        $section = null,
        $item = null,
        $contenu = null,
        $description = null
    ) {
        $this->page = $page;
        $this->section = $section;
        $this->item = $item;
        $this->contenu = $contenu;
        $this->description = $description;
    }

    public function update_db()
    {
        global $conn;
        $update = $conn->prepare("update content set contenu=? WHERE page=? and section=? and item=?");
        $update->execute(array($this->contenu, $this->page, $this->section, $this->item));
    }

    public static function content($name=null)
    {
        global $conn;
        $select = $conn->prepare("SELECT COUNT(section) FROM content_section WHERE page=?");
        $select->execute(array($name));
        $n_sec = $select->fetch()[0];

        $sections = array();
        for ($i = 0; $i < $n_sec; $i++) {
            if ($name==null)
                $query = "SELECT contenu, page, section FROM content JOIN content_section ON content.Sid=content_section.id WHERE section=$i+1 ORDER BY item";
            else
            $query = "SELECT contenu FROM content JOIN content_section ON content.Sid=content_section.id WHERE page=? AND section=$i+1 ORDER BY item";
            $select = $conn->prepare($query);
            $select->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Content');
            $select->execute(array($name));
            $section = array();
            while ($item = $select->fetch()) {
                array_push($section, $item->contenu);
            }
            array_push($sections, $section);
        }
        return $sections;
    }
}
