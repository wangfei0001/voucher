<?php
/**
 * Created by JetBrains PhpStorm.
 * User: wangfei0001
 * Date: 13-10-12
 * Time: PM11:03
 * To change this template use File | Settings | File Templates.
 */
class MailTemplate
{

    protected $email;

    protected $templateId;

    protected $data;

    protected $fields;


    protected function getTemplate()
    {

    }


    /***
     * Construct
     *
     * @param $data
     */
    public function __construct($data)
    {
        $this->data = $data;

        $this->templateId = get_class($this);
    }



    /***
     * Validate the data
     *
     * @return bool
     * @throws Exception
     */
    public function validate()
    {
        $result = false;

        if(isset($this->fields)){
            $result = true;

            foreach($this->fields as $parameter){
                if(!isset($this->data[$parameter])){
                    throw new Exception('Parameter ' .$parameter .' not set!');
                }
            }
        }

        return $result;
    }


    /***
     * Convert to params
     *
     * @return bool|string
     */
    public function toParams()
    {
        if(!empty($this->data)){
            $tmpArr = array();
            foreach($this->data as $key=>$val){
                $tmpArr[] = $key .'=' .urlencode($val);
            }
            $tmpArr[] = 'templateId=' .$this->templateId;
            return implode('&', $tmpArr);
        }
        return false;
    }

    /***
     * Get fields list
     *
     * @return mixed
     */
    public function getFields()
    {
        return $this->fields;
    }


    public function generateContent()
    {
        $dir = Yii::app()->basePath .'/templates/';
        $filePath = $dir .$this->templateId .'.html';
        if(file_exists($filePath)){
            $content = file_get_contents($filePath);

            if(preg_match_all('/#(.*?)#/', $content, $res)){
                foreach($res[1] as $name){
                    $content = preg_replace('/#' .$name .'#/', $this->data[$name], $content);
                }
                return $content;
            }

        }
        return false;
    }
}
