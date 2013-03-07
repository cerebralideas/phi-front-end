<?php
class AptasyncController extends Zend_Controller_Action
{
    private $_auth;
    private $_storage;
    private $schema;
    private $aptService;


    public function init()
    {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $this->_auth = Zend_Auth::getInstance();
        $this->_storage = $this->_auth->getStorage();

        $this->aptService = new Service_Apt();
        $this->schema = $this->aptService->getSchema();


    }

    public function getaptsAction()
    {
        $uniqueId = $this->_request->getParam('patientId', '0');
        echo $this->aptService->getAptListForPtJson( $uniqueId );
    }

    public function getaptAction()
    {
        $uniqueId = $this->_request->getParam('aptId', '0');
        echo $this->aptService->getJson( $uniqueId );
    }

    public function getaptsbydateAction()
    {
        $startDate = $this->_request->getParam('startDate', null);
        $endDate = $this->_request->getParam('endDate', null);
        echo $this->aptService->getAptListForDateJson( $startDate, $endDate );

    }

    public function getavailabilitybydateAction()
    {
        //echo urlencode('General Medical Clinic') . '<br />';
        //echo urlencode('10/11/2012') . '<br />';
        $location = $this->_request->getParam('location', null);
        $date = $this->_request->getParam('date', null);
        echo $this->aptService->getAvailabilityForDateJson( $location, $date );

    }

    public function getallaptsAction()
    {
        echo $this->aptService->getAllAptListJson();
    }

    public function saveaptAction()
    {
        $value = Zend_Json_Decoder::decode(file_get_contents('php://input'));
        echo $this->aptService->updateJson( $value );

        //Zend_Debug::dump( $value );
    }

    public function submitaptAction()
    {
        $value = Zend_Json_Decoder::decode(file_get_contents('php://input'));
        $this->aptService->updateJson( $value );
    }

    public function newaptAction()
    {
        $value = Zend_Json_Decoder::decode(file_get_contents('php://input'));
        $this->aptService->insertJson( $value );
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
        $this->aptService->import();
    }

}