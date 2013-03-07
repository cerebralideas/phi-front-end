<?php
class Service_Seq
{
    private $seqModel;

    public function __construct()
    {
        $this->seqModel = new Model_Seq();
    }

    public function getValue( $service )
    {
        $where = $this->seqModel->getAdapter()->quoteInto('service = ?', $service);
        $row = $this->seqModel->fetchRow( $where );

        if ( $row )
        {
            $value = $row['value'];
            $newValue = $value + 1;

            $data = array();
            $data['value'] = $newValue;

            $this->seqModel->update( $data, $where );
        }
        else
        {
            $value = null;
        }

        return $value;

    }
}