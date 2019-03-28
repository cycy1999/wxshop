<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Goods;
use App\Model\Category;
use App\Model\Admin;
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
    //我的钱包页面
    public function mywallet()
    {
        return view('mywallet');
    }
    //点击设置
    public function seting()
    {
        return view('seting');
    }
    //个人资料
    public function edituser()
    {
        return view('edituser');
    }
    //安全设置
    public function safeset()
    {
        return view('safeset');
    }
    //修改密码
    public function respwd()
    {
        return view('resetpassword');
    }

    public function updpwd(Request $request)
    {
        $pwd=$request->pwd;
        $newpwd=$request->newpwd;
        $where=[
            'admin_id'=>session('admin_id'),
        ];
        $userInfo=Admin::where($where)->first();
        $mysql_pwd=$userInfo['admin_pwd'];
        $mysql_pwd=decrypt($mysql_pwd);
        if($pwd!=$mysql_pwd){
            echo 2;die;
        }
        $newpwd=encrypt($newpwd);
        $res=Admin::where($where)->update(['admin_pwd'=>$newpwd]);
        if($res){
            echo 3;
        }else{
            echo 4;
        }
    }

}
