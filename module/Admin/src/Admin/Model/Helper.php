<?php
/**
 * Created by PhpStorm.
 * User: antiprovn
 * Date: 9/24/14
 * Time: 8:42 PM
 */

namespace Admin\Model;


class Helper {

    /**
     * @param $time
     * @return bool|string
     */
    public function formatDate($time){
        return $time->format('d.m.Y');
    }
} 