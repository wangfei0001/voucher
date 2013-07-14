<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<div class="row">
    <div class="span3">
        <div id="sidebar">
            <?php
//            $this->beginWidget('zii.widgets.CPortlet', array(
//                'title'=>'Operations',
//            ));
//            $this->widget('bootstrap.widgets.TbMenu', array(
//                'items'=>$this->menu,
//                //'htmlOptions'=>array('class'=>'operations'),
//            ));
//            $this->endWidget();

            $this->widget('bootstrap.widgets.TbMenu', array(
                'type'=>'list', // '', 'tabs', 'pills' (or 'list')
                'stacked'=>false, // whether this is a stacked menu
                'items'=>array(
                    array('label'=>'账户概要', 'url'=>$this->createUrl('account/index'), 'active'=>Yii::app()->controller->selectedMenu == 'summary'? true:false),
                    array('label'=>'发布的折扣', 'url'=>$this->createUrl('vouchers/list'), 'active'=>Yii::app()->controller->selectedMenu == 'list'? true:false),
                    array('label'=>'商铺信息', 'url'=>$this->createUrl('setting/store'), 'active'=>Yii::app()->controller->selectedMenu == 'store'? true:false),
                    array('label'=>'设置', 'url'=>$this->createUrl('setting/profile'), 'active'=>Yii::app()->controller->selectedMenu == 'profile'? true:false),
                    array('label'=>'Messages', 'url'=>'#'),
                ),
            ));

            ?>

        </div><!-- sidebar -->
    </div>
    <div class="span9">
        <div id="content">
            <?php echo $content; ?>
        </div><!-- content -->
    </div>

</div>
<?php $this->endContent(); ?>