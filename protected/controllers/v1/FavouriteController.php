<?php
/**
 * Created by JetBrains PhpStorm.
 * User: wangfei0001
 * Date: 13-9-6
 * Time: PM7:24
 * To change this template use File | Settings | File Templates.
 */
class FavouriteController extends ApiController
{

    /***
     * Addf favourite
     */
    public function Create()
    {

        $result = false;
        $data = null;

        $id = $this->getParam('id');

        $type = $this->getParam('type');

        if($type == 'voucher'){
            $favourite = Favourite::model()->find('fk_user = :fk_user and fk_voucher = :fk_voucher', array('fk_user' => $this->id_user, 'fk_voucher' => $id));

            if(!$favourite){
                $favourite = new Favourite();
            }

            $favourite->fk_user = $this->id_user;

            $favourite->fk_voucher = $id;

            $favourite->status = Favourite::STATUS_ACTIVE;

            if($favourite->save()){
                $result = true;
                $data = $favourite->id_favourite;
            }
        }
        $this->_sendResponse(array(
            'data'      => $data,
            'status'    => $result
        ));
    }



    /***
     * Delete favourite vouchers
     */
    public function Delete()
    {
        $result = false;

        $id = $this->getParam('id');

        $favourite = Favourite::model()->find('fk_user = :fk_user and id_favourite = :id_favourite', array('fk_user' => $this->id_user, 'id_favourite' => $id));
        if($favourite){
            $result = $favourite->delete();
        }

        $this->_sendResponse(array(
            'data'      => null,
            'status'    => $result
        ));
    }
}
