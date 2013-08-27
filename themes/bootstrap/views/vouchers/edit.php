<script type="text/javascript" src="/themes/bootstrap/js/ajaxfileupload.js"></script>
<script type="text/javascript">

    $(function(){
        var nowTemp = new Date();
        var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);

        var checkout = $('.datepicker').datepicker({
            onRender: function(date) {
                return date.valueOf() < now.valueOf() ? 'disabled' : '';
            }
        }).on('changeDate', function(ev){
            checkout.datepicker('hide');
        });

        $('#reusable').click(function(){
            $('#reuse_frame').toggle();

            var checked = $(this).attr('checked');

        });

        $("#reuse_total").keydown(onlyNumber);

    });


    function ajaxFileUpload()
    {
        /*		$("#loading")
                .ajaxStart(function(){
                    $(this).show();
                })
                .ajaxComplete(function(){
                    $(this).hide();
                });*/

        $.ajaxFileUpload({
                url:'<?php echo $this->createUrl('vouchers/upload',array('id' => $model->id_voucher)); ?>',
                secureuri:false,
                fileElementId:'CreateVoucherForm_image',
                dataType: 'json',
                beforeSend:function(){
                    $("#loading").show();
                },
                complete:function(){
                    $("#loading").hide();
                },
                success: function (data, status){
//                    if(typeof(data.error) != 'undefined'){
//                        if(data.error != ''){
//                            alert(data.error);
//                        }else{
//                            alert(data.msg);
//                        }
//                    }
                    if(data.result){
                        $('#img_wrap').html('<img src="/' + data.data.path + '">');
                    }
                },
                error: function (data, status, e){
                    alert(e);
                }
            }
        )

        return false;

    }


</script>

<?php /** @var BootActiveForm $form */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'verticalForm',
    'htmlOptions'=>array('class'=>'well'),
)); ?>

<?php echo $form->textFieldRow($model, 'name', array('class'=>'span3','readonly'=>$canModify?'':'readonly')); ?>

<div id="img_wrap">
<?php
    if($model->image){
?>
    <img src="/uploads/<?php echo $model->id_voucher?>.jpg">
<?php
    }
?>
</div>
<?php
    if($canModify){
?>
    <?php echo $form->labelEx($model,'image'); ?>
    <?php //if($model->image !== null) echo CHtml::image(Yii::app()->request->baseUrl . '/protected/logos/' . $model->image); ?>
    <br>
    <?php echo $form->fileField($model, 'image'); ?>
<?php

if(Yii::app()->controller->action->id != 'create'){
$this->widget('bootstrap.widgets.TbButton', array(
    'buttonType' => 'button',
    'label'=>'上传',
    'size'=>'small', // null, 'large', 'small' or 'mini'
    'htmlOptions'=> array(
    'onclick' => 'return ajaxFileUpload();',
    'id' => 'buttonUpload'
        )
));
}
?>
    <?php echo $form->error($model,'image'); ?>
<?php
    }
        ?>


<?php echo $form->textFieldRow($model, 'start_time', array(
    'class'=>'span3 ' .($canModify?'datepicker':''),
    'data-date-format'=>"yyyy-mm-dd",
    'readonly'=>'readonly'));
?>
<!--span class="add-on"><i class="icon-calendar"></i></span-->
<?php echo $form->textFieldRow($model, 'end_time', array('class'=>'span3 datepicker','data-date-format'=>"yyyy-mm-dd",'readonly'=>'readonly')); ?>
<?php echo $form->textAreaRow($model, 'term_condition', array('class'=>'span8 nosizable','rows'=>6, 'readonly'=>$canModify?'':'readonly')); ?>

<?php echo $form->checkboxRow($model, 'reusable', array('id'=>'reusable','onclick'=>($canModify?'return true':'return false'))); ?>

<div id="reuse_frame"<?php if($model->reusable){?> style="display: none;"<?php }?>>
<?php echo $form->textFieldRow($model, 'reuse_total', array('id'=>'reuse_total', 'maxlength'=>5,'class'=>'span1')); ?>
</div>

<div>
<?php

    $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'label'=>'发布',
        'type'=>'primary',
        'size'=>'small', // null, 'large', 'small' or 'mini'
    ));

    $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'button',
        'label'=>'复制',
        'size'=>'small', // null, 'large', 'small' or 'mini'
    ));

    $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'button',
        'label'=>'预览',
        'size'=>'small', // null, 'large', 'small' or 'mini'
    ));
?>
</div>
<?php $this->endWidget(); ?>