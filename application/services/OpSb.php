<?php
class Service_OpSb
{
    private $service = 'opSb';
    private $opSbModel;
    private $opSbWorkingModel;
    private $opSbDiagCodesModel;
    private $opSbDiagCodesWorkingModel;
    private $opSbProcCodesModel;
    private $opSbProcCodesWorkingModel;
    private $schema;
    private $masterData;
    private $userId;
    private $debug = false;

    public function __construct()
    {
        $auth = Zend_Auth::getInstance();
        $storage = $auth->getStorage();
        $this->userId = $storage->read()->id;

        $this->opSbModel = new Model_OpSb();
        $this->opSbWorkingModel = new Model_OpSbWorking();

        $this->opSbDiagCodesModel = new Model_OpSbDiagCodes();
        $this->opSbDiagCodesWorkingModel = new Model_OpSbDiagCodesWorking();

        $this->opSbProcCodesModel = new Model_OpSbProcCodes();
        $this->opSbProcCodesWorkingModel = new Model_OpSbProcCodesWorking();

        // define schema for JSON
        $this->schema = array(

            "opSbDetails" => array(
                "opSbId" => null,
                "aptId" => null,
                "memo" => null,
                "refNum" => null,
                "medNotes" => null,
                "busNotes" => null,
                "authNotes" => null,
                "dateOfInitial" => null,
                "priorAuthNumber" => null
            )

        );

        $preferencesService = new Service_Preferences();
        $this->masterData = $preferencesService->getMasterDataFlag();
    }

    public function getSchema()
    {
        return $this->schema;
    }

    public function get( $uniqueId, $createdBy = 0 )
    {
        /* Determine if user is in 'Instructor' mode */
        if ( $this->masterData )
        {
            /* User is in 'Instructor' mode */

            $where = $this->opSbModel->getAdapter()->quoteInto( 'opSbDetailsOpSbId = ?', $uniqueId);
            $data = $this->opSbModel->fetchRow( $where );

            if ( count($data) )
            {
                $data = $data->toArray();
                // Convert data to json and back to an array in schema format
                $mappingService = new Service_Mapping();
                $json = Zend_Json_Encoder::encode( $mappingService->mapToJson( $this->schema, '', $data ) );
                $data = Zend_Json_Decoder::decode($json);

                $whereDiagCodes = $this->opSbDiagCodesModel->getAdapter()->quoteInto('opSbDetailsOpSbId = ?', $uniqueId);
                $dataDiagCodes = $this->opSbDiagCodesModel->fetchAll( $whereDiagCodes )->toArray();

                if ( count($dataDiagCodes) )
                    for ($i = 0; $i < count($dataDiagCodes); $i++)
                    {
                        $data['diagCodes'][] = array(
                            "order" => $dataDiagCodes[$i]['order'],
                            "num" => $dataDiagCodes[$i]['num'],
                            "name" => $dataDiagCodes[$i]['name'],
                            "description" => $dataDiagCodes[$i]['description']
                        );
                    }
                else
                    $data['diagCodes'][] = null;

                $whereProcCodes = $this->opSbProcCodesModel->getAdapter()->quoteInto('opSbDetailsOpSbId = ?', $uniqueId);
                $dataProcCodes = $this->opSbProcCodesModel->fetchAll( $whereProcCodes )->toArray();

                if ( count($dataProcCodes) )
                    for ($i = 0; $i < count($dataProcCodes); $i++)
                    {
                        $data['procCodes'][] = array(
                            "num" => $dataProcCodes[$i]['num'],
                            "name" => $dataProcCodes[$i]['name'],
                            "description" => $dataProcCodes[$i]['description'],
                            "modifier" => $dataProcCodes[$i]['modifier'],
                            "qty" => $dataProcCodes[$i]['qty'],
                            "charge" => $dataProcCodes[$i]['charge']
                        );
                    }
                else
                    $data['procCodes'][] = null;
            }
            else
            {
                $data = array();
            }

        }
        else
        {
            /* User is in 'Student' mode */

            /* check to see if this user has a working copy of this record */
            $where = $this->opSbWorkingModel->getAdapter()->quoteInto('opSbDetailsOpSbId = ?', $uniqueId );
            $where .= $this->opSbWorkingModel->getAdapter()->quoteInto(' AND (createdBy = ?', $this->userId );
            $where .= $this->opSbWorkingModel->getAdapter()->quoteInto(' OR createdBy = ?)', $createdBy);

            $rows = $this->opSbWorkingModel->fetchAll( $where );

            /* if working copy exists, return it */
            if ( count( $rows ) )
            {
                $data = $rows[0];

                // Convert data to json and back to an array in schema format
                $mappingService = new Service_Mapping();
                $json = Zend_Json_Encoder::encode( $mappingService->mapToJson( $this->schema, '', $data ) );
                $data = Zend_Json_Decoder::decode($json);

                $whereDiagCodes = $this->opSbDiagCodesWorkingModel->getAdapter()->quoteInto('opSbDetailsOpSbId = ?', $uniqueId);
                $dataDiagCodes = $this->opSbDiagCodesWorkingModel->fetchAll( $whereDiagCodes )->toArray();

                if ( count($dataDiagCodes) )
                    for ($i = 0; $i < count($dataDiagCodes); $i++)
                    {
                        $data['diagCodes'][] = array(
                            "order" => $dataDiagCodes[$i]['order'],
                            "num" => $dataDiagCodes[$i]['num'],
                            "name" => $dataDiagCodes[$i]['name'],
                            "description" => $dataDiagCodes[$i]['description']
                        );
                    }
                else
                    $data['diagCodes'][] = null;

                $whereProcCodes = $this->opSbProcCodesWorkingModel->getAdapter()->quoteInto('opSbDetailsOpSbId = ?', $uniqueId);
                $dataProcCodes = $this->opSbProcCodesWorkingModel->fetchAll( $whereProcCodes )->toArray();

                if ( count($dataProcCodes) )
                    for ($i = 0; $i < count($dataProcCodes); $i++)
                    {
                        $data['procCodes'][] = array(
                            "num" => $dataProcCodes[$i]['num'],
                            "name" => $dataProcCodes[$i]['name'],
                            "description" => $dataProcCodes[$i]['description'],
                            "modifier" => $dataProcCodes[$i]['modifier'],
                            "qty" => $dataProcCodes[$i]['qty'],
                            "charge" => $dataProcCodes[$i]['charge']
                        );
                    }
                else
                    $data['procCodes'][] = null;
            }
            /* return master data if no working copy exists */
            else
            {
                $where = $this->opSbModel->getAdapter()->quoteInto( 'opSbDetailsOpSbId = ?', $uniqueId);
                $data = $this->opSbModel->fetchRow( $where );

                if ( count($data) )
                {
                    $data = $data->toArray();
                    // Convert data to json and back to an array in schema format
                    $mappingService = new Service_Mapping();
                    $json = Zend_Json_Encoder::encode( $mappingService->mapToJson( $this->schema, '', $data ) );
                    $data = Zend_Json_Decoder::decode($json);

                    $whereDiagCodes = $this->opSbDiagCodesModel->getAdapter()->quoteInto('opSbDetailsOpSbId = ?', $uniqueId);
                    $dataDiagCodes = $this->opSbDiagCodesModel->fetchAll( $whereDiagCodes )->toArray();

                    if ( count($dataDiagCodes) )
                        for ($i = 0; $i < count($dataDiagCodes); $i++)
                        {
                            $data['diagCodes'][] = array(
                                "order" => $dataDiagCodes[$i]['order'],
                                "num" => $dataDiagCodes[$i]['num'],
                                "name" => $dataDiagCodes[$i]['name'],
                                "description" => $dataDiagCodes[$i]['description']
                            );
                        }
                    else
                        $data['diagCodes'][] = null;

                    $whereProcCodes = $this->opSbProcCodesModel->getAdapter()->quoteInto('opSbDetailsOpSbId = ?', $uniqueId);
                    $dataProcCodes = $this->opSbProcCodesModel->fetchAll( $whereProcCodes )->toArray();

                    if ( count($dataProcCodes) )
                        for ($i = 0; $i < count($dataProcCodes); $i++)
                        {
                            $data['procCodes'][] = array(
                                "num" => $dataProcCodes[$i]['num'],
                                "name" => $dataProcCodes[$i]['name'],
                                "description" => $dataProcCodes[$i]['description'],
                                "modifier" => $dataProcCodes[$i]['modifier'],
                                "qty" => $dataProcCodes[$i]['qty'],
                                "charge" => $dataProcCodes[$i]['charge']
                            );
                        }
                    else
                        $data['procCodes'][] = null;

                }
                else
                {
                    $data = array();
                }
            }

        }
        return $data;
    }

    public function getJson( $uniqueId, $createdBy = 0 )
    {
        $data = $this->get( $uniqueId, $createdBy );

        if (count ($data) )
            return Zend_Json_Encoder::encode( $data );
        else
            return "{}";
    }

    public function getAptsWithNoOpSb( $uniqueId )
    {
        $aptService = new Service_Apt();
        $apts = $aptService->getAptListForPtJson( $uniqueId );
        $aptsArray = Zend_Json_Decoder::decode( $apts );

        //Zend_Debug::dump($aptsArray);

        $returnData = array();

        foreach ( $aptsArray as $apt )
        {
            $data = $this->getByAptId($apt['aptId']);
            $arrayData = Zend_Json_Decoder::decode( $data );
            //Zend_Debug::dump($arrayData);

            //echo $arrayData[0]['sbDetails']['sbId'];

            if ( !count($arrayData) )
                $returnData[] = $apt;
        }

        return Zend_Json_Encoder::encode( $returnData );

    }

    public function getByPtId( $uniqueId )
    {
        $aptService = new Service_Apt();
        $apts = $aptService->getAptListForPtJson( $uniqueId );
        $aptsArray = Zend_Json_Decoder::decode( $apts );

        //Zend_Debug::dump($aptsArray);

        $returnData = array();

        foreach ( $aptsArray as $apt )
        {
            $data = $this->getByAptId($apt['aptId']);
            $arrayData = Zend_Json_Decoder::decode( $data );
            //Zend_Debug::dump($arrayData);

            //echo $arrayData[0]['sbDetails']['sbId'];

            if ( count($data) )
            {
                foreach ($arrayData as $sbDetails)
                {
                    $item = array(
                        'opSbId' => $sbDetails['opSbDetails']['opSbId'],
                        'aptId' => $apt['aptId'],
                        'date' => $apt['date'],
                        'time' => $apt['time'],
                        'length' => $apt['length'],
                        'ptStatus' => $apt['ptStatus'],
                        'serviceLocation' => $apt['serviceLocation'],
                        'md' => $apt['md'],
                        'aptType' => $apt['aptType'],
                        'diagCount' => count($sbDetails['diagCodes']),
                        'procCount' => count($sbDetails['procCodes'])
                    );

                    if (count($sbDetails['opSbDetails']))
                        $returnData[] = $item;
                }

            }

        }

        return Zend_Json_Encoder::encode( $returnData );

    }

    public function getByAptId( $uniqueId )
    {
        $returnData = array();
        /* Determine if user is in 'Instructor' mode */
        if ( $this->masterData )
        {
            /* User is in 'Instructor' mode */
            $where = $this->opSbModel->getAdapter()->quoteInto( 'opSbDetailsAptId = ?', $uniqueId);
            $data = $this->opSbModel->fetchAll( $where );

            if ( count($data) )
            {
                foreach ( $data as $row )
                {
                    $returnData[] = $this->get( $row['opSbDetailsOpSbId']);
                }

                return Zend_Json_Encoder::encode($returnData);
            }
            else
            {
                return Zend_Json_Encoder::encode(array());;
            }

        }
        else
        {
            /* User is in 'Student' mode */

            $query =
                'SELECT `opSbDetailsOpSbId`, `opSbDetailsAptId`, `opSbDetailsMemo`, `opSbDetailsRefNum`, `opSbDetailsMedNotes`, `opSbDetailsAuthNotes`, `opSbDetailsBusNotes`, `opSbDetailsDateOfInitial`, `opSbDetailsPriorAuthNumber`, `createdBy`, `createdDate`, `modifiedBy`, `modifiedDate`
                FROM `opSb`
                WHERE
                    `opSbDetailsOpSbId` NOT IN
                    (
                            SELECT `opSbDetailsOpSbId` FROM `opSb_working`
                            WHERE `createdBy` = ' . $this->opSbModel->quote($this->userId) . '
                    ) AND `opSbDetailsAptId` = ' . $this->opSbModel->quote( $uniqueId ) . '
                UNION
                SELECT `opSbDetailsOpSbId`, `opSbDetailsAptId`, `opSbDetailsMemo`, `opSbDetailsRefNum`, `opSbDetailsMedNotes`, `opSbDetailsAuthNotes`, `opSbDetailsBusNotes`, `opSbDetailsDateOfInitial`, `opSbDetailsPriorAuthNumber`, `createdBy`, `createdDate`, `modifiedBy`, `modifiedDate`
                    FROM `opSb_working`
                WHERE
                    `createdBy` = ' . $this->opSbModel->quote($this->userId) . ' AND
                    `opSbDetailsAptId` = ' . $this->opSbModel->quote( $uniqueId );

            $stmt = $this->opSbModel->getAdapter()->query( $query );

            $data = $stmt->fetchAll();

            if ( count($data) )
            {
                foreach ($data as $row)
                {
                    $returnData[] = $this->get( $row['opSbDetailsOpSbId'] );
                }

                return Zend_Json_Encoder::encode($returnData);
            }
            else
            {
                return Zend_Json_Encoder::encode(array());;
            }


        }
    }


    public function update ( array $data )
    {
        $resp = null;

        $header = array(
            'opSbDetailsOpSbId' => $data['opSbDetailsOpSbId'],
            'opSbDetailsAptId' => $data['opSbDetailsAptId'],
            'opSbDetailsMemo' => $data['opSbDetailsMemo'],
            'opSbDetailsRefNum' => $data['opSbDetailsRefNum'],
            'opSbDetailsMedNotes' => $data['opSbDetailsMedNotes'],
            'opSbDetailsAuthNotes' => $data['opSbDetailsAuthNotes'],
            'opSbDetailsBusNotes' => $data['opSbDetailsBusNotes'],
            'opSbDetailsDateOfInitial' => $data['opSbDetailsDateOfInitial'],
            'opSbDetailsPriorAuthNumber' => $data['opSbDetailsPriorAuthNumber']
        );
        $details = array(
            'diagCodes' => $data['diagCodes'],
            'procCodes' => $data['procCodes']
        );

        /* Determine if user is in 'Instructor' mode */
        if ( $this->masterData )
        {
            /* User is in 'Instructor' mode */

            /* Check to see if we are doing an update or an insert */
            if ( isset( $header['opSbDetailsOpSbId']) )
            {
                $resp = $header['opSbDetailsOpSbId'];

                /* If sbDetailsSbId was passed, we're doing an update */
                $where = $this->opSbModel->getAdapter()->quoteInto('opSbDetailsOpSbId = ?', $header['opSbDetailsOpSbId']);
                $this->opSbModel->update( $header, $where);

                // Delete existing diag codes for this outpatient superbill
                $whereDiagCodes = $this->opSbDiagCodesModel->getAdapter()->quoteInto('opSbDetailsOpSbId = ?', $resp);
                $this->opSbDiagCodesModel->delete( $whereDiagCodes );

                // Insert new diag codes for this outpatient superbill
                foreach ($details['diagCodes'] as $diagCode)
                {
                    $diagCode['opSbDetailsOpSbId'] = $resp;
                    $this->opSbDiagCodesModel->insert( $diagCode );
                }

                // Delete existing proc codes for this outpatient superbill
                $whereProcCodes = $this->opSbProcCodesModel->getAdapter()->quoteInto('opSbDetailsOpSbId = ?', $resp);
                $this->opSbProcCodesModel->delete( $whereProcCodes );

                // Insert new proc codes for this outpatient superbill
                foreach ($details['procCodes'] as $procCode)
                {
                    $procCode['opSbDetailsOpSbId'] = $resp;
                    $this->opSbProcCodesModel->insert( $procCode );
                }

            }
            else
            {
                /* No sbDetailsSbId was passed, so we're doing an insert */
                $this->opSbModel->insert( $header );
                $resp = $this->opSbModel->lastInsertId();

                // Delete existing diag codes for this outpatient superbill
                $whereDiagCodes = $this->opSbDiagCodesModel->getAdapter()->quoteInto('opSbDetailsOpSbId = ?', $resp);
                $this->opSbDiagCodesModel->delete( $whereDiagCodes );

                // Insert new diag codes for this outpatient superbill
                foreach ($details['diagCodes'] as $diagCode)
                {
                    $diagCode['opSbDetailsOpSbId'] = $resp;
                    $this->opSbDiagCodesModel->insert( $diagCode );
                }

                // Delete existing proc codes for this outpatient superbill
                $whereProcCodes = $this->opSbProcCodesModel->getAdapter()->quoteInto('opSbDetailsOpSbId = ?', $resp);
                $this->opSbProcCodesModel->delete( $whereProcCodes );

                // Insert new proc codes for this outpatient superbill
                foreach ($details['procCodes'] as $procCode)
                {
                    $procCode['opSbDetailsOpSbId'] = $resp;
                    $this->opSbProcCodesModel->insert( $procCode );
                }


            }
        }
        else
        {
            /* User is in 'Student' mode */

            /* Check to see if we are doing an update or an insert */
            if ( isset( $header['opSbDetailsOpSbId']) )
            {
                /* If sbDetailsSbId was passed, we're going to see if user has a working copy */
                $where = $this->opSbWorkingModel->getAdapter()->quoteInto('opSbDetailsOpSbId = ?', $header['opSbDetailsOpSbId'] );
                $where .= $this->opSbWorkingModel->getAdapter()->quoteInto(' AND createdBy = ?', $this->userId );
                $rows = $this->opSbWorkingModel->fetchAll( $where );

                /* if working copy exists, update it */
                if ( count( $rows ) )
                {
                    $resp = $header['opSbDetailsOpSbId'];
                    $this->opSbWorkingModel->update( $header, $where);

                    // Delete existing diag codes for this outpatient superbill
                    $whereDiagCodes = $this->opSbDiagCodesWorkingModel->getAdapter()->quoteInto('opSbDetailsOpSbId = ?', $resp);
                    $this->opSbDiagCodesWorkingModel->delete( $whereDiagCodes );

                    // Insert new diag codes for this outpatient superbill
                    foreach ($details['diagCodes'] as $diagCode)
                    {
                        $diagCode['opSbDetailsOpSbId'] = $resp;
                        $this->opSbDiagCodesWorkingModel->insert( $diagCode );
                    }

                    // Delete existing proc codes for this outpatient superbill
                    $whereProcCodes = $this->opSbProcCodesWorkingModel->getAdapter()->quoteInto('opSbDetailsOpSbId = ?', $resp);
                    $this->opSbProcCodesWorkingModel->delete( $whereProcCodes );

                    // Insert new proc codes for this outpatient superbill
                    foreach ($details['procCodes'] as $procCode)
                    {
                        $procCode['opSbDetailsOpSbId'] = $resp;
                        $this->opSbProcCodesWorkingModel->insert( $procCode );
                    }

                }
                /* create new working copy */
                else
                {
                    $this->opSbWorkingModel->insert( $header );
                    $resp = $this->opSbWorkingModel->lastInsertId();

                    // Delete existing diag codes for this outpatient superbill
                    $whereDiagCodes = $this->opSbDiagCodesWorkingModel->getAdapter()->quoteInto('opSbDetailsOpSbId = ?', $resp);
                    $this->opSbDiagCodesWorkingModel->delete( $whereDiagCodes );

                    // Insert new diag codes for this outpatient superbill
                    foreach ($details['diagCodes'] as $diagCode)
                    {
                        $diagCode['opSbDetailsOpSbId'] = $resp;
                        $this->opSbDiagCodesWorkingModel->insert( $diagCode );
                    }

                    // Delete existing proc codes for this outpatient superbill
                    $whereProcCodes = $this->opSbProcCodesWorkingModel->getAdapter()->quoteInto('opSbDetailsOpSbId = ?', $resp);
                    $this->opSbProcCodesWorkingModel->delete( $whereProcCodes );

                    // Insert new proc codes for this outpatient superbill
                    foreach ($details['procCodes'] as $procCode)
                    {
                        $procCode['opSbDetailsOpSbId'] = $resp;
                        $this->opSbProcCodesWorkingModel->insert( $procCode );
                    }
                }

            }
            else
            {
                /* No sbDetailsSbId was passed, so we're doing an insert */
                $this->opSbWorkingModel->insert( $header );
                $resp = $this->opSbWorkingModel->lastInsertId();

                // Delete existing diag codes for this outpatient superbill
                $whereDiagCodes = $this->opSbDiagCodesWorkingModel->getAdapter()->quoteInto('opSbDetailsOpSbId = ?', $resp);
                $this->opSbDiagCodesWorkingModel->delete( $whereDiagCodes );

                // Insert new diag codes for this outpatient superbill
                foreach ($details['diagCodes'] as $diagCode)
                {
                    $diagCode['opSbDetailsOpSbId'] = $resp;
                    $this->opSbDiagCodesWorkingModel->insert( $diagCode );
                }

                // Delete existing proc codes for this outpatient superbill
                $whereProcCodes = $this->opSbProcCodesWorkingModel->getAdapter()->quoteInto('opSbDetailsOpSbId = ?', $resp);
                $this->opSbProcCodesWorkingModel->delete( $whereProcCodes );

                // Insert new proc codes for this outpatient superbill
                foreach ($details['procCodes'] as $procCode)
                {
                    $procCode['opSbDetailsOpSbId'] = $resp;
                    $this->opSbProcCodesWorkingModel->insert( $procCode );
                }
            }
        }

        return $resp;
    }

    public function updateJson( array $data )
    {
        // pull apart the data, we need to map the header only to the schema
        $header = array(
            'opSbDetails' => $data['opSbDetails']
        );
        $details = array(
            'diagCodes' => $data['diagCodes'],
            'procCodes' => $data['procCodes']
        );


        $mappingService = new Service_Mapping();
        $dbHeader = array();
        $dbHeader = $mappingService->mapToDb( $header, '', $dbHeader);

        $dbArray = array_merge( $dbHeader, $details);
        return $this->update( $dbArray );
    }

    public function submitJson( array $data, $submissionId )
    {
        // pull apart the data, we need to map the header only to the schema
        $header = array(
            'opSbDetails' => $data['opSbDetails']
        );
        $details = array(
            'diagCodes' => $data['diagCodes'],
            'procCodes' => $data['procCodes']
        );


        $mappingService = new Service_Mapping();
        $dbHeader = array();
        $dbHeader = $mappingService->mapToDb( $header, '', $dbHeader);

        $dbArray = array_merge( $dbHeader, $details);

        $header = array(
            'submissionId' => $submissionId,
            'opSbDetailsOpSbId' => $dbArray['opSbDetailsOpSbId'],
            'opSbDetailsAptId' => $dbArray['opSbDetailsAptId'],
            'opSbDetailsMemo' => $dbArray['opSbDetailsMemo'],
            'opSbDetailsRefNum' => $dbArray['opSbDetailsRefNum'],
            'opSbDetailsMedNotes' => $dbArray['opSbDetailsMedNotes'],
            'opSbDetailsAuthNotes' => $dbArray['opSbDetailsAuthNotes'],
            'opSbDetailsBusNotes' => $dbArray['opSbDetailsBusNotes'],
            'opSbDetailsDateOfInitial' => $dbArray['opSbDetailsDateOfInitial'],
            'opSbDetailsPriorAuthNumber' => $dbArray['opSbDetailsPriorAuthNumber']
        );
        $details = array(
            'diagCodes' => $dbArray['diagCodes'],
            'procCodes' => $dbArray['procCodes']
        );

        $opSbSubmissionModel = new Model_OpSbSubmission();
        $opSbSubmissionModel->insert( $header );

        $opSbDiagCodesSubmissionModel = new Model_OpSbDiagCodesSubmission();
        $opSbProcCodesSubmission = new Model_OpSbProcCodesSubmission();

        foreach ($details['diagCodes'] as $diagCode)
        {
            $diagCode['submissionId'] = $submissionId;
            $diagCode['opSbDetailsOpSbId'] = $dbArray['opSbDetailsOpSbId'];
            $opSbDiagCodesSubmissionModel->insert( $diagCode );
        }

        foreach ($details['procCodes'] as $procCode)
        {
            $procCode['submissionId'] = $submissionId;
            $procCode['opSbDetailsOpSbId'] = $dbArray['opSbDetailsOpSbId'];
            $opSbProcCodesSubmission->insert( $procCode );
        }


    }

    public function getSubmitJson( $uniqueId )
    {
        // Get OpSb Submission Data
        $opSbSubmissionModel = new Model_OpSbSubmission();
        $opSbDiagCodesSubmissionModel = new Model_OpSbDiagCodesSubmission();
        $opSbProcCodesSubmission = new Model_OpSbProcCodesSubmission();

        $where = $opSbSubmissionModel->getAdapter()->quoteInto('submissionId = ?', $uniqueId );
        $rows = $opSbSubmissionModel->fetchAll( $where );

        if ( count( $rows ) )
        {
            $data = $rows[0];

            // Convert data to json and back to an array in schema format
            $mappingService = new Service_Mapping();
            $json = Zend_Json_Encoder::encode( $mappingService->mapToJson( $this->schema, '', $data ) );
            $data = Zend_Json_Decoder::decode($json);

            $whereDiagCodes = $opSbDiagCodesSubmissionModel->getAdapter()->quoteInto('submissionId = ?', $uniqueId);
            $dataDiagCodes = $opSbDiagCodesSubmissionModel->fetchAll( $whereDiagCodes )->toArray();

            if ( count($dataDiagCodes) )
                for ($i = 0; $i < count($dataDiagCodes); $i++)
                {
                    $data['diagCodes'][] = array(
                        "order" => $dataDiagCodes[$i]['order'],
                        "num" => $dataDiagCodes[$i]['num'],
                        "name" => $dataDiagCodes[$i]['name'],
                        "description" => $dataDiagCodes[$i]['description']
                    );
                }
            else
                $data['diagCodes'][] = null;

            $whereProcCodes = $opSbProcCodesSubmission->getAdapter()->quoteInto('submissionId = ?', $uniqueId);
            $dataProcCodes = $opSbProcCodesSubmission->fetchAll( $whereProcCodes )->toArray();

            if ( count($dataProcCodes) )
                for ($i = 0; $i < count($dataProcCodes); $i++)
                {
                    $data['procCodes'][] = array(
                        "num" => $dataProcCodes[$i]['num'],
                        "name" => $dataProcCodes[$i]['name'],
                        "description" => $dataProcCodes[$i]['description'],
                        "modifier" => $dataProcCodes[$i]['modifier'],
                        "qty" => $dataProcCodes[$i]['qty'],
                        "charge" => $dataProcCodes[$i]['charge']
                    );
                }
            else
                $data['procCodes'][] = null;
        }
        else
        {
            $data = array();
        }

        $opSbData = $data;

        //Zend_Debug::dump($opSbData);

        $submissionModel = new Model_Submission();
        $where = $submissionModel->getAdapter()->quoteInto('submissionId = ?', $uniqueId);
        $submission = $submissionModel->fetchRow( $where );

        $usersModel = new Model_Users();

        $ptService = new Service_Pt();
        $aptService = new Service_Apt();

        $aptData = $aptService->get( $opSbData['opSbDetails']['aptId'], $submission['createdBy'] );

        //Zend_Debug::dump($aptData);
        $ptData = $ptService->get( $aptData['ptInfoUniqueId'], $submission['createdBy'] );
        //die();
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

        $json = '{"meta": ' .Zend_Json_Encoder::encode($submitData);
        $json .= ',"item": ' . Zend_Json_Encoder::encode( $opSbData ) . ',"reg": ' . $ptService->getJson($aptData['ptInfoUniqueId']) . ',"apt": ' . $aptService->getJson($opSbData['opSbDetails']['aptId']) . '}';
        return $json;

    }

    public function getSequenceId()
    {
        $seqService = new Service_Seq();
        return $seqService->getValue( $this->service );
    }

}