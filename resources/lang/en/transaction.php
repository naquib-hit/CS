<?php

return [
    /**
     * ======================================
     *          Transactions Trans
     * ======================================
     * 
     */

    'title' => 'Invoice Transaction',
    'table'    => [
        'customer'      => 'Customer',
        'product'       => 'Product',
        'sales'         => 'Salesperson',
        'code'          => 'Transaction No.',
        'create_date'   => 'Create Date',
        'due_date'      => 'Due Date',
        'status'        => 'Delivery Status',
        'delivery_date' => 'Delivery Date',
        'opt'           => 'Operation'
    ],
    'fields'  => [
        'title'         => 'Generate Report',
        'code'          => 'Transaction No.',
        'customer'      => 'Customer',
        'product'       => 'Product',
        'sales'         => 'Sales',
        'start_date'    => 'Start Date',
        'end_date'      => 'End Date',
        'filtered_by'   => 'Filter By'
    ]
];