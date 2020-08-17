<?php 

class ErreurController{
   
   public static function erreur404($messageErreur)
   {
      echo "Erreur 404 : " . $messageErreur;
   }
}

