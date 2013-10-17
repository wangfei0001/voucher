<?php
/**
 * Created by JetBrains PhpStorm.
 * User: wangfei0001
 * Date: 13-10-17
 * Time: PM10:09
 * To change this template use File | Settings | File Templates.
 */
class ContactController extends ApiController
{



    /***
     * Post contact information
     */
    public function Create()
    {
        $response = array(
            'data'      =>  null,
            'status'    =>  false
        );

        $content = $this->getParam('content');

        $contact_info = $this->getParam('contact_info');

        if($content && $contact_info){
            $model = new Contact();

            $model->content = $content;

            $model->contact_info = $contact_info;

            $result = $model->save();

            if($result){
                $response['status'] = true;
            }

        }

        $this->_sendResponse($response);
    }
}
