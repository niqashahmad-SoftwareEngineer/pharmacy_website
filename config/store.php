<?php
return [
    'name' => 'Nazar Muhammad Medical Store',
    'phone' => '03000000002',
    'international_phone' => '+923000000002',
    'address' => 'Near Link Road, Mardan Road, Swabi, KP, Pakistan',
    'hours' => '8:00 AM–10:00 PM',
    'categories' => json_decode(file_get_contents(database_path('data/catalogue.json')), true)['categories'],
];
