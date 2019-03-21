<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Register;
use Illuminate\Support\Facades\Validator;
use App\Model\Admin;
use App\Http\Controllers\Common;
class RegisterController extends Controller
{
    //注册页面
    public function register()
    {
        return view('register');
    }
    /*注册执行
     * @param $request
     */
    public function registerdo(Register $request)
    {
        // dd($request);die;
        //进行控制器验证
        $validate=$request->validated();
        //接受传过来的值
        $admin_tel=$request->admin_tel;
//        echo $admin_tel;die;
        $admin_pwd=$request->admin_pwd;
        $new_pwd=$request->new_pwd;
        $admin_pwd1=encrypt($admin_pwd);
        $admin_pwd2=decrypt($admin_pwd1);
        $code=$request->code;
        $new_code=session('mobilecode');
        if($code!=$new_code){
            echo "验证码不一致请核对再试";die;
        }
        $data=[
            'admin_tel'=>$admin_tel,
            'admin_pwd'=>$admin_pwd1,
        ];
        if($new_pwd!=$admin_pwd2){
            echo "两次输入的密码不一致";die;
        }
        $res=Admin::insert($data);
//        var_dump($res);die;
        if($res){
            echo 1;
        }
    }

    public function codedo(Request $request)
    {
        $admin_tel=$request->admin_tel;
       // echo $admin_tel;
        $this->sendMobile($admin_tel);

    }
    
    /*手机验证码
     * @params $mobile 要发送的手机号
     */
    public function sendMobile($mobile)
    {
        $host = env('MOBILE_HOST');
        $path = env('MOBILE_PATH');
        $method = "POST";
        $appcode = env('MOBILE_APPCODE');
        $headers = array();
        $code=Common::createcode(4);
        session(['mobilecode'=>$code]);
        array_push($headers, "Authorization:APPCODE " . $appcode);
        $querys = "content=【创信】你的验证码是：".$code."，3分钟内有效！&mobile=".$mobile;
        $bodys = "";
        $url = $host . $path . "?" . $querys;

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_FAILONERROR, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, true);
        if (1 == strpos("$".$host, "https://"))
        {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        }
        var_dump(curl_exec($curl));
    }
    
    /*
     * 登录页面
     * @param $request
     */
    public function login()
    {

        return view('login');
    }
    //登录执行页面
    public function logindo(Request $request)
    {
        $admin_tel=$request->admin_tel;
        $admin_pwd=$request->admin_pwd;
        $code=$request->_code;//用户输入的验证码
        $_code=session('code');//session中存的验证码
        if($code!=$_code){
            echo "验证码输入错误,请核对后再试";exit;
        }
        $where=[
            'admin_tel'=>$admin_tel
        ];
        $arr=Admin::where($where)->first();
        $new_pwd=decrypt($arr['admin_pwd']);
        if($arr['admin_tel']==$admin_tel){
            if($admin_pwd==$new_pwd){
                session(['admin_id' =>$arr['admin_id']]);
                echo "1";
            }else{
                echo "密码错误";
            }
        }else{
            echo "账号错误";
        }
    }

}
