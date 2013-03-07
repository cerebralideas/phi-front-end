<?php

class Zend_View_Helper_actHeader {

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

    function actHeader() {

        $header =
            '<h1 class="mainPanelHeader">'.PHP_EOL;

            $header .=
                '<span ng-show="subFaculty">{{ptFullName}} <b class="normalWeight">by</b>
                        {{subStudent}} <b class="normalWeight">on</b> {{subDate}}</span>'.PHP_EOL.
                '<span ng-hide="subFaculty">&nbsp;</span>'.PHP_EOL;

        $header .=
            '</h1>'.PHP_EOL;

        $tabsOpen =
            '<nav class="tabControls mainPanel" id="patientNav">'.PHP_EOL.
                    '<ul ng-show="subFaculty" class="nav nav-tabs">'.PHP_EOL;

        $actions =
                        '<li class="active">'.PHP_EOL.
                            '<a id="itemTab" href="#subItem" data-toggle="tab">Submitted Item</a>'.PHP_EOL.
                        '</li>'.PHP_EOL.
                        '<li>'.PHP_EOL.
                            '<a id="statComTab" href="#statusComments" data-toggle="tab">Status & Comments</a>'.PHP_EOL.
                        '</li>'.PHP_EOL;

        $tabsClose = '</ul>'.PHP_EOL.
                '</nav>'.PHP_EOL;

        $container =
            '<div class="content"><!-- This is closed in the file that imported it -->'.PHP_EOL;

        $string = $header;

        $string .= $tabsOpen;

        $string .= $actions;

        $string .= $tabsClose;

        $string .= $container;

        return $string;
    }
}