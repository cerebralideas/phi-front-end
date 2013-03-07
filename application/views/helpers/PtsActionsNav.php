<?php

class Zend_View_Helper_ptsActionsNav {

    public $view;

    function setView($view) {

        $this->view = $view;
        $this->controller = Zend_Controller_Front::getInstance()->getRequest()->getControllerName();
        $this->action = Zend_Controller_Front::getInstance()->getRequest()->getActionName();
        $this->origin = Zend_Controller_Front::getInstance()->getRequest()->getParam('origin');
    }

    function ptsActionsNav() {

        $pre =
            '<nav id="patientsActionsNav" class="span12 actionControls" role="navigation">'.PHP_EOL.
                '<ul class="nav nav-pills">'.PHP_EOL.
                    '<li class="listTitle">Actions:</li>'.PHP_EOL;

        if ($this->origin) {

            $actions[] = ((strcasecmp($this->origin, 'search') == 0) ? '<li class="active">' :
                    '<li>') . '<a href="/patients/search?origin=search">Patient Search</a></li>';
            $actions[] = ((strcasecmp($this->origin, 'register') == 0) ? '<li class="active">' :
                    '<li>') . '<a href="/patients/new?origin=register&stage=new">Register New</a></li>';

        } else {

            $actions[] = ((strcasecmp($this->action, 'search') == 0) ? '<li class="active">' :
                    '<li>') . '<a href="/patients/search?origin=search">Patient Search</a></li>';
            $actions[] = ((strcasecmp($this->origin, 'register') == 0) ? '<li class="active">' :
                    '<li>') . '<a href="/patients/new?origin=register&stage=new">Register New</a></li>';
        }

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