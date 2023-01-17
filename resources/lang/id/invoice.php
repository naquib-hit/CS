<?php

return [

  /*
  |--------------------------------------------------------------------------
  | Products page language lines
  |--------------------------------------------------------------------------
  | 
  | Translate from product page
  |
  */

  'title' => 'Faktur',
  'table' => [
    'invoice_no'   => 'No. Faktur',
    'create_date'  => 'Tanggal',
    'due_date'     => 'Batas Waktu',
    'customer'     => 'Pelanggan',
    'created_by'   => 'Pembuat',
    'email_status' => 'Status',
    'sum'          => 'Total',
    'opt'          => 'Operation',

  ],
  'form' => [
    'title' => 'Invoice Form',
    'fields' => [
      'no'        => 'No. Faktur',
      'date'      => 'Tanggal',
      'due_date'  => 'batas Waktu',
      'customer'  => 'Pelanggan',
      'item'      => 'Jenis Barang',
      'total'     => 'Kuantitas',
      'tax'       => 'Pajak',
      'discount'  => 'Diskon',
      'notes'     => 'Catatan',
      'additional' => [
        'title'       => 'Bidang Tambahan',
        'name'        => 'Nama',
        'value'       => 'Nilai',
        'unit'        => 'Satuan',
        'operation'   => 'Operasi'
      ]
    ],

  ],
  'filter' => [
    'fields' => [
      'name'      => 'Customer\'s Name',
      'email'     => 'Customer\'s Email',
      'phone'     => 'Customer\'s Phone'
    ],
  ],
  'back' => 'Back To Customers Page'
];