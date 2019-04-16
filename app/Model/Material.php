<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use App\Model\Event;

class Material extends Model
{
    //存储token
    public static function setAccressToken()
    {
        $path=public_path().'/weixin/'.'token.txt';
        $str=file_get_contents($path);
        if(!empty($str)){
            $info=json_decode($str,true);
            //判断是否过期
            if(time()>$info['expires']){
                $token=self::createAccressToken();
                $now=time()+7100;
                $data=[
                    'token'=>$token,
                    'expires'=>$now
                ];
                $str=json_encode($data);
                file_put_contents($path,$str);
            }else{
                //未过期
                $token=$info['token'];
            }
        }else{
            $token=self::createAccressToken();
            $now=time()+7100;
            $data=[
                'token'=>$token,
                'expires'=>$now
            ];
            $str=json_encode($data);
            file_put_contents($path,$str);
        }
        return $token;
    }
    //生成token
    public static function createAccressToken()
    {
        $appid=env('WEIXINAPPID');
        $secret=env('WEIXINAPPSECRET');
        $url="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$secret";
        $str=file_get_contents($url);
        $token=json_decode($str,true);
        $token=$token['access_token'];
        return $token;
    }
    //获取文件类型
    public static function getType($str)
    {
        $arr=explode('/',$str);
        $type=$arr[0];
        $allow_type=[
            'image'=>'image',
            'audio'=>'voice',
            'video'=>'video'
        ];
        return $allow_type[$type];
    }
    //上传文件
    public static function uploadfile($file)
    {
        //接收文件类型
        $data=$file->getClientMimeType();
        //获取文件的后缀名
        $ext=$file->getClientOriginalExtension();
//        echo $ext;
        //获取当前文件的位置 临时文件
        $path=$file->getRealPath();
//        echo $path;
        //上传后的文件名称
        $newfilename=date('Ymd')."/".mt_rand(100,999).'.'.$ext;
        
        //上传文件
        $res=Storage::disk('uploads')->put($newfilename,file_get_contents($path));
        $imgpath=public_path().'/uploads/'.$newfilename;
        $data=['data'=>$data,'imgpath'=>$imgpath];
        return $data;
    }
    //根据选中的类型判断素材 根据图文
    public static function news($type,$formuser,$toUser,$time)
    {
        $resurl="<xml>
                          <ToUserName><![CDATA[%s]]></ToUserName>
                          <FromUserName><![CDATA[%s]]></FromUserName>
                          <CreateTime><![CDATA[%s]]></CreateTime>
                          <MsgType><![CDATA[%s]]></MsgType>
                          <ArticleCount>1</ArticleCount>
                          <Articles>
                            <item>
                              <Title><![CDATA[%s]]></Title>
                              <Description><![CDATA[%s]]></Description>
                              <PicUrl><![CDATA[%s]]></PicUrl>
                              <Url><![CDATA[%s]]></Url>
                            </item>
                          </Articles>
                    </xml>";
            $msgtype="news";
            $data=Event::where('type',$type)->orderBy('e_id','desc')->first();
            $title=$data->title;
            $des=$data->content;
            $picurl=$data->url;
            $url=$data->linkurl;
            $result=sprintf($resurl,$formuser,$toUser,$time,$msgtype,$title,$des,$picurl,$url);
            echo $result;
    }
    //根据文本
    public static function text($type,$formuser,$toUser,$time)
    {
        $tpl="<xml>
              <ToUserName><![CDATA[%s]]></ToUserName>
              <FromUserName><![CDATA[%s]]></FromUserName>
              <CreateTime>%s</CreateTime>
              <MsgType><![CDATA[%s]]></MsgType>
              <Content><![CDATA[%s]]></Content>
            </xml> ";
        $msgtype="text";
        $content=Event::where('type',$type)->first()['content'];
        $resultStr = sprintf($tpl, $formuser, $toUser, $time, $msgtype, $content);
        echo $resultStr;
    }

    /*
    * @content 获取用户列表
    */
    public static function setAllUser()
    {
        $token=self::setAccressToken();
        $url='https://api.weixin.qq.com/cgi-bin/user/get?access_token='.$token;
//        echo $url;
        $str=file_get_contents($url);
        $arr=json_decode($str,true);
       return $arr['data']['openid'];
    }
    //获取media id
    public static function GetMediaId()
    {

    }
}