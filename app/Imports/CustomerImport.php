<?php

namespace App\Imports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\{ ToModel, WithHeadingRow };


class CustomerImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Customer([
            //
            'customer_name'     => $row['nama'],
            'customer_email'    => $row['email'],
            'customer_phone'    => $row['phone'],
            'customer_address'  => $row['alamat']
        ]);
    }
}
