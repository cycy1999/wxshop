<?php

namespace App\Http\Controllers;

use App\Model\Category;
use App\Model\Goods;
use App\Model\Cart;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    //购物车页面
    public function shopcart()
    {
        $admin_id=session('admin_id');
        $where=[
            'admin_id'=>$admin_id
        ];
        $cartInfo=Cart::join('goods','goods.goods_id','=','cart.goods_id')
        ->where($where)->orderBy('cart.create_time','desc')->get();

        return view('shopcart',['cartInfo'=>$cartInfo]);
    }
    //点击加入购物车
    public function getcart(Request $request)
    {
        $goods_id=$request->goods_id;
        $admin_id=session('admin_id');
//        echo $admin_id;
        if(empty($admin_id)){
            echo 1;
        }else{
            $where=[
                'goods_id'=>$goods_id,
                'admin_id'=>$admin_id
            ];
            $cartInfo=Cart::where($where)->first();
           if(empty($cartInfo)){
               $data=[
                   'goods_id'=>$goods_id,
                   'admin_id'=>$admin_id,
                   'create_time'=>time()

               ];
            Cart::insert($data);
           }else{
               $cartInfo2=Cart::where($where)->first();
               $buy_num='';
               $buy_num.=$cartInfo2['buy_number']+1;
               Cart::where($where)->update(['buy_number'=>$buy_num]);
           }

        }


    }
    //显示所有商品
    public function allshops(Request $request)
    {
        $where=[
            'pid'=>0
        ];
        $cateInfo=Category::where($where)->get();//查出顶级分类
        $goodsInfo=Goods::get();//展示全部商品
//        dd($cateInfo);die;
        return view('allshops',['cateInfo'=>$cateInfo,'goodsInfo'=>$goodsInfo]);
    }
    //ajax 跳转页面
    public function getcateid(Request $request)
    {
        $cate_id=$request->cate_id;
//        echo $cate_id;die;
        $type=$request->type;

        if(empty($cate_id)){
            $goodsInfo=Goods::get();//展示全部商品

            if($type==1){
                $goodsInfo=Goods::orderBy('goods_num','desc')->get();
            }
            if($type==2){
                $goodsInfo=Goods::orderBy('is_new','asc')->get();
            }
            if($type==3){
                $goodsInfo=Goods::orderBy('self_price','desc')->get();
            }
        }else{
            $goodsInfo=$this->getcateinfo($cate_id);
        }
        return view('div',['goodsInfo'=>$goodsInfo]);
    }
    //根据得到的二级三级分类id 获取商品
    public function getcateinfo($cate_id)
    {
       $cateInfo=Category::get();
       $cate_id= $this->getSonCateId($cateInfo,$cate_id);//查询出来所有的子类 一维数组
       $goodsInfo=[];
       foreach($cate_id as $v){
          $data=Goods::where('cate_id',$v)->first();
           if(!empty($data)){
               $goodsInfo[]=$data;
           }

       }
//        print_r($goodsInfo);
        return $goodsInfo;
    }
    //根据顶级分类查出所有的子类
    public function getSonCateId($cateInfo,$pid)
    {
        static $cate_id=[];
        foreach($cateInfo as $v){
            if($v['pid']==$pid){
                $cate_id[]=$v['cate_id'];
                $this->getSonCateId($cateInfo,$v['cate_id']);
            }
        }
        return $cate_id;
    }
    //商品详情页
    public function shopcontent(Request $request)
    {
        $goods_id=$request->goods_id;
        $where=[
            'goods_id'=>$goods_id
        ];
        $arr=Goods::where($where)->first(['goods_name','goods_desc','goods_img','self_price']);

        return view('shopcontent',['arr'=>$arr]);
    }

}
