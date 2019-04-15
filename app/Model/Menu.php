<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Material;
use App\Model\Weixin;
class Menu extends Model
{

    protected $table="menu";
    protected $primaryKey="m_id";

    public $timestamps = false;
    public static function getPidInfo($id)
    {
        $data=self::where('pid',$id)->get()->toArray();
        return $data;
    }
}
