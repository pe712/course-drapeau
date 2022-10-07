<?php
class Content
{
    public $page;
    public $section;
    public $sous_section;
    public $contenu;
    public $description;

    //les paramètres sont à null pour match la méthode sql de récupération de données
    public function __construct(
        $page = null,
        $section = null,
        $sous_section = null,
        $contenu = null,
        $description = null
    ) {
        $this->page = $page;
        $this->section = $section;
        $this->sous_section = $sous_section;
        $this->contenu = $contenu;
        $this->description = $description;
    }

    public function update_db()
    {
        global $conn;
        $update = $conn->prepare("update content set contenu=? WHERE page=? and section=? and sous_section=?");
        $update->execute(array($this->contenu, $this->page, $this->section, $this->sous_section));
    }

    public static function content()
    {
        global $conn;
        global $name;
        $select = $conn->prepare("SELECT COUNT(DISTINCT(section)) FROM content WHERE page=?");
        $select->execute(array($name));
        $n_sec = $select->fetch()[0];

        $sections = array();
        for ($i = 0; $i < $n_sec; $i++) {
            $select = $conn->prepare("SELECT * FROM content WHERE page=? AND section=$i+1");
            $select->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Content');
            $select->execute(array($name));
            $sous_section = array();
            while ($article = $select->fetch()) {
                array_push($sous_section, $article->contenu);
            }
            array_push($sections, $sous_section);
        }
        return $sections;
    }
}
