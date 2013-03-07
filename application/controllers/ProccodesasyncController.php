<?php
class ProccodesasyncController extends Zend_Controller_Action
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
        $this->procCodesService = new Service_ProcCodes();
    }

    public function searchAction()
    {
        $q = $this->_request->getParam('q');
        echo $this->procCodesService->search($q);
    }
}