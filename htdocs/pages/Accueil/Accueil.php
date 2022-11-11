<?php 
class Accueil extends Page{
    public function __construct($sections) {
        if (array_key_exists("ticket", $_GET)){
            $this->load = "Connect";
        }
        $this->content ='
        <section id="accueil">
        </section>';
    }
}
