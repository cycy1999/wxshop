<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    protected $table="orders";
    //获取订单号的详细信息
    public static function orderInfo($ordernum){
        $data=self::where('ordernum',$ordernum)->first()->toArray();
        return $data;
    }
    //获取订单号
    public static function getOrderNum($keywords)
    {
        $str="/^订单(\\d+)$/";
        preg_match($str,$keywords,$results);
        return $results;
    }
}
