<?php

return  [
    'admin' => [
        'system' => [
            'enable'               => 'Activer',
            'title'                => 'Titre',
            'description'          => 'Description',
            'sandbox'              => 'bac à sable',
            'cyber-source-payment' => 'Paiement CyberSource',
            'debug'                => 'Déboguer',
            'profile-id'           => "Carte d'indentité",
            'secret-key'           => 'Clef secrète',
            'access-key'           => "Clef d'accès",
            'status'               => 'Statut',
            'logo'                 => 'Logo',
            'logo-information'     => "La résolution de l'image doit être d'environ 55px x 45px",    
        ],

        'transaction' => [
            'error'  => "Quelque chose s'est mal passé ! Veuillez réessayer.",
            'cancel' => 'Transaction annulée',
        ],
    ],

    'shop' => [
        'payment' => [
            'alert-msg'    => 'Merci de ne pas actualiser cette page...',
            'redirect-msg' => "Cliquez ici si vous n'êtes pas redirigé dans les 10 secondes...",
        ],
    ],
];
