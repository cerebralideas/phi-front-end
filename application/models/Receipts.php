<?
class Model_Receipts extends Othernet_Model_System_MySQLiAbstract
{
    protected $_name = 'receipts';
    protected $_schema = AUTH_MYSQL_DATABASE;
    protected $_db;


    public function init()
    {
        //load the authdb adapter
        $this->_db = Zend_Registry::getInstance('authdbAdapter')->authdbAdapter;
    }

    /* This applyReceipt function is no longer valid */
    public function applyReceipt($receiptId)
    {
        $select = $this->_db->select()
            ->from($this->_name, array('x_cust_id', 'x_description'))
            ->where('id=?', $receiptId);
        $result = $this->getAdapter()->fetchRow($select);

        if ($result)
        {

            $userId = $result['x_cust_id'];
            $description = $result['x_description'];
            $pieces = explode("|", $description);
            $sku = trim($pieces[0]);

            $productsModel = new Products();
            $where = $productsModel->getAdapter()->quoteInto('sku = ?', $sku);
            $product = $productsModel->fetchRow($where);

            if ($product)
            {
                // Standard Neehr Perfect Subscription
                if ( $product['product_category_id'] == 1 )
                {

                    $nbrMonths = $product['nbr_months'];

                    $future = date("Y-m-d", strtotime("+" . $nbrMonths . " months"));
                    $month = date("m", strtotime($future));
                    $year =  date("Y", strtotime($future));
                    $lastDayOfMonth = $this->getLastDayOfMonth(date("m", strtotime($future)), date("Y", strtotime($future)));
                    $license_expiration = date("Y-m-d", mktime(0, 0, 0, $month, $lastDayOfMonth, $year));
                    $data = array();
                    $data['license_expiration']	= $license_expiration;
                    $usersModel = new Users();
                    $where = $usersModel->getAdapter()->quoteInto('id = ?', $userId);
                    $usersModel->update($data, $where);
                }
                // Pepid Add-On Subscription
                elseif ( $product['product_category_id'] == 2 )
                {
                    $usersModel = new Users();
                    $where = $usersModel->getAdapter()->quoteInto('id = ?', $userId);
                    $user = $usersModel->fetchRow( $where );
                    $license_expiration = $user['license_expiration'];
                    $data = array();
                    $data['pepid_expiration'] = $license_expiration;
                    $usersModel->update($data, $where);

                }
                // Neehr Perfect Subscription w/ Pepid
                elseif ( $product['product_category_id'] == 3 )
                {
                    $nbrMonths = $product['nbr_months'];

                    $future = date("Y-m-d", strtotime("+" . $nbrMonths . " months"));
                    $month = date("m", strtotime($future));
                    $year =  date("Y", strtotime($future));
                    $lastDayOfMonth = $this->getLastDayOfMonth(date("m", strtotime($future)), date("Y", strtotime($future)));
                    $license_expiration = date("Y-m-d", mktime(0, 0, 0, $month, $lastDayOfMonth, $year));
                    $data = array();
                    $data['license_expiration']	= $license_expiration;
                    $data['pepid_expiration'] = $license_expiration;
                    $usersModel = new Users();
                    $where = $usersModel->getAdapter()->quoteInto('id = ?', $userId);
                    $usersModel->update($data, $where);
                }
            }


        }


    }

    /* Future functionality -- not in use */
    public function reverseReceipt($receiptId)
    {


    }

    private function getLastDayOfMonth($month, $year)
    {
        return idate('d', mktime(0, 0, 0, ($month + 1), 0, $year));
    }
}