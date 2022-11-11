<?php
class CAS{
  public static function CAS_get_response(){

    $site = 'https://course-drapeau.binets.fr/?page=Connect';
    /**
    * Récupération de l'id de l'utilisateur correspondant à ce ticket, ainsi que les informations demandées
    */
    var_dump('https://cas.binets.fr/serviceValidate?service='.rawurlencode($site).'&ticket='
    .$_GET['ticket']);
   $response = file_get_contents('https://cas.binets.fr/serviceValidate?service='.rawurlencode($site).'&ticket='
  .$_GET['ticket']);
  var_dump($response);
  
   $doc = new DOMDocument();
   $doc->loadXML($response);
   if ($doc->getElementsByTagName('authenticationFailure')->length == 0) {
     $return = array();
     /**
      * Récupération de l'id de l'utilisateur
      */
     $return['id'] = $doc->getElementsByTagName('user')->item(0)->textContent;
     /**
      * Récupération des données de l'utilisateur
      */
     foreach ($doc->getElementsByTagName('attribute') as $attribute) {
       if (isset($return[$attribute->getAttribute('name')])) {
         if (!is_array($return[$attribute->getAttribute('name')])) {
           $return[$attribute->getAttribute('name')] = [$return[$attribute->getAttribute('name')]];
         }
         $return[$attribute->getAttribute('name')][] = $attribute->getAttribute('value');
       } else {
         $return[$attribute->getAttribute('name')] = $attribute->getAttribute('value');
       }
     }
     return $return;
   } else {
     return false;
   }
  }
}
