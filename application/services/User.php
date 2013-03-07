<?php
class Service_User
{
    public function __construct()
    {

        $auth = Zend_Auth::getInstance();
        $storage = $auth->getStorage();
        $this->userId = $storage->read()->id;
        $this->usersModel = new Model_Users();

    }

    public function get()
    {
        $where = $this->usersModel->getAdapter()->quoteInto('id = ?', $this->userId);
        return $this->usersModel->fetchRow($where);
    }

    public function getRole()
    {
        $user = $this->get();
        if ( $user['role'] )
        {
            return $user['role'];
        }
        else
        {
            return null;
        }
    }
    public function getFirstName()
    {
        $user = $this->get();
        if ( $user['firstname'] )
        {
            return $user['firstname'];
        }
        else
        {
            return null;
        }
    }

    public function getUserJson()
    {
        $role = $this->getRole();
        $firstName = $this->getFirstName();
        $item = array (
            'role' => $role,
            'firstName' => $firstName
        );
        return Zend_Json_Encoder::encode( $item );
    }
}