<?php
class Service_Pt
{
    private $service = 'pt';
    private $ptModel;
    private $ptWorkingModel;
    private $schema;
    private $masterData;
    private $userId;

    public function __construct()
    {

        $auth = Zend_Auth::getInstance();
        $storage = $auth->getStorage();
        $this->userId = $storage->read()->id;

        $this->ptModel = new Model_Pt();
        $this->ptWorkingModel = new Model_PtWorking();

        // define schema for JSON
        $this->schema = array(
            "pt" => array(
                "uniqueId" => null,
                "medRecNum" => null,
                "firstName" => null,
                "lastName" => null,
                "middleName" => null,
                "suffix" => null,
                "dateOfBirth" => null,
                "socialSecurity" => null,
                "age" => null,
                "sex" => null,
                "aliases" => null,
                "maritalStatus" => null,
                "nationality" => null,
                "streetAddress" => null,
                "apptNum" => null,
                "city" => null,
                "state" => null,
                "zip" => null,
                "homePhone" => null,
                "workPhone" => null,
                "cellPhone" => null,
                "email" => null,
                "occupation" => null,
                "employer" => null,
                "employerPhone" => null,
                "comment" => null,
                "employmentStatus" => null,
                "eContact" => array(
                    "uniqueId" => null,
                    "firstName" => null,
                    "lastName" => null,
                    "suffix" => null,
                    "phoneNumber" => null,
                    "address" => null
                )
            ),
            "pg" => array(
                "p1" => array(
                    "uniqueId" => null,
                    "firstName" => null,
                    "lastName" => null,
                    "suffix" => null,
                    "relationship" => null,
                    "streetAddress" => null,
                    "apptNum" => null,
                    "city" => null,
                    "state" => null,
                    "zip" => null,
                    "homePhone" => null
                ),
                "p2" => array(
                    "uniqueId" => null,
                    "firstName" => null,
                    "lastName" => null,
                    "suffix" => null,
                    "relationship" => null,
                    "streetAddress" => null,
                    "apptNum" => null,
                    "city" => null,
                    "state" => null,
                    "zip" => null,
                    "homePhone" => null
                )
            ),
            "md" => array(
                "primary" => null,
                "referring" => null,
                "rendering" => null,
                "serviceLocation" => null,
                "providerSocSec" => null,
                "notes" => null
            ),
            "gr" => array(
                "relationship" => null,
                "uniqueId" => null,
                "firstName" => null,
                "lastName" => null,
                "suffix" => null,
                "streetAddress" => null,
                "apptNum" => null,
                "city" => null,
                "state" => null,
                "zip" => null
            ),
            "ins" => array(
                "primary" => array(
                    "comp" => null,
                    "relationship" => null,
                    "planName" => null,
                    "groupNumber" => null,
                    "policyNumber" => null,
                    "planName" => null,
                    "planNumber" => null,
                    "planType" => null,
                    "groupNumber" => null,
                    "groupName" => null,
                    "memberId" => null,
                    "planDetails" => null,
                    "effectiveDate" => null,
                    "effYearDeviation" => null,
                    "expirationDate" => null,
                    "expYearDeviation" => null,
                    "active" => null,
                    "verified" => null,
                    "notSelf" => array(
                        "uniqueId" => null,
                        "firstName" => null,
                        "lastName" => null,
                        "suffix" => null,
                        "sex" => null,
                        "dateOfBirth" => null,
                        "socialSecNumb" => null,
                        "homePhone" => null,
                        "streetAddress" => null,
                        "apptNum" => null,
                        "city" => null,
                        "state" => null,
                        "zip" => null,
                        "employer" => null,
                        "employerPhone" => null
                    ),
                    "typeOfCoverage" => null
                ),
                "secondary" => array(
                    "comp" => null,
                    "relationship" => null,
                    "planName" => null,
                    "groupNumber" => null,
                    "policyNumber" => null,
                    "planName" => null,
                    "planNumber" => null,
                    "planType" => null,
                    "groupNumber" => null,
                    "groupName" => null,
                    "memberId" => null,
                    "planDetails" => null,
                    "effectiveDate" => null,
                    "effYearDeviation" => null,
                    "expirationDate" => null,
                    "expYearDeviation" => null,
                    "active" => null,
                    "verified" => null,
                    "notSelf" => array(
                        "uniqueId" => null,
                        "firstName" => null,
                        "lastName" => null,
                        "suffix" => null,
                        "sex" => null,
                        "dateOfBirth" => null,
                        "socialSecNumb" => null,
                        "homePhone" => null,
                        "streetAddress" => null,
                        "apptNum" => null,
                        "city" => null,
                        "state" => null,
                        "zip" => null,
                        "employer" => null,
                        "employerPhone" => null
                    ),
                    "typeOfCoverage" => null
                ),
                "tertiary" => array(
                    "comp" => null,
                    "relationship" => null,
                    "planName" => null,
                    "groupNumber" => null,
                    "policyNumber" => null,
                    "planName" => null,
                    "planNumber" => null,
                    "planType" => null,
                    "groupNumber" => null,
                    "groupName" => null,
                    "memberId" => null,
                    "planDetails" => null,
                    "effectiveDate" => null,
                    "effYearDeviation" => null,
                    "expirationDate" => null,
                    "expYearDeviation" => null,
                    "active" => null,
                    "verified" => null,
                    "notSelf" => array(
                        "uniqueId" => null,
                        "firstName" => null,
                        "lastName" => null,
                        "suffix" => null,
                        "sex" => null,
                        "dateOfBirth" => null,
                        "socialSecNumb" => null,
                        "homePhone" => null,
                        "streetAddress" => null,
                        "apptNum" => null,
                        "city" => null,
                        "state" => null,
                        "zip" => null,
                        "employer" => null,
                        "employerPhone" => null
                    ),
                    "typeOfCoverage" => null
                )
            )
        );

        $preferencesService = new Service_Preferences();
        $this->masterData = $preferencesService->getMasterDataFlag();
    }

    public function getSchema()
    {
        return $this->schema;
    }

    public function getPtListJson()
    {
        $list = array();

        /* Determine if user is in 'Instructor' mode */
        if ( $this->masterData )
        {
            /* User is in 'Instructor' mode */
            $items = $this->ptModel->fetchAll('1 = 1', array('ptLastName', 'ptLastName', 'ptSuffix'));
        }
        else
        {
            /* User is in 'Student' mode */
            $query = '
                SELECT `ptUniqueId`, `ptFirstName`, `ptLastName`, `ptSuffix`, `ptDateOfBirth`, `ptSocialSecurity`
                FROM pt
                WHERE
                `ptUniqueId` NOT IN
                (
                    SELECT `ptUniqueId` FROM pt_working WHERE `createdBy` = ' . $this->ptModel->getAdapter()->quote($this->userId) . '
                )

                UNION

                SELECT `ptUniqueId`, `ptFirstName`, `ptLastName`, `ptSuffix`, `ptDateOfBirth`, `ptSocialSecurity`
                FROM pt_working WHERE `createdBy` = ' . $this->ptModel->getAdapter()->quote($this->userId) . '

                ORDER BY `ptLastName`, `ptLastName`, `ptSuffix`';

            $stmt = $this->ptModel->getAdapter()->query( $query );
            $items = $stmt->fetchAll();
        }

        foreach ( $items as $item )
        {
            $listItem = array();
            $listItem['uniqueId'] = $item['ptUniqueId'];
            $listItem['firstName'] = $item['ptFirstName'];
            $listItem['lastName'] = $item['ptLastName'];
            $listItem['suffix'] = $item['ptSuffix'];
            $listItem['dateOfBirth'] = $item['ptDateOfBirth'];
            $listItem['socialSecurity'] = $item['ptSocialSecurity'];

            $list[] = $listItem;
        }

        return Zend_Json_Encoder::encode( $list );
    }

    public function getNameComponentsJson( $uniqueId )
    {

        /* Determine if user is in 'Instructor' mode */
        if ( $this->masterData )
        {
            /* User is in 'Instructor' mode */

            $query = '
                SELECT
                    `ptFirstname` AS `firstName`,
                    `ptLastName` AS `lastName`,
                    `ptMiddleName` AS `middleName`,
                    `ptSuffix` AS `suffix`
                FROM pt
                WHERE ptUniqueId = ' . $this->ptModel->getAdapter()->quote($uniqueId);

        }
        else
        {
            /* User is in 'Student' mode */
            $query = '
                SELECT
                    `ptFirstname` AS `firstName`,
                    `ptLastName` AS `lastName`,
                    `ptMiddleName` AS `middleName`,
                    `ptSuffix` AS `suffix`
                FROM `pt`
                WHERE `ptUniqueId` NOT IN
                    (
                      SELECT `ptUniqueId` FROM pt_working WHERE `createdBy` = ' . $this->ptModel->getAdapter()->quote($this->userId) . '
                    ) AND `ptUniqueId` = ' . $this->ptModel->getAdapter()->quote($uniqueId) . '
                UNION
                SELECT
                    `ptFirstname` AS `firstName`,
                    `ptLastName` AS `lastName`,
                    `ptMiddleName` AS `middleName`,
                    `ptSuffix` AS `suffix`
                FROM `pt_working`
                WHERE `ptUniqueId` = ' . $this->ptModel->getAdapter()->quote($uniqueId);
        }

        $stmt = $this->ptModel->getAdapter()->query( $query );
        $result = $stmt->fetchAll();

        if ( count($result) )
        {
            return Zend_Json_Encoder::encode( $result[0] );
        }
        else
        {
            return Zend_Json_Encoder::encode( array() );
        }

    }

    public function get( $uniqueId, $createdBy = 0 )
    {


        /* Determine if user is in 'Instructor' mode */
        if ( $this->masterData )
        {
            /* User is in 'Instructor' mode */
            $where = $this->ptModel->getAdapter()->quoteInto( 'ptUniqueId = ?', $uniqueId);
            $data = $this->ptModel->fetchRow( $where );

        }
        else
        {
            /* User is in 'Student' mode */

            /* check to see if this user has a working copy of this record */
            $where = $this->ptWorkingModel->getAdapter()->quoteInto('ptUniqueId = ?', $uniqueId );
            $where .= $this->ptWorkingModel->getAdapter()->quoteInto(' AND (createdBy = ?', $this->userId );
            $where .= $this->ptWorkingModel->getAdapter()->quoteInto(' OR createdBy = ?)', $createdBy);

            $rows = $this->ptWorkingModel->fetchAll( $where );

            /* if working copy exists, return it */
            if ( count( $rows ) )
            {
                $data = $rows[0];
            }
            /* return master data if no working copy exists */
            else
            {
                $where = $this->ptModel->getAdapter()->quoteInto( 'ptUniqueId = ?', $uniqueId);
                $data = $this->ptModel->fetchRow( $where );
            }


        }



        return $data;
    }

    public function getJson( $uniqueId, $createdBy = 0 )
    {
        $data = $this->get( $uniqueId, $createdBy );
        $mappingService = new Service_Mapping();
        return Zend_Json_Encoder::encode( $mappingService->mapToJson( $this->schema, '', $data ) );
    }

    public function update ( array $data )
    {
        $resp = null;

        /* Determine if user is in 'Instructor' mode */
        if ( $this->masterData )
        {
            /* User is in 'Instructor' mode */

            /* Check to see if we are doing an update or an insert */
            if ( isset( $data['ptUniqueId']) )
            {
                /* If patient ID was passed, we're doing an update */
                $where = $this->ptModel->getAdapter()->quoteInto('ptUniqueId = ?', $data['ptUniqueId']);
                $this->ptModel->update( $data, $where);
                $resp = $data['ptUniqueId'];
            }
            else
            {
                /* No patient ID was passed, so we're doing an insert */
                $this->ptModel->insert( $data );
                $resp = $this->ptModel->lastInsertId();
            }
        }
        else
        {
            /* User is in 'Student' mode */



            /* Check to see if we are doing an update or an insert */
            if ( isset( $data['ptUniqueId']) )
            {
                /* If patient ID was passed, we're going to see if user has a working copy */
                $where = $this->ptWorkingModel->getAdapter()->quoteInto('ptUniqueId = ?', $data['ptUniqueId'] );
                $where .= $this->ptWorkingModel->getAdapter()->quoteInto(' AND createdBy = ?', $this->userId );
                $rows = $this->ptWorkingModel->fetchAll( $where );

                /* if working copy exists, update it */
                if ( count( $rows ) )
                {
                    $this->ptWorkingModel->update( $data, $where);
                    $resp = $data['ptUniqueId'];
                }
                /* create new working copy */
                else
                {
                    $this->ptWorkingModel->insert( $data );
                    $resp = $this->ptWorkingModel->lastInsertId();
                }

            }
            else
            {
                /* No patient ID was passed, so we're doing an insert */
                $this->ptWorkingModel->insert( $data );
                $resp = $this->ptWorkingModel->lastInsertId();

            }

        }


        return $resp;
    }

    public function updateJson( array $data )
    {
        $mappingService = new Service_Mapping();
        $dbArray = array();
        $dbArray = $mappingService->mapToDb( $data, '', $dbArray);
        return $this->update( $dbArray );
    }

    public function submitJson( array $data, $submissionId )
    {
        $mappingService = new Service_Mapping();
        $dbArray = array();
        $dbArray = $mappingService->mapToDb( $data, '', $dbArray);

        $dbArray['submissionId'] = $submissionId;
        $ptSubmissionModel = new Model_PtSubmission();

        $ptSubmissionModel->insert( $dbArray );

    }

    public function getSubmitJson( $uniqueId )
    {
        $ptSubmissionModel = new Model_PtSubmission();
        $ptWhere = $ptSubmissionModel->getAdapter()->quoteInto( 'submissionId = ?', $uniqueId);
        $ptData = $ptSubmissionModel->fetchRow( $ptWhere );

        $submissionModel = new Model_Submission();
        $where = $submissionModel->getAdapter()->quoteInto('submissionId = ?', $uniqueId);
        $submission = $submissionModel->fetchRow( $where );

        $usersModel = new Model_Users();

        $submitData = array();
        $submitData['subId'] = $submission['submissionId'];
        $submitData['subtype'] = $submission['submissionType'];
        $submitData['subDate'] = date('m/d/Y', strtotime($submission['createdDate']));
        $user = $usersModel->getByUserId($submission['createdBy']);
        $submitData['student'] =  $user['firstname'] . ' ' . $user['lastname'];
        $user = $usersModel->getByUserId($submission['submissionTo']);
        $submitData['faculty'] = $user['firstname'] . ' ' . $user['lastname'];
        $submitData['pt'] = $ptData['ptFirstName'] . ' ' . $ptData['ptLastName'];
        $submitData['subStatus'] = strtolower($submission['submissionStatus']);



        $mappingService = new Service_Mapping();

        $json = '{"meta": ' .Zend_Json_Encoder::encode($submitData);
        $json .= ',"item": ' . Zend_Json_Encoder::encode( $mappingService->mapToJson( $this->schema, '', $ptData ) ) . '}';
        return $json;
    }

    public function getSequenceId()
    {
        $seqService = new Service_Seq();
        return $seqService->getValue( $this->service );
    }

    public function import()
    {
        echo '<pre>';
        $dataPath = APPLICATION_PATH . '/views/scripts/patients/data/master-patients';

        echo 'Looking for data in: ' . $dataPath . PHP_EOL;

        // Check to make sure dataPath is a valid directory
        if ( is_dir( $dataPath ) )
        {
            if ($handle = opendir( $dataPath )) {

                /* This is the correct way to loop over the directory. */
                while (false !== ($entry = readdir($handle))) {
                    if ($entry != "." && $entry != ".." && $entry != ".svn")
                    {
                        echo 'Processing ' . $entry . PHP_EOL;
                        $fHandle = fopen( $dataPath . DIRECTORY_SEPARATOR . $entry, "r");
                        $fContents = fread( $fHandle, filesize( $dataPath . DIRECTORY_SEPARATOR . $entry ));
                        $json = Zend_Json_Decoder::decode($fContents);
                        echo 'Json: ' . PHP_EOL;
                        echo Zend_Debug::dump($json) . PHP_EOL;
                        $this->updateJson( $json );
                        fclose($fHandle);

                    }


                }



                closedir($handle);
            }
        }
        echo 'Processing Completed' . PHP_EOL;
        echo '</pre>';
    }

}