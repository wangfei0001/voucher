<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{

        $user = User::model()->find('username = :username',array('username'=>$this->username));

        if($user){
            if($user->password != $this->password){
                $this->errorCode=self::ERROR_PASSWORD_INVALID;
            }else{
                $this->errorCode=self::ERROR_NONE;


                //check if the merchant information is completed
                if($user->getIsMerchant()){
                    $completed = $this->checkMerchantInforCompleted($user->id_user);

                    $this->setState('merchantCompleted', $completed);

                }

                return true;
            }
        }else{
            $this->errorCode=self::ERROR_USERNAME_INVALID;
        }


        return false;

	}


    /***
     * @param $id_user
     */
    protected function checkMerchantInforCompleted($id_user)
    {
        $completed = false;

        $merchant = Merchant::model()->find('fk_user = :id_user', array('id_user'=>$id_user));

        if($merchant){
            if(!empty($merchant->company)
                && !empty($merchant->address1)
                && !empty($merchant->phone)

                ){
                $completed = true;
            }
        }
        return $completed;
    }
}