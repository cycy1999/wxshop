<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Goods;
use App\Model\Category;
class IndexController extends Controller
{
    //网站商城首页
    public function index()
    {
        $data=Goods::orderBy('goods_id','desc')->take(2)->get();
        $where=[
            'pid'=>0
        ];
        $firstCate=Category::where($where)->take(4)->get();

        return view('index',['data'=>$data,'firstCate'=>$firstCate]);
    }
    //我的潮购页面
    public function user()
    {
        return view('userpage');
    }
    //潮购记录
    public function buyrecord()
    {
        return view('buyrecord');
    }
    //晒单
    public function willshare()
    {
        return view('willshare');
    }

}
