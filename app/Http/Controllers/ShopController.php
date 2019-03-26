<?php

namespace App\Http\Controllers;

use App\Model\Category;
use App\Model\Goods;
use App\Model\Cart;
use Illuminate\Http\Request;
use App\Model\Area;
use App\Model\Address;
class ShopController extends Controller
{
    //购物车页面
    public function shopcart()
    {
        $admin_id=session('admin_id');
        $where=[
            'admin_id'=>$admin_id,
            'cart_status'=>1
        ];
        $cartInfo=Cart::join('goods','goods.goods_id','=','cart.goods_id')
        ->where($where)->orderBy('cart.create_time','desc')->get();
        $goodsInfo=Goods::take(4)->get();
        return view('shopcart',['cartInfo'=>$cartInfo,'goodsInfo'=>$goodsInfo]);
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
               $time=time();
               Cart::where($where)->update(['buy_number'=>$buy_num,'cart_status'=>1,'create_time'=>$time]);
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
    //删除购物车中的商品
    public function cartdel(Request $request)
    {
        $goods_id=$request->goods_id;
//        echo $goods_id;
        $where=[
            'goods_id'=>$goods_id
        ];
        $res=Cart::where($where)->update(['cart_status'=>2,'buy_number'=>0,'create_time'=>0]);
        if($res){
            echo 1;
        }else{
            echo 2;
        }
    }
    //ajax 跳转页面
    public function getcateid(Request $request)
    {
        $cate_id=$request->input('cate_id');
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
    //搜索
    public function search(Request $request)
    {
        $search=$request->search;
        if(empty($search)){
           $goodsInfo= Goods::get();
        }else{
            $goodsInfo=Goods::where('goods_name','like',"%$search%")->get();
        }
        return view('div',['goodsInfo'=>$goodsInfo]);
    }
    //点击加号
    public function goodsjia(Request $request)
    {
        $num=$request->num;
        $goods_id=$request->goods_id;
       $where=[
           'goods_id'=>$goods_id
       ];
       Cart::where($where)->update(['buy_number'=>$num]);
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

    //提交订单
    public function getaccount(Request $request)
    {
        $goods_id=$request->goods_id;
        session(['goods_id'=>$goods_id]);
    }

    public function payment()
    {
        $goods_id=session('goods_id');
        $goods_id=explode(',',$goods_id);
        $goodsInfo=Cart::join('goods','goods.goods_id','=','cart.goods_id')->whereIn('cart.goods_id',$goods_id)->get();
        $price=0;
        foreach($goodsInfo as $v){
            $price+=$v['buy_number']*$v['self_price'];
        }
        $where=[
            'admin_id'=>session('admin_id'),
            'is_default'=>1
        ];
        $addressInfo=Address::where($where)->first();
        return view('payment',['goodsInfo'=>$goodsInfo,'price'=>$price,'addressInfo'=>$addressInfo]);
    }
    //全删
    public function cartalldel(Request $request)
    {
        $goods_id=$request->goods_id;
        $goods_id=explode(',',$goods_id);
        $res=Cart::whereIn('goods_id',$goods_id)->update(['cart_status'=>2,'buy_number'=>0,'create_time'=>0]);
        if($res){
            echo 1;
        }else{
            echo 2;
        }
    }
    //编辑购物车列表
    public function address()
    {
        $where=[
            'admin_id'=>session('admin_id'),
            'address_status'=>1
        ];
        $addressInfo=Address::where($where)->get();

        return view('address',['addressInfo'=>$addressInfo]);
    }
    //添加收货地址
    public function saveaddress()
    {

        $topAddressInfo=$this->topaddress(0);
        return view('writeaddr',['topAddressInfo'=>$topAddressInfo]);
    }
    //获取顶级收货地址
    public function topaddress($pid)
    {
        $where=[
            'pid'=>$pid
        ];
        $topAddressInfo=Area::where($where)->get();
//        print_r($topAddressInfo);
        return $topAddressInfo;
    }

    public function addaddress(Request $request)
    {
        $data=$request->all();
        unset($data['_token']);
        $admin_id=session('admin_id');
        $data['admin_id']=$admin_id;
        $where=[
            'admin_id'=>$admin_id
        ];
        if($data['is_default']==1){
           $res=Address::where($where)->update(['is_default'=>2]);
           $res=Address::where($where)->insert($data);
        }else{
            $res=Address::where($where)->insert($data);
        }
        if($res){
            echo 1;
        }else{
            echo 2;
        }
    }
    //点击默认
    public function default(Request $request)
    {
        $address_id=$request->address_id;
        $where=[
            'admin_id'=>session('admin_id'),
            'address_id'=>$address_id
        ];
        $newwhere=[
            'admin_id'=>session('admin_id')
        ];
        $res=Address::where($newwhere)->update(['is_default'=>2]);
        $res1=Address::where($where)->update(['is_default'=>1]);
        if($res){
            echo 1;
        }else{
            echo 2;
        }
    }
    //点击删除
    public function addressdel(Request $request)
    {
        $address_id=$request->address_id;
        $where=[
            'address_id'=>$address_id
        ];
        $res=Address::where($where)->update(['address_status'=>2]);
        if($res){
            echo 1;
        }else{
            echo 2;
        }
    }
    //点击编辑
    public function addressedit(Request $request)
    {
        $address_id=$request->address_id;
        $where=[
            'address_id'=>$address_id
        ];
        $addressInfo=Address::where($where)->first();
        return view('addressedit',['addressInfo'=>$addressInfo]);
    }
    //编辑执行
    public function addressupd(Request $request)
    {
        $address_id=$request->address_id;
        $data=$request->all();
        $res=Address::where('address_id',$address_id)->update($data);
        if($res){
            echo 1;
        }else{
            echo 2;
        }
    }
}
