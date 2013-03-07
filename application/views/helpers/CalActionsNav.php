<?php

class Zend_View_Helper_calActionsNav
{
    public $view;


    function setView($view)
    {
        $this->view = $view;
        $this->controller = Zend_Controller_Front::getInstance()->getRequest()->getControllerName();
        $this->action = Zend_Controller_Front::getInstance()->getRequest()->getActionName();
        $this->urlNewAdm = $this->view->urlNewAdm;
        $this->urlNewApt = $this->view->urlNewApt;
    }

    function calActionsNav()
    {
        // class="active"

        $pre =
            '<nav id="calendarActionsNav" class="span12 actionControls" role="navigation">'.PHP_EOL.
                '    <ul class="nav nav-pills">'.PHP_EOL.
                '        <li class="listTitle">Calendar View:</li>'.PHP_EOL;

        $actions[] = ((strcasecmp($this->action, 'day') == 0) ? '<li class="active">' : '<li>') . '<a href="/calendar/day?startDate={{startDate}}&endDate={{endDate}}">Day</a></li>';

        $post =
            '    </ul>'.PHP_EOL.
                '</nav>';

        $string = $pre;
        foreach ($actions as $action)
            $string .= $action;

        $string .= $post;

        return $string;
    }
}