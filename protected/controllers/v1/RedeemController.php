<?php
/**
 * Created by JetBrains PhpStorm.
 * User: wangfei0001
 * Date: 13-10-19
 * Time: PM12:34
 * To change this template use File | Settings | File Templates.
 */
class RedeemController extends ApiController
{


    /***
     * Redeem a voucher
     */
    public function Create()
    {
        $id_voucher = $this->getParam('id_voucher');

        $id_user = $this->getParam('id_user');

        $result = array(
            'status' => false,
            'data' => null,
            'message' => null
        );


        if($id_user && $id_voucher){
            $voucher = Voucher::model()->find('id_voucher = ' .$id_voucher);

            if($voucher){
                $old = Redemption::model()->find('fk_user = ' .$id_user .' and fk_voucher = ' .$id_voucher);

                //if you already use the voucher, can not use again
                if($old){
                    $result['message'] = '您已经使用过该优惠券，无法重复使用';
                }else{
                    if($voucher->redeem($id_user)){     //redeem the voucher successfully
                        $result['status'] = true;
                    }
                }

            }
        }
        $this->_sendResponse($result);
    }
}
