<?php
/**
 * Created by JetBrains PhpStorm.
 * User: wangfei0001
 * Date: 13-7-12
 * Time: PM9:22
 * To change this template use File | Settings | File Templates.
 */
class CategoryController extends ApiController
{

    /***
     *
     */
    public function Index()
    {

        $cats = Category::getAll();

        $this->_sendResponse(
            array(
                'status'    =>      true,
                'data'      =>      $cats
            )
        );
    }
}
