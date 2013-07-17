<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'merchantNotice')); ?>

<div class="modal-header">
    <a class="close" data-dismiss="modal">&times;</a>
    <h4>商家资料</h4>
</div>

<div class="modal-body">
    <p>使用我们提供的服务之前，请务必填写完整您的商家信息，包括商铺厂商名称，联系人以及所在地址等。</p>
</div>

<div class="modal-footer">
    <?php $this->widget('bootstrap.widgets.TbButton', array(
    'type'=>'primary',
    'label'=>'现在填写',
    'url'=>$this->createUrl('setting/store'),
    //'htmlOptions'=>array('data-dismiss'=>'modal'),
)); ?>
    <?php
//    $this->widget('bootstrap.widgets.TbButton', array(
//    'label'=>'Close',
//    'url'=>'#',
//    'htmlOptions'=>array('data-dismiss'=>'modal'),
//));
    ?>
</div>

<?php $this->endWidget(); ?>

<script type="text/javascript">
    jQuery('#merchantNotice').modal({'show':true});
</script>