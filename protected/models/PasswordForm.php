<?php
/**
 * Created by JetBrains PhpStorm.
 * User: wangfei0001
 * Date: 13-10-11
 * Time: PM10:06
 * To change this template use File | Settings | File Templates.
 */
class PasswordForm extends CFormModel
{
    public $oldpassword;

    public $password;

    public $repassword;


    /**
     * Declares customized attribute labels.
     * If not declared here, an attribute would have a label that is
     * the same as its name with the first letter in upper case.
     */
    public function attributeLabels()
    {
        return array(
            'oldpassword'  =>  '当前密码',
            'password'=>'新密码',
            'repassword'=>'确认新密码',
        );
    }

    /**
     * Declares the validation rules.
     */
    public function rules()
    {
        return array(
            array('oldpassword, password, repassword', 'required'),
            array('oldpassword','validatePassword'),
            array('password', 'length','min'=>6, 'max'=>32),
            array('repassword', 'compare', 'compareAttribute'=>'password'/*,'on' => 'create,api,changepassword'*/),

        );
    }

    public function validatePassword($attribute,$params)
    {
        $user = User::model()->find('id_user = ' .Yii::app()->user->id);
        if($user){
            if($this->$attribute != $user->password ){
                CModel::addError($attribute, '您输入的原始密码错误');
            }
        }else{
            throw new Exception('Invalid user');
        }
    }

    public function save()
    {
        $user = User::model()->find('id_user = ' .Yii::app()->user->id);

        $user->password = $this->password;

        return $user->save();
    }
}
