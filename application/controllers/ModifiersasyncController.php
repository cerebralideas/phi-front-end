<?php
class ModifiersasyncController extends Zend_Controller_Action
{
    private $auth;
    private $storage;
    private $userId;

    public function init()
    {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $this->auth = Zend_Auth::getInstance();
        $this->storage = $this->auth->getStorage();
        $this->userId = $this->storage->read()->id;
    }

    public function getAction()
    {
        $modifierModel = new Model_Modifier();
        $modifiers = $modifierModel->fetchAll('1 = 1', array('code'))->toArray();
        echo Zend_Json_Encoder::encode($modifiers);
    }
}