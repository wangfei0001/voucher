<?php
/**
 * Created by JetBrains PhpStorm.
 * User: wangfei0001
 * Date: 13-9-6
 * Time: PM9:51
 * To change this template use File | Settings | File Templates.
 */
class VersionController extends ApiController
{

    public function Index()
    {
        $curVer = $this->getParam('curver');

        $version = new Version();

        $this->_sendResponse(array(
            'status'    =>      true,
            'data'  => $version->getLatestVersion()
        ));
    }
}
