<?php
/**
 * @desc 卖家模型
 * @date 2018-05-21
 */
defined('LmShop') or exit('Access Invalid!');
class sellerModel extends Model
{
    /**
     * sellerModel constructor.
     * @throws Exception
     */
    public function __construct(){
        parent::__construct('seller');
    }

    /**
     * @desc 获取卖家信息
     * @date 2018-05-21
     * @author fzt
     * @param array $condition
     * @return array
     */
    public function getSellerInfo($condition) {
        $result = $this->where($condition)->find();
        return $result;
    }

    /**
     * @desc 获取卖家列表
     * @date 2018-05-21
     * @author fzt
     * @param $condition
     * @param string $page
     * @param string $order
     * @param string $field
     * @return null
     */
	public function getSellerList($condition, $page='', $order='', $field='*') {
        $result = $this->field($field)->where($condition)->page($page)->order($order)->select();
        return $result;
	}

    /**
     * @desc 判断卖家是否存在
     * @date 2018-05-21
     * @author fzt
     * @param $condition
     * @return bool
     */
	public function isSellerExist($condition) {
        $result = $this->getSellerInfo($condition);
        if(empty($result)) {
            return false;
        } else {
            return true;
        }
	}


    /**
     * @desc 新增卖家
     * @date 2018-05-21
     * @author fzt
     * @param $param
     * @return mixed
     */
    public function addSeller($param){
        return $this->insert($param);	
    }

    /**
     * @desc 更新卖家信息
     * @author fzt
     * @date 2018-05-21
     * @param $update
     * @param $condition
     * @return bool|mixed
     */
    public function editSeller($update, $condition){
        return $this->where($condition)->update($update);
    }


    /**
     * @desc 删除卖家
     * @author fzt
     * @date 2018-05-21
     * @param $condition
     * @return bool|mixed
     */
    public function delSeller($condition){
        return $this->where($condition)->delete();
    }
	
}
