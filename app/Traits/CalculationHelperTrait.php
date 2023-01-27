<?php
namespace App\Traits;


trait CalculationHelperTrait {

    /**
     * Simple arithmathics operations
     *
     * @param integer $a
     * @param integer $b
     * @param string $operator
     * @return integer
     */
    public function arithmethic(int $a, int $b, string $operator): int 
    {
        switch($operator)
        {
            case '+': return $a + $b;  
            case '-': return $a - $b;  
            case 'x': return $a * $b;  
            case '/': return $a / $b;  
        }
    }

    /**
     * Calculate percentage of a fixed numbers
     *
     * @param integer $amount
     * @param integer $input
     * @return integer
     */
    public function percentOf(int $amount, int $num): int 
    {
        return floor(( $amount / 100 ) * $num);
    }

    /**
     * Calculate percent number by known fixed number
     *
     * @param integer $total
     * @param integer $num
     * @return integer
     */
    public function percentTo(int $total, int $num): int
    {
        return ($num / $total) * 100;
    }
}

