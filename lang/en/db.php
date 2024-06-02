<?php
    return [
        'company' => [
            'id' => 'id',
            'unique_id' => 'unique id',
            'name' => 'name',
            'code' => 'code',
            'address' => 'address',
            'phone' => 'phone',
            'email' => 'email',
            'website' => 'website',
            'tax' => 'tax',
            'agent_name' => 'agent name',
            'agent_mobile' => 'agent mobile',
            'status' => 'status',
            'country_id' => 'country',
            'meal_price_id' => 'meal price',
        ],

        'meal_price' => [
            'id' => 'id',
            'name' => 'name',
            'code' => 'code',
            'service_type' => 'service type',
            'country_id' => 'country',
            'type' => 'type',
            'status' => 'status',
        ],

        'hotel' => [
            'id' => 'id',
            'name' => 'name',
            'code' => 'code',
            'phone' => 'phone',
            'email' => 'email',
            'address' => 'address',
            'status' => 'status',
        ],

        'hall' => [
            'id' => 'id',
            'name' => 'name',
            'code' => 'code',
            'capacity' => 'capacity',
            'hotel_id' => 'hotel',
            'status' => 'status',
        ]
    ];
