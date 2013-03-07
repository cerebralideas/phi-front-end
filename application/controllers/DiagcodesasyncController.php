<?php
class DiagcodesasyncController extends Zend_Controller_Action
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
        $this->diagCodesService = new Service_DiagCodes();
    }

    public function searchAction()
    {
        $q = $this->_request->getParam('q');
        $type = $this->_request->getParam('type', 'icd10');
        echo $this->diagCodesService->search($q, $type);
    }
}