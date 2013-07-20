<?php $this->widget('bootstrap.widgets.TbTabs', array(
    'type'=>'tabs',
    'placement'=>'above', // 'above', 'right', 'below' or 'left'
    'tabs'=>array(
        array('label'=>'个人资料', 'content'=>'<p>I\'m in Section 1.</p>', 'active'=>true),
        array('label'=>'通知设置', 'content'=>'<p>Howdy, I\'m in Section 2.</p>'),
    ),
)); ?>