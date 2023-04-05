<?php

namespace App\Imports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\ToModel;

class CustomerImport implements ToModel
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
            'customer_name'     => $row[0],
            'customer_email'    => $row[1],
            'customer_phone'    => $row[2],
            'customer_address'  => $row[3]
        ]);
    }
}
