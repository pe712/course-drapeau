<?php
class Content
{
    public $page;
    public $section;
    public $sous_section;
    public $contenu;
    public $description;

    public function __construct(
        $page,
        $section,
        $sous_section,
        $contenu
    ) {
        $this->page = $page;
        $this->section = $section;
        $this->sous_section = $sous_section;
        $this->contenu = $contenu;
    }

    public function update_db($conn)
    {
        $update = $conn->prepare("update content set contenu=? where page=? and section=? and sous_section=?");
        $update->execute(array($this->contenu, $this->page, $this->section, $this->sous_section));
    }
}
