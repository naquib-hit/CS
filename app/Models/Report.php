<?php

namespace App\Models;

use App\Traits\UUIDTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
    public static function getByProducts(\DateTime $from, \DateTime $to, int $limit = 0, int $offset = 0): array
    {
       $stmt = "WITH items AS (
                    SELECT 
                    (obj ->> 'id')::int as element_id, 
                    (obj -> 'product_name')::text as element_name, 
                    (obj -> 'pivot' ->> 'total_price')::text::int as element_value,
                    r.created_at
                FROM 
                    (SELECT r.id, obj FROM reports r, json_array_elements(r.deskripsi#>'{products}') obj) products
                )
                SELECT a.element_id::int, a.element_name::text, SUM(a.element_value::int) as total_value
                FROM items a
                WHERE a.created_at BETWEEN :from AND :to
                GROUP BY a.element_id, a.element_name
                LIMIT :limit OFFSET :offset";

        $reports = DB::select($stmt, ['from' => $from->format('Y-m-d H:i:s'), 'to' => $to->format('Y-m-d H:i:s'), 'limit' => $limit, 'offset' => $offset]);
        return $reports;
    }

    /**
     * Generate Report By Customer
     * 
     * @param \DateTime $from
     * @param \DateTime $to
     * @return array
     */
    public function getByCustomers(\DateTime $from, \DateTime $to, int $limit=0, int $offset=0) : array
    {
        $stmt = "WITH items AS (
                    SELECT 
                        (r.deskripsi -> 'customers' ->> 'id')::int as element_id,
                        (r.deskripsi -> 'customers' ->> 'customer_name')::text as element_name,
                        (r.deskripsi -> 'invoice_summary' ->> 'total_summary')::int as element_value,
                        r.created_at
                    FROM reports r
                )
                SELECT a.element_id, a.element_name, SUM(a.element_value) 
                FROM items a
                WHERE a.created_at BETWEEN :from AND :to
                GROUP BY a.element_id, a.element_name";

$reports = DB::select($stmt, ['from' => $from->format('Y-m-d H:i:s'), 'to' => $to->format('Y-m-d H:i:s'), 'limit' => $limit, 'offset' => $offset]);
         return $reports;
    }

    /**
     * Summary of getFilteredReports
     * @param string $type
     * @param \DateTime $from
     * @param \DateTime $to
     * @return Collection
     */
    public static function getFilteredReports(string $type, \DateTime $from, \DateTime $to,int $limit=0, int $offset=0): Collection
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

}
