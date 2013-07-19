<script type="text/javascript">

    $(function(){
        var checkout = $('.datepicker').datepicker().on('changeDate', function(ev){
            checkout.datepicker('hide');
        });
    });


</script>

<?php /** @var BootActiveForm $form */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'verticalForm',
    'htmlOptions'=>array('class'=>'well'),
)); ?>

<?php echo $form->textFieldRow($model, 'name', array('class'=>'span3')); ?>
<?php echo $form->textFieldRow($model, 'start_time', array('class'=>'span3 datepicker','data-date-format'=>"yyyy-mm-dd",'readonly'=>'readonly')); ?>
<!--span class="add-on"><i class="icon-calendar"></i></span-->
<?php echo $form->textFieldRow($model, 'end_time', array('class'=>'span3 datepicker','data-date-format'=>"yyyy-mm-dd",'readonly'=>'readonly')); ?>
<?php echo $form->textAreaRow($model, 'term_condition', array('class'=>'span8','rows'=>6)); ?>
<?php echo $form->checkboxRow($model, 'reusable'); ?>
<?php

$this->widget('bootstrap.widgets.TbButton', array(
    'buttonType' => 'submit',
    'label'=>'登录',

    'size'=>'small', // null, 'large', 'small' or 'mini'
));


?>

<?php $this->endWidget(); ?>