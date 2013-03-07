<?php

class Zend_View_Helper_LoggedInUser
{
    public $view;

    function setView($view)
    {
        $this->view = $view;
    }

    function loggedInUser()
    {
        $auth = Zend_Auth::getInstance();

        if ($auth->hasIdentity())
        {
            $storage = $auth->getStorage();

            $string =
            '<nav id="userControls">'.PHP_EOL.
            '<ul class="unstyled inline-list">'.PHP_EOL.
            '<li><a href="#">Hello, '.$storage->read()->firstname.'<span class="icon-equalizer"></span></a></li><!--
            removes white-space'
                    .PHP_EOL.
            '--><li><a href="/auth/logout/">Logout</a></li>'.PHP_EOL.
            '</ul>'.PHP_EOL.
            '</nav>'.PHP_EOL;
        }
        else
        {
            $string = '';
        }

        return $string;
    }
}