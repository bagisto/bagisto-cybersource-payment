<?php

return [
   [
        'key'    => 'sales.payment_methods.cyber_source',
        'name'   => 'cyber_source::app.admin.system.cyber-source-payment',
        'sort'   => 4,
        'fields' => [
            [
                'name'          => 'title',
                'title'         => 'cyber_source::app.admin.system.title',
                'type'          => 'depends',
                'depend'        => 'active:1',
                'validation'    => 'required_if:active,1',
                'channel_based' =>  true,
                'locale_based'  =>  true,
            ], [
                'name'          => 'description',
                'title'         => 'cyber_source::app.admin.system.description',
                'type'          => 'textarea',
                'channel_based' =>  true,
                'locale_based'  =>  true,
            ], [
                'name'          => 'image',
                'title'         => 'admin::app.configuration.index.sales.payment-methods.logo',
                'type'          => 'image',
                'info'          => 'admin::app.configuration.index.sales.payment-methods.logo-information',
                'channel_based' => false,
                'locale_based'  => false,
                'validation'    => 'mimes:bmp,jpeg,jpg,png,webp',
            ], [
                'name'          => 'active',
                'title'         => 'admin::app.configuration.index.sales.payment-methods.status',
                'type'          => 'boolean',
                'validation'    => 'required',
                'channel_based' => true,
                'locale_based'  => false,
            ], [
                'name'          => 'sandbox',
                'title'         => 'cyber_source::app.admin.system.sandbox',
                'type'          => 'boolean',
                'channel_based' => true,
                'locale_based'  => false,
            ], [
                'name'          => 'profile_id',
                'title'         => 'cyber_source::app.admin.system.profile-id',
                'type'          => 'depends',
                'depend'        => 'active:1',
                'validation'    => 'required_if:active,true',
                'channel_based' => false,
                'locale_based'  => false,
            ], [
                'name'          => 'access_key',
                'title'         => 'cyber_source::app.admin.system.access-key',
                'type'          => 'depends',
                'depend'        => 'active:1',
                'validation'    => 'required_if:active,true',
                'channel_based' => false,
                'locale_based'  => false,
            ], [
                'name'          => 'secret_key',
                'title'         => 'cyber_source::app.admin.system.secret-key',
                'type'          => 'depends',
                'depend'        => 'active:1',
                'validation'    => 'required_if:active,true',
                'channel_based' => false,
                'locale_based'  => false,
            ]
        ]
    ],
];


