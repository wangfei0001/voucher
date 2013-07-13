<?php
/**
 * Created by JetBrains PhpStorm.
 * User: wangfei0001
 * Date: 13-7-13
 * Time: AM8:39
 * To change this template use File | Settings | File Templates.
 */
class CreateForm extends CFormModel
{
    public $username;

    public $email;

    public $password;

    public $passwordConfirm;

    public $agree;


    public function rules()
    {
        return array(
            // username and password are required
            array('username, password, passwordConfirm, email', 'required'),
            // rememberMe needs to be a boolean
            array('email', 'email'),
            array('agree', 'compare', 'compareValue' => true)

            // password needs to be authenticated
            //array('password', 'authenticate'),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels()
    {
        return array(
            'username'=>'用户名',
            'email'=>'电子邮件',
            'password'=>'密码',
            'passwordConfirm'=>'确认密码',
            'agree'=>'已经阅读并且同意使用条款'
        );
    }

    /***
     * Create account
     */
    public function create()
    {
        $user = new User();

        $user->username = $this->username;
        $user->email = $this->email;
        $user->password = $this->password;

        if($user->save()){
            return true;
        }else{
            //$this->addError('password','Incorrect username or password.');
            return false;
        }
    }

}
