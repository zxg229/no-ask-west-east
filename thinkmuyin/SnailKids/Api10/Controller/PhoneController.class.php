<?php
namespace Api10\Controller;
use Think\Controller;
use Think\Phonecode;

header('Content-type:text/html;charset=utf-8');

class PhoneController extends Controller
{

    //主帐号,对应官s网开发者主账号下的 ACCOUNT SID
    private $accountSid= null;
    //主帐号令牌,对应官网开发者主账号下的 AUTH TOKEN
    private $accountToken= null;
    //应用Id，在官网应用列表中点击应用，对应应用详情中的APP ID
    //在开发调试的时候，可以使用官网自动为您分配的测试Demo的APP ID
    private $appId=null;
    //请求地址
    //沙盒环境（用于应用开发调试）：sandboxapp.cloopen.com
    //生产环境（用户应用上线使用）：app.cloopen.com
    private $serverIP=null;
    //请求端口，生产环境和沙盒环境一致
    private $serverPort=null;
    //REST版本号，在官网文档REST介绍中获得。
    private $softVersion=null;
    

     public function index($phone)
    {
         //主帐号,对应官网开发者主账号下的 ACCOUNT SID
        $this->accountSid= '8a216da85d7dbf78015d83a25fe90322';
        //主帐号令牌,对应官网开发者主账号下的 AUTH TOKEN
        $this->accountToken= 'a01a7a00caeb42f78458264344db2ae1';
        //应用Id，在官网应用列表中点击应用，对应应用详情中的APP ID
        //在开发调试的时候，可以使用官网自动为您分配的测试Demo的APP ID
        $this->appId='8aaf07085f9eb021015fbdcba6020aa2';
        //请求地址
        //沙盒环境（用于应用开发调试）：sandboxapp.cloopen.com
        //生产环境（用户应用上线使用）：app.cloopen.com
        $this->serverIP='sandboxapp.cloopen.com';
        //请求端口，生产环境和沙盒环境一致
        $this->serverPort='8883';
        //REST版本号，在官网文档REST介绍中获得。
        $this->softVersion='2013-12-26';
        $sj = rand(1000,9999);
        S('smscode',$sj,3600);
        //        var_dump(S('code'));
        //echo json_encode($request->input('phone'));
        $this->sendTemplateSMS($phone,array($sj,'10'),"1");
    }
     
      public function sendTemplateSMS($to,$datas,$tempId)
    {
         // 初始化REST SDK
         $accountSid = $this->accountSid;
         $accountToken = $this->accountToken;
         $appId = $this->appId;
         $serverIP = $this->serverIP;
         $serverPort = $this->serverPort;
         $softVersion = $this->softVersion;
         $rest = new Phonecode($serverIP,$serverPort,$softVersion);
         $rest->setAccount($accountSid,$accountToken);
         $rest->setAppId($appId);
        
         // 发送模板短信
         //echo "Sending TemplateSMS to $to <br/>";
         $result = $rest->sendTemplateSMS($to,$datas,$tempId);
         if($result == null ) {
             echo "result error!";
             //break;
         }
         if($result->statusCode!=0) {
             echo "error code :" . $result->statusCode . "<br>";
             echo "error msg :" . $result->statusMsg . "<br>";
             //TODO 添加错误处理逻辑
         }else{
             echoJsonData(C('RESULT_CODE_ARR')['OK'], "短信发送成功");
             //TODO 添加成功处理逻辑
         }
    }


    //手机注册验证模块
    public function regist()
    {

        $smscode = S('smscode');
        $code = I('post.code');
        $phone = I('post.phone');
        if (empty($code)) {
            echoJsonData(C('RESULT_CODE_ARR')['NODATA'], "null");//去配置里定义参数，手机号为空
            exit;
        }
        if (!$code == $smscode) {
            echoJsonData(C('RESULT_CODE_ARR')['CODE_ERROR'], null);
            S('smscode', null);
        } else {
            S('smscode', null);
            $userModel = M('User');
            $iData['phone'] = $phone;
            $userObj = $userModel->where($iData)->find();
            if ($userObj == NULL) {
                //查库无此手机号信息，视为注册
                //返回随机用户名和手机号
                $nowTime = time();
                $userData = array();
                $userData['username'] = $nowTime . mt_rand(10, 99); //随机生成用户名
                $userData['channel'] = 1;
                $userData['regist_time'] = $nowTime;
                $userData['login_time'] = $nowTime;
                $userData['phone'] = $phone;
                $userData['password'] = null;
                $userData['enable'] = 1;
                $userData['info_complete'] = 0;
                $addResult = $userModel->add($userData);
                if ($addResult) {
                    //插入数据库成功
                    $registData = array(
                        'user_id' => $addResult,
                        'username' => $userData['username'],
                        'phone' => $userData['phone'],
                        'info_complete' => $userData['info_complete']
                    );
                    echoJsonData(C('RESULT_CODE_ARR')['OK'], $registData);
                } else {
                    //插入数据库失败
                    echoJsonData(C('RESULT_CODE_ARR')['POST_ERROR'], null);
                    exit;
                }
            } elseif ($userObj == false) {
                //查询出错
                echoJsonData(C('RESULT_CODE_ARR')['QUERY_ERROR'], null);
            } else {
                //查询成功，视为登陆
                $loginData = array(
                    'user_id' => $userObj['id'],
                    'username' => $userObj['username'],
                    'phone'=> $userObj['phone'],
                    'info_complete' => $userObj['info_complete']
                );
                echoJsonData(C('RESULT_CODE_ARR')['OK'], $loginData);
            }

        }

    }


}