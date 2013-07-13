<?php /** @var BootActiveForm $form */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'verticalForm',
    'htmlOptions'=>array('class'=>'well'),
)); ?>

<?php echo $form->textFieldRow($model, 'username', array('class'=>'span3')); ?>
<?php echo $form->textFieldRow($model, 'email', array('class'=>'span3')); ?>
<?php echo $form->passwordFieldRow($model, 'password', array('class'=>'span3')); ?>
<?php echo $form->passwordFieldRow($model, 'passwordConfirm', array('class'=>'span3')); ?>
<?php echo $form->checkboxRow($model, 'agree'); ?>
<?php

$this->widget('bootstrap.widgets.TbButton', array(
    'buttonType' => 'submit',
    'label'=>'登录',

    'size'=>'small', // null, 'large', 'small' or 'mini'
));


?>

<?php $this->endWidget(); ?>