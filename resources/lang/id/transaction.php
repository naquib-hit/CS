<?php

return [
    /**
     * ======================================
     *          Transactions Trans
     * ======================================
     * 
     */

    'title'    => 'Transaksi Invoice',
    'table'    => [
        'customer'       => 'Pelanggan',
        'product'        => 'Produk',
        'sales'          => 'Sales',
        'code'           => 'No. Transaksi',
        'create_date'    => 'Tanggal Terbit',
        'due_date'       => 'Jatuh Tempo',
        'delivery_date'  => 'Tanggal Kirim',
        'status'         => 'Status Kirim',
        'opt'            => 'Operasi'
    ],
    'fields'  => [
        'title'          => 'Laporan',
        'customer'       => 'Pelanggan',
        'product'        => 'Produk',
        'sales'          => 'Sales',
        'code'           => 'No. Transaksi',
        'start_date'     => 'Tanggal Awal',
        'end_date'       => 'Tanggal Akhir',
        'filtered_by'    => 'Saring Berdasarkan'
    ],
    'button' => [
        'generate'  => 'Saring',
        'reset'     => 'Pulihkan'
    ]
];