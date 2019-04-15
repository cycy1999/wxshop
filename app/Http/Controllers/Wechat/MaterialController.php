<?php
namespace App\Http\Controllers\Wechat;
use App\Http\Controllers\Controller;
use App\Model\Material;
use App\Model\Weixin;
use CURLFile;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    //文件上传
    public function uploadFile()
    {
        return view('weixin.uploadfile');
    }

    public function doupload(Request $request)
    {
            $file=$request->picture;
//        dd($file);
            $res=Material::uploadfile($file);
            $imgpath=$res['imgpath'];
            $data=$res['data'];
            $token=Material::setAccressToken();
            $type=Material::getType($data);
            $url="https://api.weixin.qq.com/cgi-bin/media/upload?access_token=$token&type=$type";
//            echo $url;
            $data=['media'=>new CURLFile(realpath($imgpath))];
//            var_dump($data);die;
            $re=Weixin::HttpsPost($url,$data);
//            var_dump($re);
            $arr=json_decode($re,true);
            if(isset($arr['errcode'])){
                die($arr['errmsg']);
            }else{
                $media_id=$arr['media_id'];
//                echo $media_id;die;
            }
    }
    //调用存储token方法
    public function createToken()
    {
        $res=Material::setAccressToken();
//        echo $res;
    }
}