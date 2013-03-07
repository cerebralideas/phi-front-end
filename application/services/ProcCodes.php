<?php
class Service_ProcCodes
{
    public function __construct()
    {

        $auth = Zend_Auth::getInstance();
        $storage = $auth->getStorage();
        $this->userId = $storage->read()->id;
        $this->procCodesModel = new Model_ProcCodes();

    }

    public function getProcCodes()
    {
        $query = $this->procCodesModel->select()
            ->order(array('name'))
            ->limit( 10 )
            ->query();

        $data = array();

        $rows = $query->fetchAll();

        foreach ( $rows as $row )
        {
            $item = array();
            $item['num'] = $row['num'];
            $item['name'] = $row['name'];
            $item['description'] = $row['description'];
            $item['charge'] = number_format($row['charge'], 2);
            $data[] = $item;

        }

        return $data;
    }

    public function search($q)
    {

        if ( strcasecmp($q, '') != 0 )
        {
            $query =
                'select
                    num,
                    name,
                    description,
                    format(charge, 2) as charge
                from procCodes
                where
                    name like \'%' . addslashes($q) .  '%\' or
                    description like \'%' . addslashes($q) .  '%\' limit 50';

            $stmt = $this->procCodesModel->getAdapter()->query( $query );
            $rows = $stmt->fetchAll();
            return Zend_Json_Encoder::encode($rows);
        }
        else
            return null;


    }

    public function getProcCodesJson()
    {
        echo Zend_Json::encode( $this->getProcCodes() );
    }
}