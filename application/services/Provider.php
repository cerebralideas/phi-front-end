<?php
class Service_Provider
{
    public function __construct()
    {

        $auth = Zend_Auth::getInstance();
        $storage = $auth->getStorage();
        $this->userId = $storage->read()->id;
        $this->organizationId = $storage->read()->organization_id;
        $this->providerModel = new Model_Provider();
    }

    public function getProviders()
    {

        $query = $this->providerModel->select()
            ->where('organization_id = ?', $this->organizationId)
            ->where('role <> ?', 'org_student')
            ->where('active = ?', '1')
            ->where('id <> ?', $this->userId)
            ->order(array('lastname', 'firstname'))
            ->query();

        $data = array();

        $rows = $query->fetchAll();

        foreach ( $rows as $row )
        {
            $item = array();
            $item['name'] = $row['firstname'] . ' ' . $row['lastname'];
            $item['id'] = $row['id'];
            $data[] = $item;

        }

        return $data;
    }

    public function getProvidersJson()
    {
        echo Zend_Json::encode( $this->getProviders() );
    }


}