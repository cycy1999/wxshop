<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Menu;
use App\Model\Material;
use App\Model\Weixin;
class MenuController extends Controller
{
    //查询当前是否有菜单
    public function getMenuList()
    {
        $token = Material::setAccressToken();
        $url = "https://api.weixin.qq.com/cgi-bin/menu/get?access_token=" . $token;
//        echo $url;
        $str = '{"menu":{"button":[{"type":"click","name":"蔡徐坤","key":"V1001_TODAY_MUSIC","sub_button":[]},{"name":"菜单","sub_button":[{"type":"view","name":"搜索","url":"http:\/\/www.soso.com\/","sub_button":[]},{"type":"miniprogram","name":"wxa","url":"http:\/\/mp.weixin.qq.com","sub_button":[],"appid":"wx286b93c14bbf93aa","pagepath":"pages\/lunar\/index"},{"type":"click","name":"赞一下我们","key":"V1001_GOOD","sub_button":[]}]}]}}';
        $data = json_decode($str, true)['menu']['button'];
//        print_r($data);
        $arr = [];
        $arr1 = [];
        //获取一级菜单
        foreach ($data as $key => $value) {
            $arr[$key]['pid'] = 4;
            $arr[$key]['name'] = $value['name'];
            $arr[$key]['type'] = isset($value['type']) ? $value['type'] : null;
            $arr[$key]['url'] = isset($value['url']) ? $value['url'] : null;
            $arr[$key]['key'] = isset($value['key']) ? $value['key'] : null;
            //循环二级菜单
            if (!empty($value['sub_button'])) {
                foreach ($value['sub_button'] as $k => $v) {
//                    print_r($v);
                    $arr1[$k]['pid'] = $key;
                    $arr1[$k]['name'] = $v['name'];
                    $arr1[$k]['type'] = isset($v['type']) ? $v['type'] : null;
                    $arr1[$k]['url'] = isset($v['url']) ? $v['url'] : null;
                    $arr1[$k]['key'] = isset($v['key']) ? $v['key'] : null;

                }

            }

        }
//        print_r($arr);
//        print_r($arr1);
        foreach ($arr as $value) {
            Menu::insert($value);
        }
        foreach ($arr1 as $value) {
            Menu::insert($value);
        }


    }

    //添加视图
    public function menu()
    {
        $menuInfo = Menu::getPidInfo(4);
        return view('weixin.menu', ['menuInfo' => $menuInfo]);
    }

    //执行页面
    public function domenu(Request $request)
    {
        $data = $request->all();
//        dd($data);
        unset($data['_token']);
        Menu::insert($data);
    }


    //从数据库中获取菜单
    public function menushow()
    {
        $data = Menu::get();
        return view('weixin.menushow', ['data' => $data]);
    }

    public function getmenu(Request $request)
    {
        $m_id=$request->m_id;
//        echo $m_id;
        $arr=Menu::getPidInfo($m_id);
        return json_encode($arr);
    }
    //获取已启用的菜单
    public function wxmenu()
    {
        $menuInfo = Menu::where('status','=',1)->get()->toArray();
       print_r($menuInfo);die;
        $data = [];
        foreach ($menuInfo as $key => $value) {
            if ($value['pid'] == 4) {
                //一级菜单下有二级菜单的情况下没有type类型
                if (empty($value['type'])) {
                    $pid = $value['m_id'];
                    $sonmenu = Menu::getPidInfo($pid);
                    $sonarr = [];
                    foreach ($sonmenu as $k => $v) {
                        if ($v['type'] == 'click') {
                            $sonarr[] = [
                                'name' => $v['name'],
                                'type' => $v['type'],
                                'key' => $v['key']
                            ];
                        } else if ($v['type'] == 'view') {
                            $sonarr[] = [
                                'name' => $v['name'],
                                'type' => $v['type'],
                                'url' => $v['url']
                            ];
                        }

                    }
                    $data[] = [
                        'name' => $value['name'],
                        'sub_button' => $sonarr
                    ];
                } else if ($value['type'] == 'click') {
                    $data[] = [
                        'name' => $value['name'],
                        'type' => $value['type'],
                        'key' => $value['key']
                    ];
                } else if ($value['type'] == 'view') {
                    $data[] = [
                        'name' => $value['name'],
                        'type' => $value['type'],
                        'url' => $value['url']
                    ];
                }
            }
        }
        $data = [
        'button' => $data
    ];
//        print_r($data);
        $str=json_encode($data, JSON_UNESCAPED_UNICODE);
        $token=Material::setAccressToken();
        $url="https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$token;
        $res=Weixin::HttpsPost($url,$str);
        var_dump($res);
    }
    //做禁用操作
    public function menudel(Request $request)
    {
        $m_id=$request->m_id;
//        echo $m_id;
        $where=[
            'm_id'=>$m_id
        ];
       $res= Menu::where($where)->update(['status'=>2]);
       if($res){
           echo 1;
       }else{
           echo 2;
       }
    }

}
