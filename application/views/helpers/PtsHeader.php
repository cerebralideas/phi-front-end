<?php

class Zend_View_Helper_ptsHeader {

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

    function ptsHeader() {

        $header =
            '<h1 class="mainPanelHeader">'.PHP_EOL;

                if (strcasecmp($this->action, 'search') == 0) {

                    $header .=
                        'Results for: {{q1}} {{q2}} {{q3}} '.PHP_EOL;

                } elseif (strcasecmp($this->action, 'new') == 0) {

                    $header .=
                        '&nbsp;'.PHP_EOL;

                } else {

                    $header .=
                        '<span>{{pt.firstName}} {{pt.lastName}} {{pt.suffix}}</span>'
                                .PHP_EOL.
                        '<span>{{pt.sex}} / {{pt.age}}</span>'.PHP_EOL.
                        '<span>DOB: {{pt.dateOfBirth}}</span>'.PHP_EOL;
                }

        $header .= '</h1>'.PHP_EOL;

            if (strcasecmp($this->action, 'search') == 0) {

                $tabsOpen = '<nav class="tabControls mainPanel" id="patientNav">'.PHP_EOL;
                $tabsClose = '</nav>'.PHP_EOL;

            } elseif (strcasecmp($this->origin, 'register') == 0 && strcasecmp($this->stage, 'new') == 0) {

                $tabsOpen = '<nav class="tabControls mainPanel" id="patientNav">'.PHP_EOL;
                $tabsClose = '</nav>'.PHP_EOL;

            } else {

                $tabsOpen =
                    '<nav class="tabControls mainPanel" id="patientNav">'.PHP_EOL.
                        '<ul class="nav nav-tabs">'.PHP_EOL;

                    if (strcasecmp($this->searchTerms, '') == 0) {

                        // Leave blank
                    } else {

                        $actions[] = '<li class="reverse">'.PHP_EOL.
                            '<a href="/patients/search?origin=search&searchTerms={{searchTerms}}">'.PHP_EOL.
                            '<span class="icon-search"></span> Back'.PHP_EOL.
                            '</a></li>'.PHP_EOL;
                    }

                    $actions[] = ((strcasecmp($this->action, 'patient') == 0) ?
                        '<li class="active" ng-show="betaOne">' :
                        '<li ng-show="betaOne">') . '<a href="/patients/patient?'.
                        'patientId='.$this->patientId.
                        '&data=patient-info'.
                        '&origin='.$this->origin.
                        '&searchTerms={{searchTerms}}'.
                        '">Patient</a></li>';

                    $actions[] = ((strcasecmp($this->action, 'appointments') == 0) ?
                        '<li class="active" ng-show="betaTwo">' :
                        '<li ng-show="betaTwo">') . '<a href="/patients/appointments?'.
                        'patientId='.$this->patientId.
                        '&data=appointment-list'.
                        '&origin='.$this->origin.
                        '&searchTerms={{searchTerms}}'.
                        '">Appointments</a></li>';

                    $actions[] = ((strcasecmp($this->action, 'op-superbills') == 0) ?
                        '<li class="active" ng-show="betaThree">' :
                        '<li ng-show="betaThree">') . '<a href="/patients/op-superbills?'.
                        'patientId='.$this->patientId.
                        '&data=op-superbills-list'.
                        '&origin='.$this->origin.
                        '&searchTerms={{searchTerms}}'.
                        '">Out-Pt Superbills</a></li>';

                    $actions[] = ((strcasecmp($this->action, 'op-claims') == 0) ?
                            '<li class="active" ng-show="betaFour">' :
                            '<li ng-show="betaFour">') . '<a href="/patients/op-claims?'.
                            'patientId='.$this->patientId.
                            '&data=op-claims-list'.
                            '&origin='.$this->origin.
                            '&searchTerms={{searchTerms}}'.
                            '">Out-Pt Claims</a></li>';

                    $actions[] = ((strcasecmp($this->action, 'account') == 0) ?
                            '<li class="active" ng-show="betaFive">' :
                            '<li ng-show="betaFive">') . '<a href="/patients/account?'.
                            'patientId='.$this->patientId.
                            '&data=account'.
                            '&origin='.$this->origin.
                            '&searchTerms={{searchTerms}}'.
                            '">Pt Ledger</a></li>';

                $tabsClose = '</ul>'.PHP_EOL.
                    '</nav>'.PHP_EOL;
            }

        $container =
            '<div class="content"><!-- This is closed in the file that imported it -->'.PHP_EOL;

        $string = $header;

        $string .= $tabsOpen;

        if ( $actions )
        foreach ($actions as $action)
            $string .= $action;

        $string .= $tabsClose;

        $string .= $container;

        return $string;
    }
}