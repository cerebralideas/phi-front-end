<?php
class AdmasyncController extends Zend_Controller_Action
{
    private $_auth;
    private $_storage;
    private $schema;
    private $admService;


    public function init()
    {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $this->_auth = Zend_Auth::getInstance();
        $this->_storage = $this->_auth->getStorage();

        $this->admService = new Service_Adm();
        $this->schema = $this->admService->getSchema();


    }

    public function getadmsAction()
    {
        $uniqueId = $this->_request->getParam('patientId', '0');
        echo $this->admService->getAdmListForPtJson( $uniqueId );
    }

    public function getadmAction()
    {
        $uniqueId = $this->_request->getParam('admId', '0');
        echo $this->admService->getJson( $uniqueId );
    }

    public function getadmsbydateAction()
    {
        $startDate = $this->_request->getParam('startDate', null);
        $endDate = $this->_request->getParam('endDate', null);
        echo $this->admService->getAdmListForDateJson( $startDate, $endDate );

    }

    public function getalladmsAction()
    {
        echo $this->admService->getAllAdmListJson();
    }

    public function saveadmAction()
    {
        $value = Zend_Json_Decoder::decode(file_get_contents('php://input'));
        echo $this->admService->updateJson( $value );

        //Zend_Debug::dump( $value );
    }

    public function submitadmAction()
    {
        $value = Zend_Json_Decoder::decode(file_get_contents('php://input'));
        $this->admService->updateJson( $value );
    }

    public function newadmAction()
    {
        $value = Zend_Json_Decoder::decode(file_get_contents('php://input'));
        $this->admService->insertJson( $value );
    }

    public function testAction()
    {
        echo '<pre>';
        Zend_Debug::dump( $this->schema);
        $mappingService = new Service_Mapping();
        echo $mappingService->dbSchema( $this->schema, '');
        echo '</pre>';
    }

    // Imports all manually created JSON files into the database
    public function importAction()
    {
        $this->admService->import();
    }

}