<script type="text/javascript" src="/themes/bootstrap/js/ajaxfileupload.js"></script>
<script type="text/javascript">

    $(function(){
        var checkout = $('.datepicker').datepicker().on('changeDate', function(ev){
            checkout.datepicker('hide');
        });
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
                    if(typeof(data.error) != 'undefined'){
                        if(data.error != ''){
                            alert(data.error);
                        }else{
                            alert(data.msg);
                        }
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

<?php echo $form->textFieldRow($model, 'name', array('class'=>'span3')); ?>


    <?php echo $form->labelEx($model,'image'); ?>
    <?php //if($model->image !== null) echo CHtml::image(Yii::app()->request->baseUrl . '/protected/logos/' . $model->image); ?>
    <br>
    <?php echo $form->fileField($model, 'image'); ?>
<?php

$this->widget('bootstrap.widgets.TbButton', array(
    'buttonType' => 'button',
    'label'=>'上传',
    'size'=>'small', // null, 'large', 'small' or 'mini'
    'htmlOptions'=> array(
    'onclick' => 'return ajaxFileUpload();',
    'id' => 'buttonUpload'
        )
));
?>
    <?php echo $form->error($model,'image'); ?>



<?php echo $form->textFieldRow($model, 'start_time', array('class'=>'span3 datepicker','data-date-format'=>"yyyy-mm-dd",'readonly'=>'readonly')); ?>
<!--span class="add-on"><i class="icon-calendar"></i></span-->
<?php echo $form->textFieldRow($model, 'end_time', array('class'=>'span3 datepicker','data-date-format'=>"yyyy-mm-dd",'readonly'=>'readonly')); ?>
<?php echo $form->textAreaRow($model, 'term_condition', array('class'=>'span8 nosizable','rows'=>6)); ?>
<?php echo $form->checkboxRow($model, 'reusable'); ?>
<div class="span2">
<?php

$this->widget('bootstrap.widgets.TbButton', array(
    'buttonType' => 'submit',
    'label'=>'发布',
    'type'=>'primary',
    'size'=>'small', // null, 'large', 'small' or 'mini'
));
?>
</div>
<?php

$this->widget('bootstrap.widgets.TbButton', array(
    'buttonType' => 'button',
    'label'=>'预览',
    'size'=>'small', // null, 'large', 'small' or 'mini'
));
?>

<?php $this->endWidget(); ?>