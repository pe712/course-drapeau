<?php
class Contact extends Page
{
    public function __construct($sections)
    {
        $this->content = $this->buffer("presentation");
    }
}


?>