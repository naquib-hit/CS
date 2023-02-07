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
     * @return array
     */
    public static function getByProducts(\DateTime $from, \DateTime $to, ?int $limit=NULL, ?int $offset=NULL): array
    {
       $stmt = "SELECT a.element_id::int, a.element_name::text, SUM(a.element_value::int) as element_value
                FROM (
                    SELECT 
                    (obj ->> 'id')::int as element_id, 
                    (obj -> 'product_name')::text as element_name, 
                    (obj -> 'pivot' ->> 'total_price')::text::int as element_value,
                    created_at
                FROM 
                    (SELECT r.id, r.created_at, obj FROM reports r, json_array_elements(r.deskripsi#>'{products}') obj) produk
                ) a
                WHERE a.created_at BETWEEN :from AND :to
                GROUP BY a.element_id, a.element_name";

        
        $_params = ['from' => $from->format('Y-m-d H:i:s'), 'to' => $to->format('Y-m-d H:i:s')];

        if(!empty($limit) )
        {
            $stmt .= " LIMIT :limit";
            $_params['limit'] = $limit;
        }

        if(!is_null($offset))
        {
            $stmt .= " OFFSET :offset";
            $_params['offset'] = $offset;
        }

        $reports = DB::select($stmt, $_params);
        return $reports;
    }
    

    /**
     * Generate Report By Customer
     * 
     * @param \DateTime $from
     * @param \DateTime $to
     * @return array
     */
    public function getByCustomers(\DateTime $from, \DateTime $to, ?int $limit=NULL, ?int $offset=NULL) : array
    {
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

        $_params = ['from' => $from->format('Y-m-d H:i:s'), 'to' => $to->format('Y-m-d H:i:s')];

        if(!empty($limit))
        {
            $stmt .= " LIMIT :limit";
            $_params['limit'] = $limit;
        }

        if(!is_null($offset))
        {
            $stmt .= " OFFSET :offset";
            $_params['offset'] = $offset;
        }

        $reports = DB::select($stmt, $_params);
        return $reports;
    }

    /**
     * Summary of getFilteredReports
     * 
     * @param string $type
     * @param \DateTime $from
     * @param \DateTime $to
     * @return Collection
     */
    public static function getFilteredReports(string $type, \DateTime $from, \DateTime $to, ?int $limit=NULL, ?int $offset=NULL): Collection
    {
        $arr = [];
        switch($type)
        {
            case 'product':
                $arr = self::getByProducts($from, $to, $limit, $offset);
                break;
            case 'customer':
                $arr = self::getByCustomers($from, $to, $limit, $offset);
                break;
        }

        return collect($arr);
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
