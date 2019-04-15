<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Material;
use App\Model\Weixin;
use App\Model\Event;
use CURLFile;
use App\Model\Goods;
class WeixinEventController extends Controller
{
    public function index()
    {

        return view('index.index');
    }
    //设置首次关注回复类型
    public function typefirst()
    {
        $type=config("filetype.subscribe");
        return view('index.typefirst',['type'=>$type]);
    }
    //确认回复方式
    public function dotype(Request $request)
    {
        $type=$request->type;
//        echo $type;
        $config=[];
        $config['subscribe']=$type;
        $str="<?php return ".var_export($config,true).";";
//        echo $str;
        $path=config_path("filetype.php");
        $res=file_put_contents($path,$str);
        if($res){
            echo 1;
        }else{
            echo 2;
        }

    }
    //展示视图
    public function add()
    {
        return view('weixin.eventadd');
    }

    //接受数据
    public function doadd(Request $request)
    {

//        $access_token=Material::setAccressToken();
//        $appid=env('WEIXINAPPID');
//        $data=[
//            'appid'=>$appid
//        ];
//        $data=json_encode($data);
//        $qurl="https://api.weixin.qq.com/cgi-bin/clear_quota?access_token=$access_token";
//            $re=Weixin::HttpsPost($qurl,$data);
//            die;

        
//        dd($request);
        //判断文件是否存在
        if($request->hasFile('file')){
            $file=$request->file;
//            dd($file);
            $re=Material::uploadfile($file);
            $imgpath=$re['imgpath'];//照片路径
            $types=$re['data'];//文件类型
//            echo $types;die;
            $access_token=Material::setAccressToken();

            $type=Material::getType($types);
//            echo $type;die;
            $url="https://api.weixin.qq.com/cgi-bin/material/add_material?access_token=$access_token&type=$type";
            $data=['media'=>new CURLFile(realpath($imgpath))];
            $re=Weixin::HttpsPost($url,$data);
//            echo $re;
//            var_dump($re);die;
            $data=json_decode($re,true);
//            dd($data);
            $data=[
                'media_id'=>isset($data['media_id'])?$data['media_id']:null,
                'url'=>isset($data['url'])?$data['url']:null,
                'title'=>$request->input('title',NULL),
                'content'=>$request->input('content',NULL),
                'linkurl'=>$request->input('linkurl',NULL),
                'type'=>$request->input('type',NULL),
            ];
            Event::insert($data);
        }else{
            //文本
            $content=$request->input('content',NULL);
//            echo $content;die;
            $data=[
                'content'=>$content,
                'type'=>'text'
            ];
            Event::insert($data);
        }
    }
}
