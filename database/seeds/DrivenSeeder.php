<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Mweaver\Store\Product\Product;
use Mweaver\Store\Catalog\Catalog;
use Mweaver\Store\Catalog\Category;

/**
 * Description of ProductDrivenSeeder
 *
 * @author MIchael
 */
class DrivenSeeder extends Seeder {

    //put your code here


    /* Given a driving table read all the rows in chunks and then  
     * based on that data write new rows of data to an associated table
     */

    public function populateTableFromDrivingTable(&$driver, 
            $outputTableName, $commitCnt, &$data, $outputRowPopulaterFunc) {
        $driver->chunk(200, function($rows) use ($commitCnt,
                $data, $outputRowPopulaterFunc, $outputTableName) {
            $inserts = array();
            $cnt = 0; // Use this to avoid mutiple calls to count()
            foreach ($rows as $row) {
                $outputRowPopulaterFunc($row, $inserts, $data);
                if (++$cnt >= $commitCnt) {
                    DB::table($outputTableName)->insert($inserts);
                    $inserts = array();
                    $cnt = 0;
                }
            }
            if (count($inserts) != 0) {
                DB::table($outputTableName)->insert($inserts);
            }
        });
    }
}
