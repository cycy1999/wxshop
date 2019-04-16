<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Weixin;
use App\Model\Material;
use App\Model\Order;
class GroupsController extends Controller
{
    //获取用户列表
    public function setUser()
    {
        $token=Material::setAccressToken();
//        echo $token;die;
        $user_url='https://api.weixin.qq.com/cgi-bin/message/mass/send?access_token='.$token;
//        echo $user_url;
        $userInfo=Material::setAllUser();
//        print_r($userInfo);
        $user_array=[
            'touser'=>$userInfo,
            "msgtype"=> "text",
            "text"=>[
                'content'=>"清早起床 提着花篮轻轻唱",
            ]
        ];
//        print_r($user_array);
        $str=json_encode($user_array,JSON_UNESCAPED_UNICODE);
        $res=Weixin::HttpsPost($user_url,$str);
        print_r($res);
    }

    //获取个性化的菜单
    public function  getPersonal()
    {
        $data=[
          'button'=>[
              [
                  'type'=>'click',
                  'name'=>'我是女生',
                  'key'=>'V1001_TODAY_MUSIC',
              ],
            [
                'name'=>'到达了巅峰',
                'sub_button'=>[
                    [
                        'type'=>'view',
                        'name'=>'搜索',
                        'url'=>'http://www.soso.com/'
                    ],
                    [
                        "type"=> "miniprogram",
                        "name"=>"wxa",
                        "url"=>"http://mp.weixin.qq.com",
                        "appid"=> "wx286b93c14bbf93aa",
                        "pagepath"=> "pages/lunar/index"
                    ],
                    [
                        "type"=> "click",
                        "name"=>"赞一下我们",
                        "key"=>"V1001_GOOD"
                    ]
                ]
            ],
        ],
           'matchrule'=> [
                "sex"=> "2",
            ]
        ];
//        print_r($data);
        $url='https://api.weixin.qq.com/cgi-bin/menu/addconditional?access_token='.Material::setAccressToken();
//        echo $url;
        $str=json_encode($data,JSON_UNESCAPED_UNICODE);
        $res=Weixin::HttpsPost($url,$str);
//        echo $res;

    }
    //创建标签
    public function getLabel()
    {
        $url='https://api.weixin.qq.com/cgi-bin/tags/create?access_token='.Material::setAccressToken();
        $str=[
           'tag'=>[
               'name'=>'蔡徐坤'
           ]
        ];
        $str=json_encode($str,JSON_UNESCAPED_UNICODE);
        $res=Weixin::HttpsPost($url,$str);
//        echo $res;
    }
    //批量为用户设置标签
    public function setUserLabel()
    {
        $url='https://api.weixin.qq.com/cgi-bin/tags/members/batchtagging?access_token='.Material::setAccressToken();
        $open_id=Material::setAllUser();
        $data=[
            'open_id'=>$open_id,
            'tagid'=>100
        ];
        $data=json_encode($data,JSON_UNESCAPED_UNICODE);
        $res=Weixin::HttpsPost($url,$data);
//        echo $res;
    }
    //根据标签进行群发
    public function labGroups()
    {
        $url='https://api.weixin.qq.com/cgi-bin/message/mass/sendall?access_token='.Material::setAccressToken();
        $data=[
            'filter'=>[
                "is_to_all"=>false,
                "tag_id"=>100
            ],
            'text'=>[
                'content'=>'hello 大家好'
            ],
            'msgtype'=>'text'
        ];
        $str=json_encode($data,JSON_UNESCAPED_UNICODE);
        $res=Weixin::HttpsPost($url,$str);
        echo $res;
    }
    
    //模板列表
    public function template()
    {
        $data=[
            "touser"=>"OPENID",
            "template_id"=>"kMF3XS9eBuP0lmyi1xLt5ORG8OFzkNqeg3e1RJMfeiw",

            "data"=>[
                "first"=>[
                    "value"=>"恭喜你购买成功！",
                    "color"=>"#173177"
                ],
                "keyword1"=>[
                    "value"=>"巧克力",
                    "color"=>"#173177"
                ],
                "keyword2"=>[
                    "value"=>"39.8元",
                    "color"=>"#173177"
                ],
                "keyword3"=>[
                    "value"=>"2014年9月22日",
                    "color"=>"#173177"
                ],
                "remark"=>[
                    "value"=>"欢迎再次购买！",
                    "color"=>"#173177"
                ]
            ]
        ];
    }
}