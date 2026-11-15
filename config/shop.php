<?php

/*
 * Los datos del taller en un solo sitio: las páginas los muestran y el asistente los lee
 * de aquí, así que un precio cambiado se cambia una vez.
 */

return [

    'name' => 'Radios',

    'address' => 'Avenida de los Pedales 7, 50001 Zaragoza',

    'phone' => '976 000 000',

    'email' => 'hola@radios.test',

    'hours' => [
        'De lunes a viernes, de 9:30 a 14:00 y de 16:30 a 20:00',
        'Sábados, de 10:00 a 14:00',
        'Domingos y festivos, cerrado',
    ],

    'prices' => [
        ['service' => 'Puesta a punto básica', 'price' => '35 €'],
        ['service' => 'Puesta a punto completa', 'price' => '65 €'],
        ['service' => 'Reparación de pinchazo, con cámara nueva', 'price' => '12 €'],
        ['service' => 'Ajuste de frenos', 'price' => '15 €'],
        ['service' => 'Ajuste de cambios', 'price' => '15 €'],
        ['service' => 'Revisión de bicicleta eléctrica', 'price' => '50 €'],
        ['service' => 'Montaje de bicicleta nueva', 'price' => '40 €'],
        ['service' => 'Recogida y entrega a domicilio en Zaragoza', 'price' => '10 €'],
        ['service' => 'Mano de obra fuera de tarifa', 'price' => '30 € la hora'],
    ],

];
