<?php

class Resto
{
   public $restos;
   public function __construct()
   {
      $mongo = new MongoDB\Client("mongodb://127.0.0.1:27017");
      $db = $mongo->restaurants;
      $this->restos = $db->restos;
   }

   public function init($resto)
   {
      $this->resto = $resto;
   }


   public function ajout($resto)
   {
      $this->restos->insertOne($resto);
   }

   public function delete($id)
   {
      $_id = new MongoDB\BSON\ObjectId($id);
      $this->restos->deleteOne(['_id' => $_id]);
   }

   public function edit($id, $resto)
   {
      $_id = new MongoDB\BSON\ObjectId($id);
      $this->restos->updateOne(['_id' => $_id], ['$set' => $resto]);
   }

   public function fiche($id)
   {
      $_id = new MongoDB\BSON\ObjectId($id);
      return $this->restos->find(['_id' => $_id]);
   }

   public function liste()
   {
      return $this->restos->find();
   }
}