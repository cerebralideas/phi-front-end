<?php

class Zend_View_Helper_calHeader {

    public $view;

    function setView($view) {

        $this->view = $view;
        $this->controller = Zend_Controller_Front::getInstance()->getRequest()->getControllerName();
        $this->action = Zend_Controller_Front::getInstance()->getRequest()->getActionName();
        $this->origin = Zend_Controller_Front::getInstance()->getRequest()->getParam('origin');
        $this->data = Zend_Controller_Front::getInstance()->getRequest()->getParam('data');
        $this->stage = Zend_Controller_Front::getInstance()->getRequest()->getParam('stage');
        $this->searchTerms = Zend_Controller_Front::getInstance()->getRequest()->getParam('searchTerms');
        $this->patientId = Zend_Controller_Front::getInstance()->getRequest()->getParam('patientId');
    }

    function calHeader() {

        $header =
            '<h1 class="mainPanelHeader center">'.PHP_EOL;

        $header .=
                '<a class="icon" href="/calendar/" ng-hide="currentStartDate == currentEndDate">&#x27f2;</a>
                 <a class="icon" ng-show="currentStartDate == currentEndDate" ng-click=\'oneDown("day")\'>&#x2b05;</a>
                    {{currentStartDate}} <span ng-hide="currentStartDate == currentEndDate">- {{currentEndDate}}</span>
                 <a class="icon" ng-show="currentStartDate == currentEndDate" ng-click=\'oneUp("day")\'>&#x27a1;</a>'.PHP_EOL;

        $header .=
            '</h1>'.PHP_EOL;

        $tabsOpen = '<nav class="tabControls mainPanel" id="patientNav">'.PHP_EOL;
        $tabsClose = '</nav>'.PHP_EOL;


        $container =
            '<div class="content"><!-- This is closed in the file that imported it -->'.PHP_EOL;

        $string = $header;

        $string .= $tabsOpen;

        $string .= $tabsClose;

        $string .= $container;

        return $string;
    }
}