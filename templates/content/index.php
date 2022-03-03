
<?php if($_['hooks']){ ?>
    <div class="app-content-list" style="min-width:300px">
    <?php foreach($_['hooks'] as $name => $params){ ?>
        <form method=post action="./hooks_post" autocomplete="off" class="app-content-list-item" style="padding-left:50px">
            <input type="submit" value='' class="app-content-list-item-icon <?=($params['pin']?'icon-category-auth':'icon-play')?>" style="background-color: #55557f"></input>
            <input type=hidden name='name' value='<?=$name?>' />
            <div class="app-content-list-item-line-one">
            <?php if($params['pin']){ ?>
                <input type=number name='pin' value='' autocomplete="false" placeholder="<?=$name?>" />
            <?php }else{ ?>
                <?=$name?>
            <?php }?>
            </div>
        </form>
    <?php } ?>
    </div>
<?php } ?>


<?php if($_['apihk']){ ?>
    <div class="app-content-list" style="min-width:400px">
        <div class="app-content-list-item">
            <div class="app-content-list-item-line-one">Received hooks.</div>
            <div class="icon-triangle-s"></div>
        </div>
        <?php foreach(array_reverse($_['apihk']) as $k => $v){ unset($v['params']['_route']); unset($v['params']['key']);  ?>
            <div class="app-content-list-item" >
                <div class="app-content-list-item-line-one"><?=date('y-m-d H:i:s',(int) $v['time'])?>&nbsp;<b><?php echo $v['topic']; unset($v['params']['topic']);?></b></div>
                <div class="app-content-list-item-line-two"><?=str_replace("' => '",": ",substr(var_export($v['params'],true),10,-3))?></div>
            </div>
        <?php } ?>
    </div>
<?php } ?>

<?php if($_['uidat']){ ?>
    <div class="app-content-list" >
        <div class="app-content-list-item">
            <div class="app-content-list-item-line-one">Latest response.</div>
            <div class="icon-triangle-s"></div>
        </div>
        <?php foreach($_['uidat'] as $name => $data){ ?>
            <div class="app-content-list-item" >
                <div class="app-content-list-item-line-one"><?=$name?></div>
                <div class="app-content-list-item-line-two"><?=var_export($data,true)?></div>
            </div>
        <?php } ?>
    </div>
<?php } ?>
