<?php
/**
 * @desc 卖家组
 * @date 2018-05-21
 */
defined('LmShop') or exit('Access Invalid!');
class seller_groupModel extends Model
{

    /**
     * seller_groupModel constructor.
     * @throws Exception
     */
    public function __construct(){
        parent::__construct('seller_group');
    }


    /**
     * @desc 卖家组列表
     * @param $condition
     * @param string $page
     * @param string $order
     * @param string $field
     * @return mixed
     */
	public function getSellerGroupList($condition, $page='', $order='', $field='*') {
        $result = $this->field($field)->where($condition)->page($page)->order($order)->select();
        return $result;
	}



    /**
	 * 读取单条记录
	 * @param array $condition
	 *
	 */
    public function getSellerGroupInfo($condition) {
        $result = $this->where($condition)->find();
        return $result;
    }

	/*
	 *  判断是否存在 
	 *  @param array $condition
     *
	 */
	public function isSellerGroupExist($condition) {
        $result = $this->getOne($condition);
        if(empty($result)) {
            return FALSE;
        } else {
            return TRUE;
        }
	}

	/*
	 * 增加 
	 * @param array $param
	 * @return bool
	 */
    public function addSellerGroup($param){
        return $this->insert($param);	
    }
	
	/*
	 * 更新
	 * @param array $update
	 * @param array $condition
	 * @return bool
	 */
    public function editSellerGroup($update, $condition){
        return $this->where($condition)->update($update);
    }
	
	/*
	 * 删除
	 * @param array $condition
	 * @return bool
	 */
    public function delSellerGroup($condition){
        return $this->where($condition)->delete();
    }
	
}
