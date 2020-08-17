<?php

class Restos
{
   private $restos;
   private $fillable = ['nom', 'site', 'presentation', 'tarif_min', 'tarif_max', 'tel', 'cuisines'];
   private $fillableAdresse = ['cp', 'rue', 'ville', 'pays', 'latitude', 'longitude'];
   private $fillableNote = ['note', 'commentaire'];

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

   public function getFillableNote()
   {
      return $this->fillableNote;
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
    * @param MongoDB\BSON\ObjectId $_id
    * @return void
    */
   public function delete(MongoDB\BSON\ObjectId $_id)
   {
      return $this->restos->deleteOne(['_id' => $_id]);
   }

   /**
    * Suppression d'un resto
    *
    * @param MongoDB\BSON\ObjectId $_id
    * @return void
    */
   public function deleteKey(MongoDB\BSON\ObjectId $_id, array $keys)
   {
      $this->restos->updateOne(['_id' => $_id], ['$unset' => $keys]);
   }

   /**
    * Modification d'un resto
    *
    * @param MongoDB\BSON\ObjectId $_id
    * @param array $resto
    * @return void
    */
   public function edit(MongoDB\BSON\ObjectId $_id, array $resto)
   {
      $unsetKeys = [];
      // Les clés qui ne sont pas saisies seront supprimés du document
      foreach ($this->fillable as $value) {
         if (in_array($value, array_keys($resto)) == false)
            $unsetKeys[$value] = '';
      }

      if ($resto != [])
         $this->restos->updateOne(['_id' => $_id], ['$set' => $resto]);

      if ($unsetKeys != [])
         $this->restos->updateOne(['_id' => $_id], ['$unset' => $unsetKeys]);
   }

   /**
    * Modification de l'adresse d'un resto
    *
    * @param MongoDB\BSON\ObjectId $_id
    * @param array $resto
    * @return void
    */
   public function editadresse(MongoDB\BSON\ObjectId $_id, array $adresse)
   {
      $unsetKeys = [];
      // Les clés qui ne sont pas saisies seront supprimés du document
      foreach ($this->fillableAdresse as $value) {
         if (in_array($value, array_keys($adresse)) == false)
            $unsetKeys[$value] = '';
      }

      if ($adresse != [])
         $this->restos->updateOne(['_id' => $_id], ['$set' => $adresse]);

      if ($unsetKeys != [])
         $this->restos->updateOne(['_id' => $_id], ['$unset' => $unsetKeys]);
   }

   /**
    * Renvoie les infos d'un resto
    *
    * @param MongoDB\BSON\ObjectId $_id
    * @return array
    */
   public function fiche(MongoDB\BSON\ObjectId $_id)
   {
      return $this->restos->find(['_id' => $_id]);
   }

   /**
    * Liste de tous les restos
    *
    * @param string $orderby
    * @param int $sens
    * @return array
    */
   public function liste($filtre = [], $projection = [])
   {
      return $this->restos->find($filtre, $projection);
   }

   /**
    * La liste de toutes les types cuisines présentes dans notre collection
    *
    * @return void
    */
   public function listeCuisines()
   {
      return $this->restos->distinct('cuisines', ['cuisines' => ['$exists' => 1]]);
   }

   /**
    * Ajout d'une note au resto
    *
    * @param MongoDB\BSON\ObjectId $_id
    * @param array $note
    * @return void
    */
   public function ajoutNote(MongoDB\BSON\ObjectId $_id, array $note)
   {
      $unsetKeys = [];
      // Les clés qui ne sont pas saisies seront supprimés du document
      foreach ($this->fillableNotes as $value) {
         if (in_array($value, array_keys($note)) == false)
            $unsetKeys[$value] = '';
      }

      if ($note != [])
         $this->restos->updateOne(['_id' => $_id], ['$push' => ['notes' => $note]]);
   }

   /**
    * La moyenne des notes du resto
    *
    * @param MongoDB\BSON\ObjectId $_id
    * @return void
    */
   public function moyenneNotes(MongoDB\BSON\ObjectId $_id)
   {
      return $this->restos->aggregate(
         [
            ['$match' => ['_id' => $_id]],
            [
               '$group' => ['_id' => '$_id', 
                           'moyenne' => ['$avg' => ['$avg' => '$notes.note']]]
            ]
         ]
      );
   }
}
