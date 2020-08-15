<?php 

$restaurant =
   [
      'nom' => 'monresto',
      'cuisine' => ['Bretonne', 'Alsacienne'],
      'adresse' => [
         'numRue'        => 4,
         'nomVoie'       => 'rue des restos',
         'codePostal'    => 12345,
         'ville'         => 'Bordeaux',
         'lat' => 12.34,
         'lon' => 56.67
      ],
      'tel' => '12 23 34 45 56',
      'site' => 'https://monresto.com',
      'tarifs' =>
      [
         'min' => 10,
         'max' => 45
      ],
      'presentation' => 'blablabla blabla',
      'commentaires' =>
      [
         [
            'note' => 5,
            'commentaire' => 'c bon !'
         ],
         [
            'note' => 5,
            'commentaire' => 'c bon !'
         ],
         [
            'note' => 5,
            'commentaire' => 'c bon !'
         ]
      ]

   ];