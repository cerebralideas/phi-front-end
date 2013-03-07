<?php
class RegasyncController extends Zend_Controller_Action
{
    private $_auth;
    private $_storage;
    private $schema;
    private $ptService;


    public function init()
    {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $this->_auth = Zend_Auth::getInstance();
        $this->_storage = $this->_auth->getStorage();

        $this->ptService = new Service_Pt();
        $this->schema = $this->ptService->getSchema();


    }

    public function getnameAction()
    {
        $patientId = $this->_getParam('patientId', '0');
        echo $this->ptService->getNameComponentsJson( $patientId );
    }

    public function saveregAction()
    {
        $value = Zend_Json_Decoder::decode(file_get_contents('php://input'));
        echo $this->ptService->updateJson( $value );
    }

    public function submitregAction()
    {
        $value = Zend_Json_Decoder::decode(file_get_contents('php://input'));
        $this->ptService->updateJson( $value );
    }

    // Imports all manually created JSON files into the database
    public function importAction()
    {
        $this->ptService->import();
    }

    public function resetAction()
    {
        $this->ptService->reset();
    }

    public function testAction()
    {
        $this->ptService->getPtListJson();
    }

}
