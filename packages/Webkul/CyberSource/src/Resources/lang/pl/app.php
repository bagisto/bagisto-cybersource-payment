<?php

return  [
    'admin' => [
        'system' => [
            'enable'               => 'Włączać',
            'title'                => 'Tytuł',
            'description'          => 'Opis',
            'sandbox'              => 'Piaskownica',
            'cyber-source-payment' => 'Płatność CyberSource',
            'debug'                => 'Odpluskwić',
            'profile-id'           => 'Identyfikator profilu',
            'secret-key'           => 'Sekretny klucz',
            'access-key'           => 'Klucz dostępu',
            'status'               => 'Status',
            'logo'                 => 'Logo',
            'logo-information'     => 'Rozdzielczość obrazu powinna wynosić około 55px X 45px',
        ],

        'transaction' => [
            'error'  => 'Coś poszło nie tak! Proszę spróbuj ponownie.',
            'cancel' => 'Transakcja anulowana',
        ],
    ],

    'shop' => [
        'payment' => [
            'alert-msg'    => 'Proszę nie odświeżać tej strony...',
            'redirect-msg' => 'Kliknij tutaj, jeśli nie nastąpi przekierowanie w ciągu 10 sekund...',
        ],
    ],
];
