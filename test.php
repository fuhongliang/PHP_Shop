<?php
$mysqli = new mysqli('47.89.41.155', 'shop', 'zong123456','shop','3306');

//$mysqli = new mysqli('localhost', 'root', 'root','shop','3306');


$sql = "SELECT * FROM lm_goods_class ORDER BY gc_parent_id asc,gc_sort asc,gc_id asc";

$sql = "SELECT * FROM lm_goods_class";

$result = $mysqli->query($sql);
$rows = array();
while($row = $result->fetch_assoc()){
    $rows[] = $row;
}
$result->free();

echo '<pre>';
var_dump($rows);