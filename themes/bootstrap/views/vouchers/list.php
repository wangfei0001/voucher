<?php
/**
 * Created by JetBrains PhpStorm.
 * User: wangfei0001
 * Date: 13-7-14
 * Time: PM9:22
 * To change this template use File | Settings | File Templates.
 */

$gridDataProvider = new CArrayDataProvider($vouchers);


$this->widget('bootstrap.widgets.TbGridView', array(
    'type'=>'Striped',
    'dataProvider'=>$gridDataProvider,
    'template'=>"{items}",
    'columns'=>array(
        array('name'=>'id', 'header'=>'#'),
        array('name'=>'name', 'header'=>'折扣优惠标题', 'type'=>'raw'),
        array('name'=>'start_time', 'header'=>'开始时间'),
        array('name'=>'end_time', 'header'=>'结束时间'),
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

?>
<div class="pagination">
<?php
    $this->widget('CLinkPager',
        array(
            'pages' => $pages,
            'header' => '',
            'firstPageLabel'    =>  '第一页',
            'nextPageLabel' => '下页',
            'prevPageLabel' => '上页',
            'lastPageLabel' =>  '最后一页',
            'selectedPageCssClass' => 'active',
            'hiddenPageCssClass' => 'disabled',
            'htmlOptions' => array(
                'class' => '',
            )
        )
    );
?>

</div>
