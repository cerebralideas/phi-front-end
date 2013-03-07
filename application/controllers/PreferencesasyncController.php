<?php

class PreferencesasyncController extends Zend_Controller_Action
{
    private $auth;
    private $storage;
    private $userId;

    public function init()
    {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $this->auth = Zend_Auth::getInstance();
        $this->storage = $this->auth->getStorage();
        $this->userId = $this->storage->read()->id;
        $this->preferencesService = new Service_Preferences();
    }


    public function getmasterdataflagAction()
    {
        $flag = $this->preferencesService->getMasterDataFlag();

        if ( $flag )
            echo '1';
        else
            echo '0';
    }

    public function setmasterdataflagAction()
    {
        $flag = $this->_request->getParam('flag');
        $this->preferencesService->setMasterDataFlag( $flag );
    }
}