<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//主页 我的潮购 潮购记录 晒单 钱包     //点击设置 安全设置 修改密码
route::any('/',"IndexController@index");
route::prefix("user")->group(function (){
    route::any('page',"IndexController@user")->Middleware('logs');
    route::any('buyrecord',"IndexController@buyrecord");
    route::any('willshare','IndexController@willshare');
    route::any('mywallet','IndexController@mywallet');
    route::any('seting','IndexController@seting');
    route::any('edituser','IndexController@edituser');
    route::any('safeset','IndexController@safeset');
    route::any('respwd','IndexController@respwd');
    route::any('updpwd','IndexController@updpwd');
});
// 购物车列表 所有商品列表 商品详情 //搜索
route::prefix('shop')->group(function(){
    route::any('cart',"ShopController@shopcart")->Middleware('logs');
    route::any('allshops','ShopController@allshops');
    route::any('shopcontent','ShopController@shopcontent');
    route::any('getcateid','ShopController@getcateid');
    route::any('getcart','ShopController@getcart');
    route::post('search','ShopController@search');
    route::get('cartdel','ShopController@cartdel');

});
//注册页面
route::any('register',"RegisterController@register");
route::post('registerdo',"RegisterController@registerdo");
route::post('codedo','RegisterController@codedo');

//登录页面
route::any('login','RegisterController@login');
route::post('logindo','RegisterController@logindo');

//验证码
route::any('verify/create',"CodeController@create");

//点击加号
route::post('jia','ShopController@goodsjia');
//点击去结算
route::post('account','ShopController@getaccount')->Middleware('logs');
route::any('payment','ShopController@payment')->Middleware('logs');
//点击删除
route::any('cartalldel','ShopController@cartalldel');
//点击编辑
route::any('address','ShopController@address');
//点击添加收货地址
route::any('saveaddress','ShopController@saveaddress');
route::any('addaddress','ShopController@addaddress');
route::get('addressedit','ShopController@addressedit');
//点击默认
route::get('default','ShopController@default');
//点击删除
route::get('addressdel','ShopController@addressdel');
route::get('addressupd','ShopController@addressupd');
//支付宝
route::prefix('alipay')->group(function(){
    route::get('mobilepay',"AlipayController@mobilepay");
});