<?php
class OpclasyncController extends Zend_Controller_Action
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
        $this->opClService = new Service_OpCl();
    }

    public function saveopclAction()
    {
        $value = Zend_Json_Decoder::decode(file_get_contents('php://input'));
        echo $this->opClService->updateJson( $value );
    }

    public function getopsbAction()
    {
        $uniqueId = $this->_request->getParam('sbId', '0');
        echo $this->opClService->getJson( $uniqueId );
    }

    public function getsbswithnoopclAction()
    {
        $uniqueId = $this->_request->getParam('patientId', '0');
        echo $this->opClService->getSbsWithNoOpCl( $uniqueId );
    }

    public function getopclbyptAction()
    {
        $uniqueId = $this->_request->getParam('patientId', '0');
        echo $this->opClService->getByPtId($uniqueId);
    }

    public function getopclAction()
    {
        $uniquieId = $this->_request->getParam('opClId', '0');
        echo $this->opClService->getJson($uniquieId);
    }

}