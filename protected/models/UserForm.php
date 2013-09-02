<?php
/**
 * Created by JetBrains PhpStorm.
 * User: wangfei0001
 * Date: 13-8-4
 * Time: PM10:50
 * To change this template use File | Settings | File Templates.
 */
class UserForm extends CFormModel
{
    public $username;

    public $password;

    public $fname;

    public $lname;

    public $email;

    public $gender;

    public $status;


    public function attributeLabels()
    {
        return array(
            'username'=>'用户名',
            'password'   =>  '密码',
            'fname'=>'名',
            'lname'=>'姓',
            'email'=>'电子邮件',
            'gender'=>'性别',
            'status'=>'账户状态'
        );
    }


    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
		return array(
            array('email', 'required', 'message'=>'请输入{attribute}.'),
            array('fname, lname, gender, username, password', 'safe')
        );
    }

    /***
     * @param $id
     */
    public function load($id)
    {
        $user = User::model()->find('id_user = :id_user',array('id_user'=>$id));

        if($user){

            $this->username = $user->username;

            $this->email = $user->email;

            $this->gender = $user->gender;

            $this->fname = $user->fname;

            $this->lname = $user->lname;

            $this->status = $user->status;

            return true;
        }
        return false;
    }




    public function save()
    {
        $id = Yii::app()->user->id;

        if($id){
            $currentData = User::model()->find('id_user = :id_user',array('id_user'=>$id));

            $user = new User;

            $user->isNewRecord = false;

            $user->setAttributes($this->attributes);

            $user->password = $currentData->password;

            $user->fk_role = $currentData->fk_role;

            $user->username = $currentData->username;

            $user->id_user = $id;

            $result = $user->save();


            if(!$result){

            }

            return $result;
        }

        return false;
    }


    public function create()
    {
        $user = new User;

        $user->isNewRecord = true;

        $user->setAttributes($this->attributes);

        $user->fk_role = User::USER_ROLE_APP;



        $result = $user->save();

        if(!$result){

        }

        return $result ? $user : false;
    }
}
