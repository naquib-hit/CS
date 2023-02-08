<?php

namespace App\Models;

use App\Traits\UUIDTrait;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jimmyjs\ReportGenerator\ReportGenerator;
use Jimmyjs\ReportGenerator\ReportMedia\{ PdfReport, ExcelReport, CSVReport };

class Report extends Model
{
    use HasFactory, UUIDTrait;

    /**
     * guarded props
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Generate reports by products
     * 
     * @param \DateTime $from
     * @param \DateTime $to
     * @return \Illuminate\Database\Query\Builder
     */

    //   SELECT a.element_id::int, a.element_name::text, SUM(a.element_value::int) as element_value
    //       FROM (
    //                 SELECT 
    //                 (obj ->> 'id')::int as element_id, 
    //                 (obj -> 'product_name')::text as element_name, 
    //                 (obj -> 'pivot' ->> 'total_price')::text::int as element_value,
    //                 created_at
    //             FROM 
    //                 (SELECT r.id, r.created_at, obj FROM reports r, json_array_elements(r.deskripsi#>'{products}') obj) produk
    //             ) a
    //   WHERE a.created_at BETWEEN :from AND :to
    //   GROUP BY a.element_id, a.element_name


    public static function getByProducts(\DateTime $from, \DateTime $to): \Illuminate\Database\Query\Builder
    {
        $reports = DB::table(function ($sub) {
                        $sub->select(DB::raw("(obj ->> 'id')::int as element_id, 
                                        (obj -> 'product_name')::text as element_name, 
                                        (obj -> 'pivot' ->> 'total_price')::text::int as element_value,
                                        created_at"))
                        ->from(function ($sub) {
                            $sub->select(DB::raw('r.id, r.created_at, obj'))
                                ->from(DB::raw("reports r, json_array_elements(r.deskripsi#>'{products}') obj"));
                        }, 'p');
                    }, 'items')
        ->select(DB::raw("element_id::int, REPLACE(element_name, '\"','') as element_name, SUM(element_value::int) as element_value"))
        ->whereBetween('created_at', [$from->format('Y-m-d H:i:s'), $to->format('Y-m-d H:i:s')])
        ->groupBy('element_id', 'element_name');
        
        return $reports;
    }
    

    /**
     * Generate Report By Customer
     * 
     * @param \DateTime $from
     * @param \DateTime $to
     * @return \Illuminate\Database\Query\Builder
     */

    /*
    
        $stmt = "WITH items AS (
                    SELECT 
                        (r.deskripsi -> 'customers' ->> 'id')::int as element_id,
                        (r.deskripsi -> 'customers' ->> 'customer_name')::text as element_name,
                        (r.deskripsi -> 'invoice_summary' ->> 'total_summary')::int as element_value,
                        r.created_at
                    FROM reports r
                )
                SELECT a.element_id, a.element_name, SUM(a.element_value) as element_value
                FROM items a
                WHERE a.created_at BETWEEN :from AND :to
                GROUP BY a.element_id, a.element_name";
     */

    public function getByCustomers(\DateTime $from, \DateTime $to) : \Illuminate\Database\Query\Builder
    {
       
        $reports = DB::table(function ($sub) {
                        $sub->select(DB::raw("(r.deskripsi -> 'customers' ->> 'id')::int as element_id,
                                              (r.deskripsi -> 'customers' ->> 'customer_name')::text as element_name,
                                              (r.deskripsi -> 'invoice_summary' ->> 'total_summary')::int as element_value,
                                              r.created_at"))
                            ->from(DB::raw('reports r'));
                    }, 'a')
                    ->select(DB::raw('a.element_id, REPLACE(a.element_name, \'"\', \'\') as element_name, SUM(a.element_value) as element_value'))
                    ->whereBetween('created_at', [$from->format('Y-m-d H:i:s'), $to->format('Y-m-d H:i:s')])
                    ->groupBy('element_id', 'element_name');
        return $reports;
    }

    /**
     * Summary of getFilteredReports
     * 
     * @param string $type
     * @param \DateTime $from
     * @param \DateTime $to
     * @return \Illuminate\Database\Query\Builder
     */
    public static function getFilteredReports(string $type, \DateTime $from, \DateTime $to): \Illuminate\Database\Query\Builder
    {
        switch($type)
        {
            case 'product':
                return self::getByProducts($from, $to);
            case 'customer':
                return self::getByCustomers($from, $to);
        }
    }

    /**
     * 888888888888888888888888888888888888888888888888888888888888888888888888888888888888888
     *                              DOWNLOAD REGION
     * 888888888888888888888888888888888888888888888888888888888888888888888888888888888888888
     */ 


    public static function generateReport(string $fileType, string $itemType, \DateTime $from, \DateTime $to, ?int $limit=NULL)
    {
        // set file type
        $type = NULL;
        switch($fileType)
        {
            case 'pdf':
                $type = new PdfReport;
                break;
            case 'excel':
                $type = new ExcelReport;
                break;
            case 'csv':
                $type = new CsvReport;
                break;
        }
        // get data
        $data = self::getFilteredReports($itemType,$from, $to);
        // set title
        $title = $itemType === 'product' ? 'LAPORAN AKUMULASI PRODUK / LAYANAN' : 'LAPORAN AKUMULASI PELANGGAN';
        $meta = [
            'Periode' => $from->format('Y-m-d').' s/d '.$to->format('Y-m-d')
        ];
        // set header
        $columns = [];
        switch($itemType)
        {
            case 'product':
                $columns = [
                    'Produk/Layanan' => 'element_name',
                    'Total'          => 'element_value'
                ];
                break;
            case 'customer':
                $columns = [
                    'Nama Pelanggan' => 'element_name',
                    'Total'          => 'element_value'
                ];
                break;
        }
        // set meta
        $type->of($title, $meta, $data, $columns);

        if(!empty($limit))
            $type->limit($limit);

        return $type;
    } 

}
