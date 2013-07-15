<script type="text/javascript">


    $(function(){
        var lat = $('#StoreForm_lat').val();
        var lng = $('#StoreForm_lng').val();

        initialize(lat,lng);
    });

    function initialize(lat,lng) {
        var mapOptions = {
            center: new google.maps.LatLng(lat,lng),
            zoom: 16,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        var map = new google.maps.Map(document.getElementById("map_canvas"),
                mapOptions);
    }
</script>

<?php /** @var BootActiveForm $form */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'horizontalForm',
    'type'=>'horizontal',
)); ?>

<fieldset>
    <!--legend>Legend</legend-->
    <?php echo $form->textFieldRow($model, 'company'/*, array('hint'=>'In addition to freeform text, any HTML5 text-based input appears like so.')*/); ?>
    <?php //echo $form->dropDownListRow($model, 'dropdown', array('Something ...', '1', '2', '3', '4', '5')); ?>
    <?php //echo $form->dropDownListRow($model, 'multiDropdown', array('1', '2', '3', '4', '5'), array('multiple'=>true)); ?>
    <?php echo $form->hiddenField($model, 'lat', array('type'=>'hidden', 'value'=>29.706)); ?>
    <?php echo $form->hiddenField($model, 'lng', array('type'=>'hidden', 'value'=>118.318)); ?>
    <?php echo $form->textFieldRow($model, 'address1', array('class'=>'span5')); ?>
    <?php //echo $form->textFieldRow($model, 'address2', array('class'=>'span5')); ?>
    <div id="map_canvas" style="width:100%; height:300px;"></div>
    <?php echo $form->textFieldRow($model, 'postcode', array('value'=>'245000')); ?>
    <?php echo $form->textFieldRow($model, 'phone'); ?>
    <?php echo $form->textFieldRow($model, 'fax'); ?>
    <?php echo $form->textFieldRow($model, 'website',array('placeholder'=>'http://')); ?>
    <?php echo $form->textFieldRow($model, 'fax'); ?>


    <?php echo $form->textAreaRow($model, 'term_condition', array('class'=>'span5', 'rows'=>5)); ?>



</fieldset>

<div class="form-actions">
    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=>'Submit')); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'reset', 'label'=>'Reset')); ?>
</div>

<?php $this->endWidget(); ?>