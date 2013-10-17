<?php
/**
 * Created by JetBrains PhpStorm.
 * User: wangfei0001
 * Date: 13-10-13
 * Time: AM9:22
 * To change this template use File | Settings | File Templates.
 */
class ResetPassword extends MailTemplate
{
    protected $fields = array(
        'name',
        'link',
        'time',
        'email'
    );
}
