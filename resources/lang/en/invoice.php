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

  'title' => 'Invoices',
  'table' => [
    'invoice_no'   => 'Invoice Number',
    'create_date'  => 'Invoice Date',
    'due_date'     => 'Due Date',
    'customer'     => 'Customer',
    'created_by'   => 'Created By',
    'email_status' => 'Status',
    'sum'          => 'Price Total',
    'opt'          => 'Operation',

  ],
  'form' => [
    'title' => 'Invoice Form',
    'fields' => [
      'no'        => 'Invoice Number',
      'date'      => 'Invoice Date',
      'total'     => 'Quantity',
      'due_date'  => 'Due Date',
      'po'        => 'PO Number',
      'currency'  => 'Currency',
      'customer'  => 'Customer',
      'item'      => 'Items',
      'tax'       => 'Tax',
      'discount'  => 'Discount',
      'notes'     => 'Notes',
      'additional' => [
        'title'       => 'Additional Fields',
        'name'        => 'Name',
        'value'       => 'Value',
        'unit'        => 'Unit',
        'operation'   => 'Operation'
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