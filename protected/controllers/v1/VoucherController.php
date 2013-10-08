<?php
/**
 * Created by JetBrains PhpStorm.
 * User: wangfei0001
 * Date: 13-8-21
 * Time: PM10:01
 * To change this template use File | Settings | File Templates.
 */
class VoucherController extends ApiController
{

    /***
     * curl -i http://voucher/api/v1/voucher
     *
     */
    public function Index()
    {
        $last_id_voucher = $this->getParam('id_voucher');

        $id_category = $this->getParam('id_category');

        $last_timestamp = $this->getParam('time');



        $search = $this->getParam('search');

        $vouchers = Voucher::getAll(array(
            'id' => $last_id_voucher,
            'time' => $last_timestamp,
            'id_category' => $id_category,
            'search' => $search
        ));

        $this->_sendResponse(
            array(
                'status'    =>      true,
                'data'      =>      $vouchers
            )
        );

    }



    /***
     * get the voucher
     */
    public function View()
    {

        $id = $this->getParam('id');

        $data = Voucher::model()->find('id_voucher = :id_voucher', array('id_voucher' => $id));

        $this->_sendResponse(
            array(
                'status'    =>      true,
                'data'      =>      $data
            )
        );
    }

//    public function actionCreate()
//    {
//
//    }
//
//    public function actionUpdate()
//    {
//
//    }
//
//    public function actionDelete()
//    {
//
//    }
}
