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

  ],
  'form' => [
    'title' => 'Invoice Form',
    'fields' => [
      'no'        => 'Invoice Number',
      'date'      => 'Invoice Date',
      'due_date'  => 'Due Date',
      'customer'  => 'Customer',
      'item'      => 'Items',
      'tax'       => 'Tax',
      'discount'  => 'Discount',
      'notes'     => 'Notes'
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
