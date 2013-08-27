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
    public function actionList()
    {
        $last_id_voucher = $this->getParam('id_voucher');

        $last_timestamp = $this->getParam('time');

        $vouchers = Voucher::getAll(array(
            'id' => $last_id_voucher,
            'time' => $last_timestamp
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
    public function actionView()
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
