<?php

namespace App\Http\Controllers\Wechat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Weixin;
use App\Model\Event;
use App\Model\Material;
use App\Model\Goods;
class WechatController extends Controller
{
    /*
     * @content 微信绑定服务器校验
     * @param
     */
    public function index(Request $request)
    {

//        $echostr=$request->echostr;
//        if($this->CheckSignature()){
//            echo $echostr;die;
//        }
        $this->responseMsg();
    }
    /*
     * @content 推送消息
     */
    public function responseMsg()
    {
        $poststr=file_get_contents("php://input");//接受全部数据
        $postObj=simplexml_load_string($poststr,'SimpleXMLElement',LIBXML_NOCDATA);//simplexml_load_string() 函数把 XML 字符串载入对象中。

        $toUser=$postObj->ToUserName;
        $formuser=$postObj->FromUserName;
        $time=time();
        $msgtype="text";
        $keywords=$postObj->Content;
        $arr=Goods::where('goods_name',$keywords)->first();
        $tpl="<xml>
              <ToUserName><![CDATA[%s]]></ToUserName>
              <FromUserName><![CDATA[%s]]></FromUserName>
              <CreateTime>%s</CreateTime>
              <MsgType><![CDATA[%s]]></MsgType>
              <Content><![CDATA[%s]]></Content>
            </xml> ";

        //判断是一个事件请求 首次关注回复消息
        if($postObj->MsgType=='event'){
            //判断是一个关注事件
            if($postObj->Event=='subscribe'){
//                $content="nice goods night";
//                $res=sprintf($tpl,$formuser,$toUser,$time,$msgtype,$content);
//                echo $res;
                $type=config('filetype.subscribe');
                Material::$type($type,$formuser,$toUser,$time);

            }
        }
        //关键词回复
        if($keywords=='你好') {
            $contentStr = '早上起来拥抱太阳 满满的正能量';
            $resultStr = sprintf($tpl, $formuser, $toUser, $time, $msgtype, $contentStr);
            echo $resultStr;
            exit();
            //获取字符串首次出现的位置
        }else if($keywords=='图片'){
            $resurl="<xml>
                      <ToUserName><![CDATA[%s]]></ToUserName>
                      <FromUserName><![CDATA[%s]]></FromUserName>
                      <CreateTime><![CDATA[%s]]></CreateTime>
                      <MsgType><![CDATA[%s]]></MsgType>
                      <Image>
                        <MediaId><![CDATA[%s]]></MediaId>
                      </Image>
                    </xml>";
            $msgtype='image';
            $media_id="FUmjsPSstQI9tB5w-oOxHqJpE7Kzu8cWzzPM4-CXiKdYC8hCfFzZYou_n4x99Nk-";
            $result=sprintf($resurl,$formuser,$toUser,$time,$msgtype,$media_id);
            echo $result;
            die;
        }else if($keywords=='图文'){
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
            $title="我的nine";
            $des="欢迎来到我的后援会";
            $picurl=url('/uploads/20190409/688.gif');
            $url="http://blog.aulei521.com";
            $result=sprintf($resurl,$formuser,$toUser,$time,$msgtype,$title,$des,$picurl,$url);
            echo $result;
        }else if(strpos($keywords,'天气')){
            $msg= Weixin::getcity($keywords);
            $weatherurl=Weixin::getcityweather($msg);
            $contentStr=$weatherurl;
            $result=sprintf($tpl,$formuser,$toUser,$time,$msgtype,$contentStr);
            echo $result;
            exit();
        }else if($arr['goods_name']==$keywords){
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
            $title=$arr['goods_name'];
            $des=$arr['goods_desc'];
            $picurl=url('/goodsimg/'.$arr['goods_img']);
            $url="http://blog.aulei521.com";
            $result=sprintf($resurl,$formuser,$toUser,$time,$msgtype,$title,$des,$picurl,$url);
            echo $result;
        }else{
            $re=Weixin::tuling($keywords);
            $msg=json_decode($re,true)['results'][0]['values']['text'];
            $contentStr=$msg;
            $result=sprintf($tpl,$formuser,$toUser,$time,$msgtype,$contentStr);
            echo $result;

        }
    }
    /*
     *
     * @content 校验微信签名
     */
    private function CheckSignature()
    {
        $signature=$_GET['signature'];
        $timestamp=$_GET['timestamp'];
        $nonce=$_GET['nonce'];
        $token=env('WEIXINTOKEN');
        $arr=array($token,$timestamp,$nonce);
        sort($arr);
        $str=implode($arr);
        $sign=sha1($str);
        if($sign==$signature){
            return true;
        }else{
            return false;
        }

    }
}
