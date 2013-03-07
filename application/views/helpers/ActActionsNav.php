<?php

class Zend_View_Helper_actActionsNav {

    public $view;

    function setView($view) {

        $this->view = $view;
        $this->controller = Zend_Controller_Front::getInstance()->getRequest()->getControllerName();
        $this->action = Zend_Controller_Front::getInstance()->getRequest()->getActionName();
        $this->origin = Zend_Controller_Front::getInstance()->getRequest()->getParam('origin');
    }

    function actActionsNav() {

        $pre =
            '<nav id="activityActionsNav" class="span12 actionControls" role="navigation">'.PHP_EOL.
                '<ul class="nav nav-pills">'.PHP_EOL.
                '<li class="listTitle">Review:</li>'.PHP_EOL;

            $actions[] = ((strcasecmp($this->action, 'registrations') == 0) ? '<li class="active" ng-show="betaOne">' :
                    '<li ng-show="betaOne">') . '<a href="/activity/registrations">Registrations</a></li>';
            $actions[] = ((strcasecmp($this->action, 'appointments') == 0) ? '<li class="active" ng-show="betaTwo">' :
                    '<li ng-show="betaTwo">') . '<a href="/activity/appointments">Appointments</a></li>';
            $actions[] = ((strcasecmp($this->action, 'superbills') == 0) ? '<li ng-show="betaThree" class="active">' :
                    '<li ng-show="betaThree">') . '<a href="/activity/superbills">Superbills</a></li>';
            $actions[] = ((strcasecmp($this->action, 'claims') == 0) ? '<li ng-show="betaThree" class="active">' :
                    '<li ng-show="betaThree">') . '<a href="/activity/claims">Claims</a></li>';

        $post =
                '</ul>'.PHP_EOL.
            '</nav>';

        $string = $pre;
        foreach ($actions as $action)
            $string .= $action;

        $string .= $post;

        return $string;
    }
}