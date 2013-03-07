<?php
/**
 * Created by JetBrains PhpStorm.
 * User: sneese
 * Date: 3/16/12
 * Time: 9:40 AM
 * To change this template use File | Settings | File Templates.
 */

class Zend_View_Helper_GetCreator
{
    public $view;

    function setView($view)
    {
        $this->view = $view;
    }

    function getCreator($userId)
    {
        $usersModel = new Model_Users();
        $user = $usersModel->getByUserId($userId);
        return $user['firstname'].' '.$user['lastname'];
    }
}