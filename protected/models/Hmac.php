<?php
/**
 * Created by JetBrains PhpStorm.
 * User: wangfei0001
 * Date: 13-9-2
 * Time: PM11:44
 * To change this template use File | Settings | File Templates.
 */
class Hmac
{
    /***
     * 存储所有将要使用api signature的controller，actions设置
     *
     * @var array
     */
    protected $protectedActions = array(
        'login'     =>  array('delete'),
        'voucher'   =>  array()
    );
}
