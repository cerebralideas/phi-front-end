<?php
class Service_DiagCodes
{
    public function __construct()
    {

        $auth = Zend_Auth::getInstance();
        $storage = $auth->getStorage();
        $this->userId = $storage->read()->id;
        $this->diagCodesModel = new Model_DiagCodes();

    }

    public function getDiagCodes()
    {
        $query = $this->diagCodesModel->select()
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
            $data[] = $item;

        }

        return $data;
    }

    public function search($q, $type)
    {

        if ( (strcasecmp($q, '') != 0) && (strcasecmp($type, '') != 0) )
        {
            $query =
                'select
                    num,
                    name,
                    description
                from diagCodes
                where
                    icdType = \'' . addslashes($type) . '\' and
                    (name like \'%' . addslashes($q) .  '%\' or
                    description like \'%' . addslashes($q) .  '%\') limit 50';

            $stmt = $this->diagCodesModel->getAdapter()->query( $query );
            $rows = $stmt->fetchAll();
            return Zend_Json_Encoder::encode($rows);
        }
        else
            return null;


    }

    public function getDiagCodesJson()
    {
        echo Zend_Json::encode( $this->getDiagCodes() );
    }
}