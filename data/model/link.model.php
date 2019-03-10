<?php
/**
 * @desc 友情链接
 * @date 2018-05-21
 */
defined('LmShop') or exit('Access Invalid!');

class linkModel
{
    /**
     * @desc 友情链接列表
     * @author fzt
     * @date 2018-05-22
     * @param $condition
     * @param string $page
     * @return array|mixed
     */
    public function getLinkList($condition, $page = '')
    {
        $condition_str = $this->_condition($condition);
        $param = array();
        $param['table'] = 'link';
        $param['where'] = $condition_str;
        $param['order'] = $condition['order'] ? $condition['order'] : 'link_id';
        $result = Db::select($param, $page);
        return $result;
    }

    /**
     * @desc 构造检索条件
     * @author fzt
     * @date 2018-05-22
     * @param $condition
     * @return string
     */
    private function _condition($condition)
    {
        $condition_str = '';

        if ($condition['like_link_title'] != '') {
            $condition_str .= " and link_title like '%" . $condition['like_link_title'] . "%'";
        }
        if ($condition['link_pic'] == 'yes') {
            $condition_str .= " and link_pic != ''";
        }
        if ($condition['link_pic'] == 'no') {
            $condition_str .= " and LENGTH(link_pic)=0";
        }
        return $condition_str;
    }


    /**
     * @desc 取单个内容
     * @author fzt
     * @date 2018-05-22
     * @param $id
     * @return array|bool
     */
    public function getOneLink($id)
    {
        if (intval($id) > 0) {
            $param = array();
            $param['table'] = 'link';
            $param['field'] = 'link_id';
            $param['value'] = intval($id);
            $result = Db::getRow($param);
            return $result;
        } else {
            return false;
        }
    }


    /**
     * @desc 新增
     * @author fzt
     * @date 2018-05-22
     * @param $param
     * @return bool|mixed
     */
    public function add($param)
    {
        if (empty($param)) {
            return false;
        }
        if (is_array($param)) {
            $tmp = array();
            foreach ($param as $k => $v) {
                $tmp[$k] = $v;
            }
            $result = Db::insert('link', $tmp);
            return $result;
        } else {
            return false;
        }
    }


    /**
     * @desc 更新信息
     * @author fzt
     * @date 2018-05-22
     * @param $param
     * @return bool
     */
    public function update($param)
    {
        if (empty($param)) {
            return false;
        }
        if (is_array($param)) {
            $tmp = array();
            foreach ($param as $k => $v) {
                $tmp[$k] = $v;
            }
            $where = " link_id = '" . $param['link_id'] . "'";
            $result = Db::update('link', $tmp, $where);
            return $result;
        } else {
            return false;
        }
    }

    /**
     * @desc 删除
     * @author fzt
     * @date 2018-05-22
     * @param $id
     * @return bool
     */
    public function del($id)
    {
        if (intval($id) > 0) {
            $where = " link_id = '" . intval($id) . "'";
            $result = Db::delete('link', $where);
            return $result;
        } else {
            return false;
        }
    }



}