<?php

class Restos
{
   private $restos;
   private $fillable = ['nom', 'site', 'presentation', 'tarif_min', 'tarif_max', 'tel', 'longitude', 'latitude', 'cuisine'];

   public function __construct()
   {
      $mongo = new MongoDB\Client("mongodb://127.0.0.1:27017");
      $db = $mongo->restaurants;
      $this->restos = $db->restos;
   }

   public function getFillable()
   {
      return $this->fillable;
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

   public function liste($orderby = '', $sens = '')
   {
      if($orderby == '')
         return $this->restos->find();
      
      return $this->restos->find([], ['sort' => [$orderby => $sens]]);
   }
}