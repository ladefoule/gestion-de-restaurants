<?php

class Restos
{
   private $restos;
   private $fillable = ['nom', 'site', 'presentation', 'tarif_min', 'tarif_max', 'tel'];
   private $fillableAdresse = ['cp', 'rue', 'ville', 'pays', 'latitude', 'longitude'];

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

   public function getFillableAdresse()
   {
      return $this->fillableAdresse;
   }

   /**
    * Ajout d'un resto
    *
    * @param array $resto
    * @return void
    */
   public function ajout(array $resto)
   {
      $this->restos->insertOne($resto);
   }

   /**
    * Suppression d'un resto
    *
    * @param string $id
    * @return void
    */
   public function delete(string $id)
   {
      $_id = new MongoDB\BSON\ObjectId($id);
      $this->restos->deleteOne(['_id' => $_id]);
   }

   /**
    * Modification d'un resto
    *
    * @param string $id
    * @param array $resto
    * @return void
    */
   public function edit(string $id, array $resto)
   {
      $unsetKeys = [];
      // Les clés qui ne sont pas saisies seront supprimés du document
      foreach ($this->fillable as $value) {
         if (in_array($value, array_keys($resto)) == false)
            $unsetKeys[$value] = '';
      }

      $_id = new MongoDB\BSON\ObjectId($id);
      $this->restos->updateOne(['_id' => $_id], ['$set' => $resto]);
      $this->restos->updateOne(['_id' => $_id], ['$unset' => $unsetKeys]);
   }

   /**
    * Modification de l'adresse d'un resto
    *
    * @param string $id
    * @param array $resto
    * @return void
    */
   public function editadresse(string $id, array $resto)
   {
      $unsetKeys = [];
      // Les clés qui ne sont pas saisies seront supprimés du document
      foreach ($this->fillableAdresse as $value) {
         if (in_array($value, array_keys($resto)) == false)
            $unsetKeys[$value] = '';
      }

      $_id = new MongoDB\BSON\ObjectId($id);
      $this->restos->updateOne(['_id' => $_id], ['$set' => $resto]);
      $this->restos->updateOne(['_id' => $_id], ['$unset' => $unsetKeys]);
   }

   /**
    * Renvoie les infos d'un resto
    *
    * @param string $id
    * @return array
    */
   public function fiche(string $id)
   {
      $_id = new MongoDB\BSON\ObjectId($id);
      return $this->restos->find(['_id' => $_id]);
   }

   /**
    * Liste de tous les restos
    *
    * @param string $orderby
    * @param int $sens
    * @return array
    */
   public function liste($orderby = '', int $sens = 1)
   {
      if ($orderby == '')
         return $this->restos->find();

      return $this->restos->find([], ['sort' => [$orderby => $sens]]);
   }
}
