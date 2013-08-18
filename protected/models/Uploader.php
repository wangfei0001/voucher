<?php
/**
 * Created by JetBrains PhpStorm.
 * User: wangfei0001
 * Date: 13-8-18
 * Time: AM9:20
 * To change this template use File | Settings | File Templates.
 */
class Uploader extends CUploadedFile
{
    protected $maximumSize;

    protected $types;

//    public $image;
//
//
//    public function rules()
//    {
//        return array(
//            array('image', 'file', 'allowEmpty' => true,'maxSize' => 102400, 'types' => 'jpg, jpeg, png, gif'),
//            );
//    }


    public function __construct()
    {
        $this->maximumSize = 1024 * 500;        //maxmum size = 500K

        $this->types = array('jpg','png','gif');
    }


    /***
     * Set maximum file size
     *
     * @param $size
     */
    public function setMaximumSize($size)
    {
        if(is_numeric($size)){
            $this->maximumSize = $size;

            return true;
        }
        return false;
    }


    /***
     * Set support file Types
     *
     * @param $types
     * @return bool
     */
    public function setSupportTypes($types)
    {
        if(is_string($types)){
            $types = explode(',', $types);
        }
        if(is_array($types)){
            $this->types = $types;

            return true;
        }
        return false;
    }


    protected function isTypeSupport($ext)
    {

    }


//    public function validate()
//    {
//
//
//        return false;
//    }

}
