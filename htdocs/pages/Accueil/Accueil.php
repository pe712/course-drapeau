<?php 
class Accueil extends Page{
    public function __construct($sections) {
        $this->content ='
        <section id="accueil">
        <div>
        <br>
        <h3 style="text-align: center">Du vendredi 1er décembre</h3>
        <h3 style="text-align: center"> au mardi 5 décembre</h3>
        <br>
        <img src="img/logo_BX.png" alt="logo" id="logo_BX" style="padding-left:40px">
        </div>
        </section>';
    }
}
