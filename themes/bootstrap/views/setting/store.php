<?php /** @var BootActiveForm $form */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'horizontalForm',
    'type'=>'horizontal',
)); ?>

<fieldset>

    <legend>Legend</legend>

    <?php echo $form->textFieldRow($model, 'company', array('hint'=>'In addition to freeform text, any HTML5 text-based input appears like so.')); ?>
    <?php //echo $form->dropDownListRow($model, 'dropdown', array('Something ...', '1', '2', '3', '4', '5')); ?>
    <?php //echo $form->dropDownListRow($model, 'multiDropdown', array('1', '2', '3', '4', '5'), array('multiple'=>true)); ?>
    <?php echo $form->textFieldRow($model, 'address1'); ?>
    <?php echo $form->textFieldRow($model, 'address2'); ?>
    <?php echo $form->textFieldRow($model, 'postcode'); ?>
    <?php echo $form->textFieldRow($model, 'phone'); ?>
    <?php echo $form->textFieldRow($model, 'fax'); ?>
    <?php echo $form->textFieldRow($model, 'website'); ?>
    <?php echo $form->textFieldRow($model, 'fax'); ?>


    <?php echo $form->textAreaRow($model, 'term_condition', array('class'=>'span8', 'rows'=>5)); ?>



</fieldset>

<div class="form-actions">
    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=>'Submit')); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'reset', 'label'=>'Reset')); ?>
</div>

<?php $this->endWidget(); ?>