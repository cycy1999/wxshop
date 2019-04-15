<?php
namespace App\Model;
class Weixin
{
//　/**
//// * 模拟post进行url请求
//// * @param string $url
//// * @param string $param
//// */
    public  static function HttpsPost($url,$info)
    {
        $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_URL,$url);//抓取指定网页
        curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);//https请求 不验证证书
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $info);
        $data = curl_exec($ch);//运行curl
        curl_close($ch);
        return $data;
    }

    /*
     *图灵机器人
     */
    public static function tuling($keywords)
    {
        $data=[
            'perception'=>[
                'inputText'=>[
                    'text'=>$keywords
                ],
            ],
            'userInfo'=>[
                'apiKey'=>'dce52940bbb0404fa89df709c5ce4d67',
                'userId'=>'2222'
            ],
        ];
        $post_data=json_encode($data);
        $tuling_url="http://openapi.tuling123.com/openapi/api/v2";
        $re=Weixin::HttpsPost($tuling_url,$post_data);

        return $re;
    }

    /*
     * @content 获取城市名称
     */
    public static function getcity($keywords)
    {
        $city=substr($keywords,0,strpos($keywords,'天气'));

        return $city;
    }
    /*
     * 获取城市天气
     */
    public static function getcityweather($city)
    {
        $appkey=env('WEIXINAPPKEY');
        $sign=env('WEIXINSIGN');
        $url="http://api.k780.com/?app=weather.today&weaid=$city&appkey=$appkey&sign=$sign&format=json";
        $data=file_get_contents($url);
        $data=json_decode($data,true);
        $result=$data['result'];
        $str="今天是".$result['days'].'日'.$result['week']."\r\n";
        $str.='天气'.$result['weather']."\r\n";
        $str.='您所在的城市'.$result['citynm']."\r\n";
        $str.='今日气温最高'.$result['temp_high'].'最低'.$result['temp_low'];

        return $str;
    }

}
