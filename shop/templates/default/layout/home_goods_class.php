<div class="title"> <i></i>
  <h3><a href="<?php echo urlShop('category', 'index');?>"><?php echo $lang['nc_all_goods_class'];?></a></h3>
</div>
<div class="category">
  <ul class="menu">
      <?php if (!empty($output['show_goods_class']) && is_array($output['show_goods_class'])) { $i = 0; ?>
      <?php foreach ($output['show_goods_class'] as $key => $val) { $i++; ?>
      <li cat_id="<?php echo $val['gc_id'];?>" class="<?php echo $i%2==1 ? 'odd':'even';?>" <?php if($i>11){?>style="display:none;"<?php }?>>
          <!-- 第一级 -->
          <div class="class">
              <span class="arrow"></span>
              <?php if(!empty($val['pic'])) { ?>
                  <span class="ico"><img src="<?php echo $val['pic'];?>"></span>
              <?php } ?>
              <?php if (!empty($val['channel_id'])) {?>
                  <h4><a href="<?php echo urlShop('channel','index',array('id'=> $val['channel_id']));?>"><?php echo $val['gc_name'];?></a></h4>
              <?php }else{?>
                  <h4><a href="<?php echo urlShop('search','index',array('cate_id'=> $val['gc_id']));?>"><?php echo $val['gc_name'];?></a></h4>
              <?php } ?>
          </div>
          <div class="sub-class" cat_menu_id="<?php echo $val['gc_id'];?>">
              <div class="sub-class-content">
                  <div class="recommend-class">
                      <?php if (!empty($val['cn_classs']) && is_array($val['cn_classs'])) { ?>
                          <?php foreach ($val['cn_classs'] as $v) { ?>
                              <span><a href="<?php echo urlShop('search','index',array('cate_id'=> $v['gc_id']));?>" title="<?php echo $v['gc_name']; ?>"><?php echo $v['gc_name'];?></a></span>
                          <?php } ?>
                      <?php } ?>
                  </div>
                  <!-- 第二级 -->
                  <?php if (!empty($val['class2']) && is_array($val['class2'])) { ?>
                      <?php foreach ($val['class2'] as $vv) { ?>
                          <dl>
                              <dt><?php if (!empty($vv['channel_id'])) {?>
                                      <h3><a href="<?php echo urlShop('channel','index',array('id'=> $vv['channel_id']));?>"><?php echo $vv['gc_name'];?></a></h3>
                                  <?php }else{?>
                                      <h3><a href="<?php echo urlShop('search','index',array('cate_id'=> $vv['gc_id']));?>"><?php echo $vv['gc_name'];?></a></h3>
                                  <?php } ?>
                              </dt>

                              <dd class="goods-class">
                                  <?php if (!empty($vv['class3']) && is_array($vv['class3'])) { ?>
                                      <?php foreach ($vv['class3'] as $k3 => $v3) { ?>
                                          <a href="<?php echo urlShop('search','index',array('cate_id'=> $v3['gc_id']));?>"><?php echo $v3['gc_name'];?></a>
                                      <?php } ?>
                                  <?php } ?>
                              </dd>
                          </dl>
                      <?php } ?>
                  <?php } ?>
              </div>
          </div>
      </li>
      <?php }?>
      <?php }?>
  </ul>
</div>
