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
//主页 我的潮购 潮购记录 晒单
route::any('/',"IndexController@index");
route::prefix("user")->group(function (){
    route::any('page',"IndexController@user");
    route::any('buyrecord',"IndexController@buyrecord");
    route::any('willshare','IndexController@willshare');
});
// 购物车列表 所有商品列表 商品详情
route::prefix('shop')->group(function(){
    route::any('cart',"ShopController@shopcart")->Middleware('logs');
    route::any('allshops','ShopController@allshops');
    route::any('shopcontent','ShopController@shopcontent');
    route::any('getcateid','ShopController@getcateid');
    route::any('getcart','ShopController@getcart');

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