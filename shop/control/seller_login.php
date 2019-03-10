<?php
/**
 * @desc 商家登录
 * @date 2018-05-21
 */
defined('LmShop') or exit('Access Invalid!');

class seller_loginControl extends BaseSellerControl {


    /**
     * seller_loginControl constructor.
     */
	public function __construct() {
		parent::__construct();
		//已登录跳转到商家中心
        if (!empty($_SESSION['seller_id'])) {
            header('location: index.php?act=seller_center');die;
        }
	}


    /**
     * @desc 商家登录页面展示
     * @date 2018-05-21
     * @author fzt
     */
    public function indexOp() {
        Tpl::output('nchash', getNchash());
        Tpl::setLayout('null_layout');
        Tpl::showpage('login');
    }


    /**
     * @desc 处理登录提交
     * @date 2018-05-21
     * @author fzt
     */
    public function loginOp() {
        //检测提交是否合法
        $result = check_submit(true,true,'num');
        if ($result){
            if ($result === -11){
                showDialog('用户名或密码错误','','error');
            } elseif ($result === -12){
                showDialog('验证码错误','','error');
            }
        } else {
            showDialog('非法提交','','error');
        }
        $model_seller = Model('seller');
        $seller_name = empty($_POST['seller_name']) ? '' : $_POST['seller_name'];
        if(empty($seller_name)) {
            showDialog('请输入用户名','','error');
        }
        $seller_info = $model_seller->getSellerInfo(array('seller_name' => $seller_name));
        if($seller_info) {
            $model_member = Model('member');
            $member_info = $model_member->getMemberInfo(array('member_id' => $seller_info['member_id']));
            if($member_info) {
                $post_password = empty($_POST['password']) ? '' : $_POST['password'];
                $password = $member_info['member_passwd'];
                if($password != md5($post_password)) {
                    showDialog('密码错误','','error');
                }

                $model_seller->editSeller(array('last_login_time' => TIMESTAMP), array('seller_id' => $seller_info['seller_id']));
                $model_seller_group = Model('seller_group');
                $seller_group_info = $model_seller_group->getSellerGroupInfo(array('group_id' => $seller_info['seller_group_id']));
                $model_store = Model('store');
                $store_info = $model_store->getStoreInfoByID($seller_info['store_id']);

                $_SESSION['is_login'] = '1';
                $_SESSION['member_id'] = $member_info['member_id'];
                $_SESSION['member_name'] = $member_info['member_name'];
    			$_SESSION['member_email'] = $member_info['member_email'];
    			$_SESSION['is_buy']	= $member_info['is_buy'];
    			$_SESSION['avatar']	= $member_info['member_avatar'];

                $_SESSION['grade_id'] = $store_info['grade_id'];
                $_SESSION['seller_id'] = $seller_info['seller_id'];
                $_SESSION['seller_name'] = $seller_info['seller_name'];
                $_SESSION['seller_is_admin'] = intval($seller_info['is_admin']);
                $_SESSION['store_id'] = intval($seller_info['store_id']);
                $_SESSION['store_name']	= $store_info['store_name'];
                $_SESSION['is_own_shop'] = (bool) $store_info['is_own_shop'];
                $_SESSION['bind_all_gc'] = (bool) $store_info['bind_all_gc'];
                $_SESSION['seller_limits'] = explode(',', $seller_group_info['limits']);
                if($seller_info['is_admin']) {
                    $_SESSION['seller_group_name'] = '管理员';
                    $_SESSION['seller_smt_limits'] = false;
                } else {
                    $_SESSION['seller_group_name'] = $seller_group_info['group_name'];
                    $_SESSION['seller_smt_limits'] = explode(',', $seller_group_info['smt_limits']);
                }
                if(!$seller_info['last_login_time']) {
                    $seller_info['last_login_time'] = TIMESTAMP;
                }
                $_SESSION['seller_last_login_time'] = date('Y-m-d H:i', $seller_info['last_login_time']);
                $seller_menu = $this->getSellerMenuList($seller_info['is_admin'], explode(',', $seller_group_info['limits']));
                $_SESSION['seller_menu'] = $seller_menu['seller_menu'];
                $_SESSION['seller_function_list'] = $seller_menu['seller_function_list'];
                if(!empty($seller_info['seller_quicklink'])) {
                    $quicklink_array = explode(',', $seller_info['seller_quicklink']);
                    foreach ($quicklink_array as $value) {
                        $_SESSION['seller_quicklink'][$value] = $value ;
                    }
                }
                $this->recordSellerLog('登录成功');
                redirect('index.php?act=seller_center');
            } else {
                showMessage('用户密码错误', '', '', 'error');
            }
        } else {
            showMessage('用户不存在', '', '', 'error');
        }
    }
}
