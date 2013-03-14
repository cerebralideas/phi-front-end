<?php
class Service_OpCl
{
    private $service = 'opCl';
    private $opClModel;
    private $opClWorkingModel;
    private $opClDiagCodesModel;
    private $opClDiagCodesWorkingModel;
    private $opClProcCodesModel;
    private $opClProcCodesWorkingModel;
    private $schema;
    private $masterData;
    private $userId;
    private $debug = false;

    public function __construct()
    {
        $auth = Zend_Auth::getInstance();
        $storage = $auth->getStorage();
        $this->userId = $storage->read()->id;

        $this->opClModel = new Model_OpCl();
        $this->opClWorkingModel = new Model_OpClWorking();

        $this->opClDiagCodesModel = new Model_OpClDiagCodes();
        $this->opClDiagCodesWorkingModel = new Model_OpClDiagCodesWorking();

        $this->opClProcCodesModel = new Model_OpClProcCodes();
        $this->opClProcCodesWorkingModel = new Model_OpClProcCodesWorking();

        // define schema for JSON
        $this->schema = array(

            "opClDetails" => array(
                "opClId" => null,
                "opSbId" => null,
                "billTo" => null,
                "refNum" => null,
                "resubCode" => null,
                "origRefNum" => null,
                "totalCharges" => null,
                "claimNum" => null
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

            $where = $this->opClModel->getAdapter()->quoteInto( 'opClDetailsOpClId = ?', $uniqueId);
            $data = $this->opClModel->fetchRow( $where );

            if ( count($data) )
            {
                $data = $data->toArray();
                // Convert data to json and back to an array in schema format
                $mappingService = new Service_Mapping();
                $json = Zend_Json_Encoder::encode( $mappingService->mapToJson( $this->schema, '', $data ) );
                $data = Zend_Json_Decoder::decode($json);

                $whereDiagCodes = $this->opClDiagCodesModel->getAdapter()->quoteInto('opClDetailsOpClId = ?', $uniqueId);
                $dataDiagCodes = $this->opClDiagCodesModel->fetchAll( $whereDiagCodes )->toArray();

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

                $whereProcCodes = $this->opClProcCodesModel->getAdapter()->quoteInto('opClDetailsOpClId = ?', $uniqueId);
                $dataProcCodes = $this->opClProcCodesModel->fetchAll( $whereProcCodes )->toArray();

                if ( count($dataProcCodes) )
                    for ($i = 0; $i < count($dataProcCodes); $i++)
                    {
                        $data['procCodes'][] = array(
                            "name" => $dataProcCodes[$i]['name'],
                            "description" => $dataProcCodes[$i]['description'],
                            "modifier" => $dataProcCodes[$i]['modifier'],
                            "charge" => $dataProcCodes[$i]['charge'],
                            "qty" => $dataProcCodes[$i]['qty'],
                            "primaryIcd" => $dataProcCodes[$i]['primaryIcd'],
                            "secondaryIcd" => $dataProcCodes[$i]['secondaryIcd'],
                            "tertiaryIcd" => $dataProcCodes[$i]['tertiaryIcd'],
                            "quaternaryIcd" => $dataProcCodes[$i]['quaternaryIcd']
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
            $where = $this->opClWorkingModel->getAdapter()->quoteInto('opClDetailsOpClId = ?', $uniqueId );
            $where .= $this->opClWorkingModel->getAdapter()->quoteInto(' AND (createdBy = ?', $this->userId );
            $where .= $this->opClWorkingModel->getAdapter()->quoteInto(' OR createdBy = ?)', $createdBy);

            $rows = $this->opClWorkingModel->fetchAll( $where );

            /* if working copy exists, return it */
            if ( count( $rows ) )
            {
                $data = $rows[0];

                // Convert data to json and back to an array in schema format
                $mappingService = new Service_Mapping();
                $json = Zend_Json_Encoder::encode( $mappingService->mapToJson( $this->schema, '', $data ) );
                $data = Zend_Json_Decoder::decode($json);

                $whereDiagCodes = $this->opClDiagCodesWorkingModel->getAdapter()->quoteInto('opClDetailsOpClId = ?', $uniqueId);
                $dataDiagCodes = $this->opClDiagCodesWorkingModel->fetchAll( $whereDiagCodes )->toArray();

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

                $whereProcCodes = $this->opClProcCodesWorkingModel->getAdapter()->quoteInto('opClDetailsOpClId = ?', $uniqueId);
                $dataProcCodes = $this->opClProcCodesWorkingModel->fetchAll( $whereProcCodes )->toArray();

                if ( count($dataProcCodes) )
                    for ($i = 0; $i < count($dataProcCodes); $i++)
                    {
                        $data['procCodes'][] = array(
                            "name" => $dataProcCodes[$i]['name'],
                            "description" => $dataProcCodes[$i]['description'],
                            "modifier" => $dataProcCodes[$i]['modifier'],
                            "charge" => $dataProcCodes[$i]['charge'],
                            "qty" => $dataProcCodes[$i]['qty'],
                            "primaryIcd" => $dataProcCodes[$i]['primaryIcd'],
                            "secondaryIcd" => $dataProcCodes[$i]['secondaryIcd'],
                            "tertiaryIcd" => $dataProcCodes[$i]['tertiaryIcd'],
                            "quaternaryIcd" => $dataProcCodes[$i]['quaternaryIcd']
                        );
                    }
                else
                    $data['procCodes'][] = null;
            }
            /* return master data if no working copy exists */
            else
            {
                $where = $this->opClModel->getAdapter()->quoteInto( 'opClDetailsOpClId = ?', $uniqueId);
                $data = $this->opClModel->fetchRow( $where );

                if ( count($data) )
                {
                    $data = $data->toArray();
                    // Convert data to json and back to an array in schema format
                    $mappingService = new Service_Mapping();
                    $json = Zend_Json_Encoder::encode( $mappingService->mapToJson( $this->schema, '', $data ) );
                    $data = Zend_Json_Decoder::decode($json);

                    $whereDiagCodes = $this->opClDiagCodesModel->getAdapter()->quoteInto('opClDetailsOpClId = ?', $uniqueId);
                    $dataDiagCodes = $this->opClDiagCodesModel->fetchAll( $whereDiagCodes )->toArray();

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

                    $whereProcCodes = $this->opClProcCodesModel->getAdapter()->quoteInto('opClDetailsOpClId = ?', $uniqueId);
                    $dataProcCodes = $this->opClProcCodesModel->fetchAll( $whereProcCodes )->toArray();

                    if ( count($dataProcCodes) )
                        for ($i = 0; $i < count($dataProcCodes); $i++)
                        {
                            $data['procCodes'][] = array(
                                "name" => $dataProcCodes[$i]['name'],
                                "description" => $dataProcCodes[$i]['description'],
                                "modifier" => $dataProcCodes[$i]['modifier'],
                                "charge" => $dataProcCodes[$i]['charge'],
                                "qty" => $dataProcCodes[$i]['qty'],
                                "primaryIcd" => $dataProcCodes[$i]['primaryIcd'],
                                "secondaryIcd" => $dataProcCodes[$i]['secondaryIcd'],
                                "tertiaryIcd" => $dataProcCodes[$i]['tertiaryIcd'],
                                "quaternaryIcd" => $dataProcCodes[$i]['quaternaryIcd']
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

    public function update ( array $data )
    {
        $resp = null;

        // Calculate totalCharges for this claim
        $totalCharges = 0;
        foreach ( $data['procCodes'] as $procCode )
        {
            if ( is_numeric( $procCode['charge'] ) && is_numeric( $procCode['qty'] ) )
            {
                $totalCharges += ( $procCode['qty'] * $procCode['charge'] );
            }
        }
        $totalCharges = round( $totalCharges, 2);



        $header = array(
            'opClDetailsOpClId' => $data['opClDetailsOpClId'],
            'opClDetailsOpSbId' => $data['opClDetailsOpSbId'],
            'opClDetailsBillTo' => $data['opClDetailsBillTo'],
            'opClDetailsRefNum' => $data['opClDetailsRefNum'],
            'opClDetailsResubCode' => $data['opClDetailsResubCode'],
            'opClDetailsOrigRefNum' => $data['opClDetailsOrigRefNum'],
            'opClDetailsTotalCharges' => $totalCharges,
            'opClDetailsClaimNum' => $data['opClDetailsClaimNum']
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
            if ( isset( $header['opClDetailsOpClId']) )
            {
                $resp = $header['opClDetailsOpClId'];

                /* If opClDetailsOpClId was passed, we're doing an update */
                $where = $this->opClModel->getAdapter()->quoteInto('opClDetailsOpClId = ?', $header['opClDetailsOpClId']);
                $this->opClModel->update( $header, $where);

                // Delete existing diag codes for this outpatient claim
                $whereDiagCodes = $this->opClDiagCodesModel->getAdapter()->quoteInto('opClDetailsOpClId = ?', $resp);
                $this->opClDiagCodesModel->delete( $whereDiagCodes );

                // Insert new diag codes for this outpatient claim
                foreach ($details['diagCodes'] as $diagCode)
                {
                    $diagCode['opClDetailsOpClId'] = $resp;
                    $this->opClDiagCodesModel->insert( $diagCode );
                }

                // Delete existing proc codes for this outpatient claim
                $whereProcCodes = $this->opClProcCodesModel->getAdapter()->quoteInto('opClDetailsOpClId = ?', $resp);
                $this->opClProcCodesModel->delete( $whereProcCodes );

                // Insert new proc codes for this outpatient claim
                foreach ($details['procCodes'] as $procCode)
                {
                    $procCode['opClDetailsOpClId'] = $resp;
                    $this->opClProcCodesModel->insert( $procCode );
                }

            }
            else
            {
                /* No opClDetailsOpClId was passed, so we're doing an insert */
                $this->opClModel->insert( $header );
                $resp = $this->opClModel->lastInsertId();

                // Delete existing diag codes for this outpatient claim
                $whereDiagCodes = $this->opClDiagCodesModel->getAdapter()->quoteInto('opClDetailsOpClId = ?', $resp);
                $this->opClDiagCodesModel->delete( $whereDiagCodes );

                // Insert new diag codes for this outpatient claim
                foreach ($details['diagCodes'] as $diagCode)
                {
                    $diagCode['opClDetailsOpClId'] = $resp;
                    $this->opClDiagCodesModel->insert( $diagCode );
                }

                // Delete existing proc codes for this outpatient claim
                $whereProcCodes = $this->opClProcCodesModel->getAdapter()->quoteInto('opClDetailsOpClId = ?', $resp);
                $this->opClProcCodesModel->delete( $whereProcCodes );

                // Insert new proc codes for this outpatient superbill
                foreach ($details['procCodes'] as $procCode)
                {
                    $procCode['opClDetailsOpClId'] = $resp;
                    $this->opClProcCodesModel->insert( $procCode );
                }


            }
        }
        else
        {
            /* User is in 'Student' mode */

            /* Check to see if we are doing an update or an insert */
            if ( isset( $header['opClDetailsOpClId']) )
            {
                /* If opClDetailsOpClId was passed, we're going to see if user has a working copy */
                $where = $this->opClWorkingModel->getAdapter()->quoteInto('opClDetailsOpClId = ?', $header['opClDetailsOpClId'] );
                $where .= $this->opClWorkingModel->getAdapter()->quoteInto(' AND createdBy = ?', $this->userId );
                $rows = $this->opClWorkingModel->fetchAll( $where );

                /* if working copy exists, update it */
                if ( count( $rows ) )
                {
                    $resp = $header['opClDetailsOpClId'];
                    $this->opClWorkingModel->update( $header, $where);

                    // Delete existing diag codes for this outpatient claim
                    $whereDiagCodes = $this->opClDiagCodesWorkingModel->getAdapter()->quoteInto('opClDetailsOpClId = ?', $resp);
                    $this->opClDiagCodesWorkingModel->delete( $whereDiagCodes );

                    // Insert new diag codes for this outpatient claim
                    foreach ($details['diagCodes'] as $diagCode)
                    {
                        $diagCode['opClDetailsOpClId'] = $resp;
                        $this->opClDiagCodesWorkingModel->insert( $diagCode );
                    }

                    // Delete existing proc codes for this outpatient claim
                    $whereProcCodes = $this->opClProcCodesWorkingModel->getAdapter()->quoteInto('opClDetailsOpClId = ?', $resp);
                    $this->opClProcCodesWorkingModel->delete( $whereProcCodes );

                    // Insert new proc codes for this outpatient claim
                    foreach ($details['procCodes'] as $procCode)
                    {
                        $procCode['opClDetailsOpClId'] = $resp;
                        $this->opClProcCodesWorkingModel->insert( $procCode );
                    }

                }
                /* create new working copy */
                else
                {
                    $this->opClWorkingModel->insert( $header );
                    $resp = $this->opClWorkingModel->lastInsertId();

                    // Delete existing diag codes for this outpatient claim
                    $whereDiagCodes = $this->opClDiagCodesWorkingModel->getAdapter()->quoteInto('opClDetailsOpClId = ?', $resp);
                    $this->opClDiagCodesWorkingModel->delete( $whereDiagCodes );

                    // Insert new diag codes for this outpatient claim
                    foreach ($details['diagCodes'] as $diagCode)
                    {
                        $diagCode['opClDetailsOpClId'] = $resp;
                        $this->opClDiagCodesWorkingModel->insert( $diagCode );
                    }

                    // Delete existing proc codes for this outpatient claim
                    $whereProcCodes = $this->opClProcCodesWorkingModel->getAdapter()->quoteInto('opClDetailsOpClId = ?', $resp);
                    $this->opClProcCodesWorkingModel->delete( $whereProcCodes );

                    // Insert new proc codes for this outpatient claim
                    foreach ($details['procCodes'] as $procCode)
                    {
                        $procCode['opClDetailsOpClId'] = $resp;
                        $this->opClProcCodesWorkingModel->insert( $procCode );
                    }
                }

            }
            else
            {
                /* No opClDetailsOpClId was passed, so we're doing an insert */
                $this->opClWorkingModel->insert( $header );
                $resp = $this->opClWorkingModel->lastInsertId();

                // Delete existing diag codes for this outpatient claim
                $whereDiagCodes = $this->opClDiagCodesWorkingModel->getAdapter()->quoteInto('opClDetailsOpClId = ?', $resp);
                $this->opClDiagCodesWorkingModel->delete( $whereDiagCodes );

                // Insert new diag codes for this outpatient claim
                foreach ($details['diagCodes'] as $diagCode)
                {
                    $diagCode['opClDetailsOpClId'] = $resp;
                    $this->opClDiagCodesWorkingModel->insert( $diagCode );
                }

                // Delete existing proc codes for this outpatient claim
                $whereProcCodes = $this->opClProcCodesWorkingModel->getAdapter()->quoteInto('opClDetailsOpClId = ?', $resp);
                $this->opClProcCodesWorkingModel->delete( $whereProcCodes );

                // Insert new proc codes for this outpatient claim
                foreach ($details['procCodes'] as $procCode)
                {
                    $procCode['opClDetailsOpClId'] = $resp;
                    $this->opClProcCodesWorkingModel->insert( $procCode );
                }
            }
        }

        return $resp;
    }

    public function updateJson( array $data )
    {
        // pull apart the data, we need to map the header only to the schema
        $header = array(
            'opClDetails' => $data['opClDetails']
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
            'opClDetails' => $data['opClDetails']
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
            'opClDetailsOpClId' => $dbArray['opClDetailsOpClId'],
            'opClDetailsOpSbId' => $dbArray['opClDetailsOpSbId'],
            'opClDetailsBillTo' => $dbArray['opClDetailsBillTo'],
            'opClDetailsRefNum' => $dbArray['opClDetailsRefNum'],
            'opClDetailsResubCode' => $dbArray['opClDetailsResubCode'],
            'opClDetailsOrigRefNum' => $dbArray['opClDetailsOrigRefNum'],
            'opClDetailsTotalCharges' => $dbArray['opClDetailsTotalCharges'],
            'opClDetailsClaimNum' => $dbArray['opClDetailsClaimNum']
        );
        $details = array(
            'diagCodes' => $dbArray['diagCodes'],
            'procCodes' => $dbArray['procCodes']
        );

        $opClSubmissionModel = new Model_OpClSubmission();
        $opClSubmissionModel->insert( $header );

        $opClDiagCodesSubmissionModel = new Model_OpClDiagCodesSubmission();
        $opClProcCodesSubmission = new Model_OpClProcCodesSubmission();

        //Zend_Debug::dump()
        foreach ($details['diagCodes'] as $diagCode)
        {
            $diagCode['submissionId'] = $submissionId;
            $diagCode['opClDetailsOpClId'] = $dbArray['opClDetailsOpClId'];
            //Zend_Debug::dump( $diagCode );
            $opClDiagCodesSubmissionModel->insert( $diagCode );
        }

        foreach ($details['procCodes'] as $procCode)
        {
            $procCode['submissionId'] = $submissionId;
            $procCode['opClDetailsOpClId'] = $dbArray['opClDetailsOpClId'];
            $opClProcCodesSubmission->insert( $procCode );
        }


    }

    public function getSubmitJson( $uniqueId )
    {
        // Get OpSb Submission Data
        $opClSubmissionModel = new Model_OpClSubmission();
        $opClDiagCodesSubmissionModel = new Model_OpClDiagCodesSubmission();
        $opClProcCodesSubmission = new Model_OpClProcCodesSubmission();

        $where = $opClSubmissionModel->getAdapter()->quoteInto('submissionId = ?', $uniqueId );
        $rows = $opClSubmissionModel->fetchAll( $where );

        if ( count( $rows ) )
        {
            $data = $rows[0];

            // Convert data to json and back to an array in schema format
            $mappingService = new Service_Mapping();
            $json = Zend_Json_Encoder::encode( $mappingService->mapToJson( $this->schema, '', $data ) );
            $data = Zend_Json_Decoder::decode($json);

            $whereDiagCodes = $opClDiagCodesSubmissionModel->getAdapter()->quoteInto('submissionId = ?', $uniqueId);
            $dataDiagCodes = $opClDiagCodesSubmissionModel->fetchAll( $whereDiagCodes )->toArray();

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

            $whereProcCodes = $opClProcCodesSubmission->getAdapter()->quoteInto('submissionId = ?', $uniqueId);
            $dataProcCodes = $opClProcCodesSubmission->fetchAll( $whereProcCodes )->toArray();

            if ( count($dataProcCodes) )
                for ($i = 0; $i < count($dataProcCodes); $i++)
                {
                    $data['procCodes'][] = array(
                        "name" => $dataProcCodes[$i]['name'],
                        "description" => $dataProcCodes[$i]['description'],
                        "modifier" => $dataProcCodes[$i]['modifier'],
                        "charge" => $dataProcCodes[$i]['charge'],
                        "qty" => $dataProcCodes[$i]['qty'],
                        "primaryIcd" => $dataProcCodes[$i]['primaryIcd'],
                        "secondaryIcd" => $dataProcCodes[$i]['secondaryIcd'],
                        "tertiaryIcd" => $dataProcCodes[$i]['tertiaryIcd'],
                        "quaternaryIcd" => $dataProcCodes[$i]['quaternaryIcd']
                    );
                }
            else
                $data['procCodes'][] = null;
        }
        else
        {
            $data = array();
        }


        $opClData = $data;

        //Zend_Debug::dump($opSbData);

        $submissionModel = new Model_Submission();
        $where = $submissionModel->getAdapter()->quoteInto('submissionId = ?', $uniqueId);
        $submission = $submissionModel->fetchRow( $where );

        $usersModel = new Model_Users();

        $ptService = new Service_Pt();
        $aptService = new Service_Apt();

        $opSbService = new Service_OpSb();
        $opSbData = $opSbService->get($opClData['opClDetails']['opSbId'], $submission['createdBy']);

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
        $json .= ',"item": ' . Zend_Json_Encoder::encode($opClData) .
            ',"opSb": ' . Zend_Json_Encoder::encode( $opSbData ) .
            ',"reg": ' . $ptService->getJson($aptData['ptInfoUniqueId']) .
            ',"apt": ' . $aptService->getJson($opSbData['opSbDetails']['aptId']) . '}';
        return $json;


    }

    public function getSequenceId()
    {
        $seqService = new Service_Seq();
        return $seqService->getValue( $this->service );
    }

    public function getSbsWithNoOpCl( $uniqueId )
    {
        $opSbService = new Service_OpSb();
        $opSbs = $opSbService->getByPtId( $uniqueId );
        return $opSbs;

    }

    public function getByPtId( $uniqueId )
    {
        $opSbService = new Service_OpSb();
        $opSbs = $opSbService->getByPtId( $uniqueId );
        $opSbsArray = Zend_Json_Decoder::decode( $opSbs );

        //Zend_Debug::dump($opSbsArray);
        $returnData = array();

        foreach ( $opSbsArray as $opSb )
        {
            $data = $this->getByOpSbId($opSb['opSbId']);
            $arrayData = Zend_Json_Decoder::decode( $data );
            //Zend_Debug::dump($opSb);

            //echo $arrayData[0]['sbDetails']['sbId'];

            if ( count($data) )
            {
                foreach ($arrayData as $clDetails)
                {

                    $aptService = new Service_Apt();
                    //echo $opSb['aptId'];
                    $apt = $aptService->get($opSb['aptId']);
                    //Zend_Debug::dump($clDetails['diagCodes']);

                    $item = array(
                        'opClId' => $clDetails['opClDetails']['opClId'],
                        'opSbId' => $clDetails['opClDetails']['opSbId'],
                        'claimNum' => $clDetails['opClDetails']['claimNum'],
                        'billTo' => $clDetails['opClDetails']['billTo'],
                        'totalCharges' => $clDetails['opClDetails']['totalCharges'],
                        'aptId' => $opSb['aptId'],
                        'date' => $apt['aptDetailsStartDate'],
                        'time' => $apt['aptDetailsStartTime'],
                        'length' => $apt['aptDetailsLength'],
                        'ptStatus' => $apt['statusPtStatus'],
                        'serviceLocation' => $apt['aptDetailsServiceLocation'],
                        'md' => $apt['mdClinic'],
                        'aptType' => $apt['aptDetailsAptType'],
                        'diagCount' => count($clDetails['diagCodes']),
                        'procCount' => count($clDetails['procCodes'])
                    );

                    $returnData[] = $item;
                }
            }
        }
        return Zend_Json_Encoder::encode( $returnData );
    }

    public function getByOpSbId( $uniqueId )
    {
        $returnData = array();
        /* Determine if user is in 'Instructor' mode */
        if ( $this->masterData )
        {
            /* User is in 'Instructor' mode */
            $where = $this->opClModel->getAdapter()->quoteInto( 'opClDetailsOpSbId = ?', $uniqueId);
            $data = $this->opClModel->fetchAll( $where );

            if ( count($data) )
            {
                foreach ( $data as $row )
                {
                    $returnData[] = $this->get( $row['opClDetailsOpClId']);
                }

                return Zend_Json_Encoder::encode($returnData);
            }
            else
            {
                return Zend_Json_Encoder::encode(array());
            }

        }
        else
        {
            /* User is in 'Student' mode */

            $query =
                'SELECT opClDetailsOpClId, opClDetailsOpSbId, opClDetailsBillTo, opClDetailsRefNum, opClDetailsResubCode, opClDetailsOrigRefNum, opClDetailsTotalCharges, opClDetailsClaimNum, createdBy, createdDate, modifiedBy, modifiedDate
                FROM `opCl`
                WHERE
                    `opClDetailsOpClId` NOT IN
                    (
                            SELECT `opClDetailsOpClId` FROM `opCl_working`
                            WHERE `createdBy` = ' . $this->opClModel->quote($this->userId) . '
                    ) AND `opClDetailsOpSbId` = ' . $this->opClModel->quote( $uniqueId ) . '
                UNION
                SELECT opClDetailsOpClId, opClDetailsOpSbId, opClDetailsBillTo, opClDetailsRefNum, opClDetailsResubCode, opClDetailsOrigRefNum, opClDetailsTotalCharges, opClDetailsClaimNum, createdBy, createdDate, modifiedBy, modifiedDate
                    FROM `opCl_working`
                WHERE
                    `createdBy` = ' . $this->opClModel->quote($this->userId) . ' AND
                    `opClDetailsOpSbId` = ' . $this->opClModel->quote( $uniqueId );

            $stmt = $this->opClModel->getAdapter()->query( $query );

            $data = $stmt->fetchAll();

            if ( count($data) )
            {
                foreach ($data as $row)
                {
                    $returnData[] = $this->get( $row['opClDetailsOpClId'] );
                }

                return Zend_Json_Encoder::encode($returnData);
            }
            else
            {
                return Zend_Json_Encoder::encode(array());
            }


        }

    }

}