<?php
class OpsbasyncController extends Zend_Controller_Action
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
        $this->opSbService = new Service_OpSb();
    }

    public function saveopsbAction()
    {
        $value = Zend_Json_Decoder::decode(file_get_contents('php://input'));
        echo $this->opSbService->updateJson( $value );
    }

    public function getopsbAction()
    {
        $uniqueId = $this->_request->getParam('opSbId', '0');
        echo $this->opSbService->getJson( $uniqueId );
    }

    public function getopsbbyaptAction()
    {
        $uniqueId = $this->_request->getParam('aptId', '0');
        echo $this->opSbService->getByAptId( $uniqueId );

    }
    public function getopsbbyptAction()
    {
        $uniqueId = $this->_request->getParam('patientId', '0');
        echo $this->opSbService->getByPtId( $uniqueId );

    }

    public function getaptswithnoopsbAction()
    {
        $uniqueId = $this->_request->getParam('patientId', '0');
        echo $this->opSbService->getAptsWithNoOpSb( $uniqueId );
    }
}