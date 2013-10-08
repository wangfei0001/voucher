<script type="text/javascript">
    var geocoder = new google.maps.Geocoder();

    var addresses = <?php echo json_encode($addresses); ?>;

    var defaultLat = 29.709450;
    var defaultLng = 118.313270;

    var markers = new Array();

    var marker;     //marker for current selected address

    var map;

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
        setVal('address1', str);
    }


    function updateMarkerPosition(latLng) {
        setVal('lat',latLng.lat());
        setVal('lng',latLng.lng());
    }


    /***
     * Reset Address Form and hide it
     */
    function resetAddressForm()
    {
        var ids = new Array('id_address', 'address1', 'postcode', 'phone', 'fax', 'lat', 'lng');
        for(var i = 0; i < ids.length; i++){
            setVal(ids[i], '');
        }
        //
        if(marker){
            marker.setDraggable(false);
            marker.setIcon('/images/marker.png');
            marker = null;
        }
        $('#address_form').fadeOut();
    }


    function setVal(name, val)
    {
        var ids = new Array('id_address', 'address1', 'postcode', 'phone', 'fax', 'lat', 'lng');
        if(ids.indexOf(name) >= 0){
            $('#AddressForm_' + name).val(val);
        }
    }


    $(function(){

        initialize(defaultLat, defaultLng);
        var options = {
            success:       function(responseText, statusText, xhr, $form){
                //alert('status: ' + statusText + '\n\nresponseText: \n' + responseText +
                //        '\n\nThe output div should have already been updated with the responseText.');
                if(responseText.status){
                    //set data
                    for(var i = 0; i < addresses.length; i++){
                        if(parseInt(responseText.data.id) == addresses[i].id){
                            addresses[i] = responseText.data;
                            break;
                        }
                    }
                    marker.setDraggable(false);
                    marker.setIcon('/images/marker.png');
                    $('#address_form').fadeOut();
                }
            },
            dataType:  'json',
            clearForm: true,
            timeout:   3000
        };

        $('#AddressForm').ajaxForm(options);

        $('#but_add_address').click(function(){
            var storeLatLng = new google.maps.LatLng(defaultLat,
                    defaultLng);
            marker = new google.maps.Marker({
                position: storeLatLng,
                map: map,
                title: '',
                draggable: true,
                icon: '/images/marker_enable.png'
            });
            markers.push(marker);

            geocodePosition(storeLatLng);
            updateMarkerPosition(storeLatLng);

            $('#address_form').fadeIn();
        });

    });



    $(document).on('click','#addresses_list a.update',function(){
        var id_address = $(this).parents('tr').children('td').first().html();

        for(var i = 0; i < addresses.length; i++){
            if(parseInt(id_address) == addresses[i].id){
                setVal('id_address', addresses[i].id);
                setVal('address1', addresses[i].address1);
                setVal('postcode', addresses[i].postcode);
                setVal('phone', addresses[i].phone);
                setVal('fax', addresses[i].fax);
                setVal('lat', addresses[i].lat);
                setVal('lng', addresses[i].lng);
                //get the marker and set it draggable
                for(var j = 0; j < markers.length; j++){
                    marker = markers[j];
                    if(marker.get('id') != id_address){
                        marker.setDraggable(false);
                    }else{
                        marker.setDraggable(true);
                        marker.setIcon('/images/marker_enable.png');
                    }
                }
                break;
            }
        }
        $('#address_form').fadeIn();
    });


    function initialize(lat,lng) {
        var myLatlng = new google.maps.LatLng(lat,lng);
        var mapOptions = {
            center: myLatlng,
            zoom: 16,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        map = new google.maps.Map(document.getElementById("map_canvas"),
                mapOptions);

        for(var i = 0; i < addresses.length; i++){
            var storeLatLng = new google.maps.LatLng(addresses[i].lat, addresses[i].lng);

            var storeMarker = new google.maps.Marker({
                position: storeLatLng,
                map: map,
                title: addresses[i].address1,
                draggable: false,
                icon: '/images/marker.png'
            });
            storeMarker.set('id', addresses[i].id);

            markers.push(storeMarker);

            // Add dragging event listeners.
            google.maps.event.addListener(storeMarker, 'dragstart', function() {
            });

            google.maps.event.addListener(storeMarker, 'drag', function() {
                updateMarkerPosition(marker.getPosition());
            });

            google.maps.event.addListener(storeMarker, 'dragend', function() {
                geocodePosition(marker.getPosition());
            });

        }


    }
</script>
<script type="text/javascript" src="/themes/bootstrap/js/jquery.form.js"></script>

<script type="text/javascript">
    var test = function(e) {
        //load ajax stuff here
        $('#content0, #content1').toggle();
    }
</script>
<?php $this->widget('bootstrap.widgets.TbTabs', array(
    'type'=>'tabs',
    'placement'=>'above', // 'above', 'right', 'below' or 'left'
    'tabs'=>array(
        array('label'=>'商家信息', 'content'=>'', 'active'=>true),
        array('label'=>'地址/分店设置', 'content'=>''),
    ),
    'events'=>array('shown'=>'js:test')
)); ?>
<div id="map_canvas">


</div>
    <div id="content0">

<?php /** @var BootActiveForm $form */
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'horizontalForm',
    'type'=>'horizontal',
)); ?>

<fieldset>
    <!--legend>Legend</legend-->
    <?php echo $form->textFieldRow($model, 'company'/*, array('hint'=>'In addition to freeform text, any HTML5 text-based input appears like so.')*/); ?>
    <?php echo $form->dropDownListRow($model, 'fk_category', $categories); ?>
    <?php //echo $form->dropDownListRow($model, 'dropdown', array('Something ...', '1', '2', '3', '4', '5')); ?>
    <?php //echo $form->dropDownListRow($model, 'multiDropdown', array('1', '2', '3', '4', '5'), array('multiple'=>true)); ?>
    <?php //echo $form->hiddenField($model, 'lat', array('value'=>empty($model->lat)?29.706:$model->lat)); ?>
    <?php //echo $form->hiddenField($model, 'lng', array('value'=>empty($model->lng)?118.318:$model->lng)); ?>
    <?php //echo $form->textFieldRow($model, 'address1', array('class'=>'span5')); ?>
    <?php //echo $form->textFieldRow($model, 'address2', array('class'=>'span5')); ?>

    <?php //echo $form->textFieldRow($model, 'postcode', array('value'=>'245000')); ?>
    <?php //echo $form->textFieldRow($model, 'phone'); ?>
    <?php //echo $form->textFieldRow($model, 'fax'); ?>
    <?php echo $form->textFieldRow($model, 'website',array('placeholder'=>'http://')); ?>


    <?php echo $form->textAreaRow($model, 'term_condition', array('class'=>'span5', 'rows'=>5)); ?>



</fieldset>

<div class="form-actions">
    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=>'保存')); ?>
</div>

<?php $this->endWidget(); ?>

        </div>
        <div id="content1" style="display: none;">

<?php
            $gridDataProvider = new CArrayDataProvider($addresses);

            $this->widget('bootstrap.widgets.TbGridView', array(
            'id' =>'addresses_list',
            'type'=>'Striped',
            'dataProvider'=>$gridDataProvider,
            'template'=>"{items}",
            'columns'=>array(
            array('name'=>'id', 'header'=>'#'),
            array('name'=>'address1', 'header'=>'地址/分店', 'type'=>'raw'),
            array('name'=>'phone', 'header'=>'电话'),
            array('name'=>'fax', 'header'=>'传真'),
            array('name'=>'postcode', 'header'=>'邮编'),
                array(
                'class'=>'bootstrap.widgets.TbButtonColumn',
                'template' => '{update}{delete}',
                'htmlOptions'=>array('style'=>'width: 50px'),
                'viewButtonUrl'=>null,
                'updateButtonUrl'=>null,
                'deleteButtonUrl'=>null,
                ),
            ),
            ));

            $this->widget('bootstrap.widgets.TbButton', array(
                'label'=>'添加地址/分店',
                'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                'size'=>'normal', // null, 'large', 'small' or 'mini'
                'htmlOptions'=>array('id'=>'but_add_address'),
            ));
?>
            <div id="address_form" style="display: none;">
                <?php
                $addform = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                    'id'=>'AddressForm',
                    'htmlOptions'=>array('class'=>'well'),
                    'action' => Yii::app()->controller->createUrl("saveAddress"),
                    'method' => 'post'
                ));
                ?>
                <fieldset>
                    <!--legend>Legend</legend-->
                    <?php echo $addform->textFieldRow($addrModel, 'address1', array('class'=>'span8')/*, array('hint'=>'In addition to freeform text, any HTML5 text-based input appears like so.')*/); ?>
                    <?php echo $addform->textFieldRow($addrModel, 'postcode', array('class'=>'span3')); ?>
                    <?php echo $addform->textFieldRow($addrModel, 'phone', array('class'=>'span4')); ?>
                    <?php echo $addform->textFieldRow($addrModel, 'fax'); ?>
                    <?php echo $addform->hiddenField($addrModel, 'lat'); ?>
                    <?php echo $addform->hiddenField($addrModel, 'lng'); ?>
                    <?php echo $addform->hiddenField($addrModel, 'id_address'); ?>
                </fieldset>

                <div class="form-actions">
                    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=>'保存地址')); ?>
                    <?php $this->widget('bootstrap.widgets.TbButton', array(
                    'buttonType' => 'button',
                    'label'=>'取消',
                    'size'=>'small',
                    'htmlOptions'=>array('onclick'=>'javascript:resetAddressForm();'),
                    ));?>
                </div>
                <?php $this->endWidget(); ?>
            </div>
        </div>
