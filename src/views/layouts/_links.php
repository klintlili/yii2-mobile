<?php

use snor\web\models\HomeIndex;

/** @var $link_cate_id integer */
?>
<?php $links = HomeIndex::getLinks($link_cate_id);?>
<?php if(!empty($links)) { ?>
    <div class="friend_link clearfix">
        <span>友情链接：</span>
        <?php /** @var $link \snor\web\models\Links */  ?>
        <?php foreach ($links as $key => $link){ ?>
            <a href="<?=$link->url;?>"<?=$key==0?' style="margin-left:0;"':'';?>><?=$link->name;?></a>
        <?php } ?>
    </div>
<?php } ?>
<?php unset($links); ?>
