<?php

return  [
    'admin' => [
        'system' => [
            'enable'               => 'Permitir',
            'title'                => 'Título',
            'description'          => 'Descripción',
            'sandbox'              => 'Salvadera',
            'cyber-source-payment' => 'Pago CyberSource',
            'debug'                => 'Depurar',
            'profile-id'           => 'Perfil Id',
            'secret-key'           => 'Llave secreta',
            'access-key'           => 'Llave de acceso',
            'status'               => 'Estado',
            'logo'                 => 'Logo',
            'logo-information'     => 'La resolución de la imagen debe ser de aproximadamente 55px x 45px',    
        ],

        'transaction' => [
            'error'  => '¡Algo salió mal! Inténtalo de nuevo.',
            'cancel' => 'transacción cancelada',
        ],
    ],

    'shop' => [
        'payment' => [
            'alert-msg'    => 'Por favor no actualice esta página...',
            'redirect-msg' => 'Haga clic aquí si no es redirigido en 10 segundos...',
        ],
    ],
];
