<?php

/**
 * gestión de assets públicos y privados de la app
 *
 * - imagenes de vehículos
 */

return [

  /**
   * imagenes de vehículos
   */
  'vehicle' => [

    // original
    'original_sp' => 'img/original/vehicles/',
    'original_pp' => env('APP_URL') . 'storage/img/original/vehicles/',

    // resize
    'resize_sp' => 'img/resize/vehicles/',
    'resize_pp' => env('APP_URL') . 'storage/img/resize/vehicles/',

    // extra config
    'max_size' => 1024 * 1024 * 2, // 2MB
    'max_width' => 1920,
    'max_height' => 1080,
    'allowed_extensions' => ['jpg', 'jpeg', 'png', 'webp'],
  ],

  /**
   * Facturas almacenadas en el sistema
   */
  'invoices' => [

    // original
    'storage_path' => 'doc/invoices/',
    'public_path' => env('APP_URL') . 'storage/doc/invoices/',
  ],

  /**
   * imagen banner de la app
   */
  'app_image' => [
    'banner' => 'https://i.ibb.co/Z2XrMyf/banner.webp',
  ],
];
