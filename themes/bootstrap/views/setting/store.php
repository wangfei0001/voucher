<script type="text/javascript">
    var geocoder = new google.maps.Geocoder();

    function geocodePosition(pos) {
         geocoder.geocode({
                 latLng: pos
         }, function(responses) {
             if (responses && responses.length > 0) {
                     updateMarkerAddress(responses[0].formatted_address);
                 } else {
                     updateMarkerAddress('Cannot determine address at this location.');
                 }
         });
    }
    function updateMarkerAddress(str) {
        $('#MerchantForm_address1').val(str);
    }
    function updateMarkerStatus(str) {
     }

    function updateMarkerPosition(latLng) {
//         document.getElementById('info').innerHTML = [
//                 latLng.lat(),
//                 latLng.lng()
//             ].join(', ');
        $('#MerchantForm_lat').val(latLng.lat());
        $('#MerchantForm_lng').val(latLng.lng());

    }

    $(function(){
        var lat = $('#MerchantForm_lat').val();
        var lng = $('#MerchantForm_lng').val();

        initialize(lat,lng);
    });

    function initialize(lat,lng) {
        var myLatlng = new google.maps.LatLng(lat,lng);
        var mapOptions = {
            center: myLatlng,
            zoom: 16,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        var map = new google.maps.Map(document.getElementById("map_canvas"),
                mapOptions);
        var marker = new google.maps.Marker({
            position: myLatlng,
            map: map,
            title: 'Hello World!',
            draggable: true
        });
        // Update current position info.
        updateMarkerPosition(myLatlng);
        geocodePosition(myLatlng);

        // Add dragging event listeners.
        google.maps.event.addListener(marker, 'dragstart', function() {
             //updateMarkerAddress('Dragging...');
         });

        google.maps.event.addListener(marker, 'drag', function() {
             //updateMarkerStatus('Dragging...');
            updateMarkerPosition(marker.getPosition());
        });

        google.maps.event.addListener(marker, 'dragend', function() {
           //updateMarkerStatus('Drag ended');
           geocodePosition(marker.getPosition());
        });
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
    <?php echo $form->hiddenField($model, 'lat', array('value'=>empty($model->lat)?29.706:$model->lat)); ?>
    <?php echo $form->hiddenField($model, 'lng', array('value'=>empty($model->lng)?118.318:$model->lng)); ?>
    <?php echo $form->textFieldRow($model, 'address1', array('class'=>'span5')); ?>
    <?php //echo $form->textFieldRow($model, 'address2', array('class'=>'span5')); ?>
    <div id="map_canvas">


    </div>
    <?php echo $form->textFieldRow($model, 'postcode', array('value'=>'245000')); ?>
    <?php echo $form->textFieldRow($model, 'phone'); ?>
    <?php echo $form->textFieldRow($model, 'fax'); ?>
    <?php echo $form->textFieldRow($model, 'website',array('placeholder'=>'http://')); ?>


    <?php echo $form->textAreaRow($model, 'term_condition', array('class'=>'span5', 'rows'=>5)); ?>



</fieldset>

<div class="form-actions">
    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=>'保存')); ?>
</div>

<?php $this->endWidget(); ?>