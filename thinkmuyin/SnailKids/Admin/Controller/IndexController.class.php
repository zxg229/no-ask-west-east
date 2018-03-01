<?php
namespace Admin\Controller;
use Think\Controller;

header('Content-type:text/html;charset=utf-8');

class IndexController extends Controller
{	
    public function login(){
		session(null);
        $this->display();
    }

	public function verify(){
		$config =    array(
				'expire' 	  => 	60,
				'length'      =>    4,     // 验证码位数
				'useNoise'    =>    false, // 关闭验证码杂点
				'useCurve'	  =>	false,
				'bg'		  =>	array(255,255,255),
				'fontttf'     =>	'4.ttf',
		);
		$Verify =     new \Think\Verify($config);
		$Verify->entry();
	}

    public function loginDo(){
		$username = I('post.username','');
		$password = I('post.password','');
		$verifyCode = I('post.verifyCode','');

		//参数空校验
		if($username == '' || $password == '' || $verifyCode == ''){
			$this->assign('loginResult', 'paramError');
			if($username != ''){
				$this->assign('tempUsername',$username);
			}
			$this->display('login');
			return;
		}

		//验证码校验
		$verify = new \Think\Verify();
		if(!$verify->check($verifyCode)){
			$this->assign('loginResult', 'verifyError');
			$this->assign('tempUsername',$username);
			$this->display('login');
			return;
		}

		//用户名密码校验
		$admin = M("Admin");
		$data['username'] = $username;
		$data['enable'] = 1;
		$result = $admin->where($data)->find();
		if($result){
			$passwordMd5 = $result['password_md5'];
			if(md5($password) != $passwordMd5){
				$this->assign('loginResult', 'passwordError');
				$this->assign('tempUsername',$username);
				$this->display('login');
				return;
			}
			else{
				//登录成功
				session('SNAILKIDS_ADMIN_REALNAME',$result['realname']);
				session('SNAILKIDS_ADMIN_USERNAME',$username);
				session('SNAILKIDS_ADMIN_ID',$result['id']);
				$data = null;
				$data['id'] = $result['id'];
				$data['login_time'] = time();
				$admin->save($data);
				$this->redirect('Index/index');
			}
		}
		else{
			$this->assign('loginResult', 'usernameError');
			$this->assign('tempUsername',$username);
			$this->display('login');
			return;
		}

    }
	
	public function index(){
		if(session('SNAILKIDS_ADMIN_REALNAME') == null){
			$this->redirect('Index/login');
		}
		else{
			$this->display();
		}
	}
	
	public function top(){
		$this->display();
	}
	
	public function left(){
		$this->display();
	}
}