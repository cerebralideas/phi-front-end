<?
class Service_Activation
{
    protected $storage;
    protected $config;
    protected $db;
    protected $userId;

    public function __construct()
    {
        $auth = Zend_Auth::getInstance();
        $this->storage = $auth->getStorage();

        $this->config = Zend_Registry::get('configuration');
        $this->db = Zend_Db::factory($this->config->database);
        Zend_Db_Table_Abstract::setDefaultAdapter($this->db);

        $this->userId = $this->storage->read()->id;

    }

    public function activate()
    {
        $usersModel = new Model_Users();
        $where = $usersModel->getAdapter()->quoteInto('id = ?', $this->userId);

        $user = $usersModel->fetchRow( $where );

        if ( $user )
        {
            // Check to see if user has any receipts to apply
            $receiptsModel = new Model_Receipts();
            $where = $receiptsModel->getAdapter()->quoteInto('x_response_code = 1 AND activation_date IS NULL AND x_cust_id = ?', $this->userId);
            $receipts = $receiptsModel->fetchAll($where, array('receipt_date'));

            $cLicenseExpiration = null;  // This stores the latest license expiration date for the following loop
            foreach ($receipts as $receipt)
            {
                $productsModel = new Model_Products();
                $where = $productsModel->getAdapter()->quoteInto('id = ?', $receipt['product_id']);
                $product = $productsModel->fetchRow($where);

                if ($product)
                {
                    // Determine if existing subscription is expired
                    if ($cLicenseExpiration == null)
                        $existingLicenseExpiration = date("m/d/Y", strtotime($user['license_expiration']));
                    else
                        $existingLicenseExpiration = $cLicenseExpiration;

                    //echo 'Existing License Expiration: ' . $existingLicenseExpiration . '<br />';

                    $today = date("m/d/Y");
                    //echo 'Today: ' . $today . '<br />';

                    // If expired, we'll be starting from today
                    if ( strtotime($existingLicenseExpiration) < strtotime($today) )
                        $existingLicenseExpiration = $today;

                    //echo 'New Existing License Expiration: ' . $existingLicenseExpiration . '<br />';

                    $nbr = $product['nbr'];
                    $interval = $product['interval'];



                    $future = date("Y-m-d", strtotime($existingLicenseExpiration . " + " . $nbr . " " . $interval));

                    //echo 'Future: ' . $future . '<br />';

                    if ( strcasecmp( $interval, "months") == 0)
                    {
                        $month = date("m", strtotime($future));
                        $year =  date("Y", strtotime($future));
                        $lastDayOfMonth = $this->getLastDayOfMonth(date("m", strtotime($future)), date("Y", strtotime($future)));
                        $license_expiration = date("Y-m-d", mktime(0, 0, 0, $month, $lastDayOfMonth, $year));
                    }
                    else
                    {
                        // Add one day, so user gets full use of subscription
                        $future = date("Y-m-d", strtotime($future . " + 1 day"));
                        $license_expiration = date("Y-m-d", strtotime( $future ));
                    }

                    // Before updating the receipt transaction, get current license expiration from user record
                    // in database as it may have changed while in this loop.  i.e. multiple receipts to apply
                    $usersModelCurrent = new Model_Users();
                    $whereCurrent = $usersModelCurrent->getAdapter()->quoteInto('id = ?', $this->userId);
                    $userCurrent = $usersModelCurrent->fetchRow( $whereCurrent );

                    if ( $userCurrent['license_expiration'] == null || strcasecmp($userCurrent['license_expiration'], "") == 0 )
                        $dbLicenseExpiration = null;
                    else
                        $dbLicenseExpiration = date("Y-m-d", strtotime($userCurrent['license_expiration']));

                    // Update receipt as activated
                    $receiptData = array(
                        'activation_date' => date("Y-m-d"),
                        'existing_license_expiration' => $dbLicenseExpiration,
                        'new_license_expiration' => $license_expiration
                    );

                    $whereReceiptId = $receiptsModel->getAdapter()->quoteInto('id = ?', $receipt['id']);

                    $receiptsModel->update($receiptData, $whereReceiptId);


                    //echo 'License Expiration to Save: ' . $license_expiration . '<br />';

                    // Update user account license expiration
                    $data = array();
                    $data['license_expiration']	= $license_expiration;
                    $cLicenseExpiration = $license_expiration;


                    $where = $usersModel->getAdapter()->quoteInto('id = ?', $this->userId);
                    $usersModel->update($data, $where);

                }
            }
        }
    }

    private function getLastDayOfMonth($month, $year)
    {
        return idate('d', mktime(0, 0, 0, ($month + 1), 0, $year));
    }
}