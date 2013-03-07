/**
 * This is the controller for global form element options.
 * Author: Justin Lowery
 * Date: 7/25/12
 * Time: 2:51 PM
 */

PAS.ctrlr.global = function ctrlrDotGlobal($rootScope, dataServices, $scope, dateMgmt) {

    "use strict";


    /************************************\
     * This is the global user mode section
     */

        $scope.userMode = null;
        $scope.userRole = DATA.user.role;
        $scope.userFirstName = DATA.user.firstName;

        console.log($scope.userRole);

        if ($scope.userRole === 'ai_admin') {

            $scope.betaOne = 'true';
            $scope.betaTwo = 'true';
            $scope.betaThree = 'true';
            $scope.betaFour = 'true';
            $scope.betaFive = 'true';

        } else {

            $scope.betaOne = 'true';
            $scope.betaTwo = 'true';
            $scope.betaThree = 'true';
            $scope.betaFour = 'true';
            $scope.betaFive = 'false';
        }

        if ($scope.userRole === 'ai_admin') {

            $scope.admin = 'true';

        } else if ($scope.userRole === 'org_faculty') {

            $scope.faculty = 'true';

        } else if ($scope.userRole === 'org_student') {

            $scope.student = 'true';
        }

        $scope.getUserMode = dataServices.fn.query('/preferencesasync/getmasterdataflag').then(function (returned) {

                $scope.instrMode = returned.data.toString() === '1' ? 'instrMode' : 'stdtMode';

                return returned.data.toString();
            });

        $scope.toggleUserMode = function toggleUserMode() {

            dataServices.fn.save('masterFlag', $scope.userMode).then(function () {

                $scope.instrMode = $scope.userMode === '1' ? 'instrMode' : 'stdtMode';
            });
        };

        $scope.userMode = $scope.getUserMode;


    /************************************\
     * This is the global form select section
     */


        // Has key-value pairs
        $scope.states = [

            {value: "AL", text: "Alabama"},
            {value: "AK", text: "Alaska"},
            {value: "AZ", text: "Arizona"},
            {value: "AR", text: "Arkansas"},
            {value: "CA", text: "California"},
            {value: "CO", text: "Colorado"},
            {value: "CT", text: "Connecticut"},
            {value: "DE", text: "Delaware"},
            {value: "DC", text: "District Of Columbia"},
            {value: "FL", text: "Florida"},
            {value: "GA", text: "Georgia"},
            {value: "HI", text: "Hawaii"},
            {value: "ID", text: "Idaho"},
            {value: "IL", text: "Illinois"},
            {value: "IN", text: "Indiana"},
            {value: "IA", text: "Iowa"},
            {value: "KS", text: "Kansas"},
            {value: "KY", text: "Kentucky"},
            {value: "LA", text: "Louisiana"},
            {value: "ME", text: "Maine"},
            {value: "MD", text: "Maryland"},
            {value: "MA", text: "Massachusetts"},
            {value: "MI", text: "Michigan"},
            {value: "MN", text: "Minnesota"},
            {value: "MS", text: "Mississippi"},
            {value: "MO", text: "Missouri"},
            {value: "MT", text: "Montana"},
            {value: "NE", text: "Nebraska"},
            {value: "NV", text: "Nevada"},
            {value: "NH", text: "New Hampshire"},
            {value: "NJ", text: "New Jersey"},
            {value: "NM", text: "New Mexico"},
            {value: "NP", text: "Neehr Perfect"},
            {value: "NY", text: "New York"},
            {value: "NC", text: "North Carolina"},
            {value: "ND", text: "North Dakota"},
            {value: "OH", text: "Ohio"},
            {value: "OK", text: "Oklahoma"},
            {value: "OR", text: "Oregon"},
            {value: "PA", text: "Pennsylvania"},
            {value: "RI", text: "Rhode Island"},
            {value: "SC", text: "South Carolina"},
            {value: "SD", text: "South Dakota"},
            {value: "TN", text: "Tennessee"},
            {value: "TX", text: "Texas"},
            {value: "UT", text: "Utah"},
            {value: "VT", text: "Vermont"},
            {value: "VA", text: "Virginia"},
            {value: "WA", text: "Washington"},
            {value: "WV", text: "West Virginia"},
            {value: "WI", text: "Wisconsin"},
            {value: "WY", text: "Wyoming"}
        ];

        // Name Suffixes
        $scope.suffixes = [

            "Jr",
            "Sr",
            "II",
            "III",
            "IV"
        ];

        // Has key-value pairs
        $scope.sexes = [

            {"value": "M", "text": "Male"},
            {"value": "F", "text": "Female"}
        ];

        $scope.maritalStatuses = [

            "Married",
            "Divorced",
            "Single",
            "Widowed",
            "Other"
        ];

        $scope.employmentStatuses = [

            "Employed",
            "Unemployed",
            "Retired",
            "Full-Time Student",
            "Part-Time Student",
            "Other"
        ];

        $scope.accTypes = [

            "Employment",
            "Auto Accident",
            "Other Accident"
        ];

        $scope.relationships = {

            "parents": [

                "Father",
                "Mother",
                "Guardian"
            ],

            "payors": [

                "Self",
                "Father",
                "Mother",
                "Guardian",
                "Spouse",
                "Other Family"
            ]
        };

        $scope.mds = [

            "Dr. Lupez",
            "Dr. Lawler",
            "Dr. Hughesz",
            "Dr. H. Stewart",
            "Dr. W. Stewart"
        ];

        $scope.clinics = [

            "General Medical Clinic",
            "Pediatric Clinic"
        ];

        $scope.aptLengths = [

            "15 min",
            "30 min",
            "45 min",
            "60 min",
            "90 min"
        ];

        $scope.aptTypes = [

            "Physical Exam",
            "Well Child",
            "GYN",
            "Prenatal",
            "Mental Health",
            "Med Check",
            "Vaccine",
            "Acute Care",
            "Chronic Care",
            "Urgent Care",
            "Lab/Diagnostics",
            "Walk In",
            "Follow-Up Appointment",
            "Lunch Break",
            "Drug Representative",
            "Miscellaneous",
            "Hospital Rounds",
            "Nurse Visit"
        ];

        $scope.aptStatuses = [

            "Scheduled",
            "Checked-In",
            "Checked-Out",
            "Cancelled",
            "No-Show"
        ];

        $scope.admStatuses = [

            "Scheduled",
            "Admitted",
            "Discharged",
            "Canceled",
            "No-Show"
        ];

        $scope.admTypes = [

            "Inpatient Scheduled",
            "Inpatient Direct",
            "Inpatient Transfer",
            "Emergency",
            "Outpatient Surgery/Procedure",
            "Observation",
            "Extended Stay",
            "Other"
        ];

        $scope.trtSpecialties = [

            "Birthing",
            "Cardiac Surgery",
            "Cardiology",
            "Critical Care",
            "Gastroenterology",
            "General Surgery",
            "Gerontology",
            "Hematology/Oncology",
            "Hospice",
            "Long Stay Dementia Care",
            "Long Stay Skilled Nursing",
            "Medical Observation",
            "Neurology",
            "Neurology Observation",
            "Neurosurgery",
            "OB/GYN",
            "Orthopedics",
            "Pediatrics",
            "Psychiatry",
            "Pulmonary",
            "Rehabilitation",
            "Substance Abuse",
            "Surgical Observation",
            "Telemetry",
            "Transplantion",
            "Urology"
        ];

        $scope.wards = [

            "Cardiac",
            "Emergency",
            "ICU",
            "Inpatient Unit",
            "Long Term Care",
            "Med-Surg",
            "Neuro",
            "NICU",
            "OB/GYN",
            "Oncology",
            "Orthopedic",
            "Palliative Care",
            "Pediatric",
            "Portfolio IN-PT",
            "Psychiatric",
            "Rehab",
            "Restricted IN-PT",
            "Sandbox IN-PT",
            "ZZZICU"
        ];

        $scope.profs = DATA.profs;

        $scope.payMethods = [

            "Credit Card",
            "Check",
            "Cash"
        ];

        $scope.typeOfCoverage = [

            "Medicare",
            "Medicaid",
            "Campus",
            "ChampVA",
            "Group Health Plan",
            "FECA Black Lung",
            "Other"
        ];

        $scope.payCats = [

            "Category A",
            "Category B"
        ];


    /************************************\
     * This is the global save modal section
     */


        $rootScope.clearSaved = function clearSaved() {

            jQuery('#saveStatusModal').modal('hide').
                    on('hidden', function () {

                        $rootScope.isSaved = 'false';
                    });

            console.log($rootScope.isSaved);
            console.log($rootScope.isSaving);
        };


    /************************************\
     * This is the global sign and submit section
     */


        $scope.sns = DATA.sns;
        $scope.badSig = DATA.sns.badSig;


    /************************************\
     * This is the Searching section
     */


        $scope.list = DATA.list;

        if (DATA.searchTerms) {

            (function assignSearchTerms() {

                var qArray;

                $scope.searchTerms = DATA.searchTerms.replace(/\s/g, '+');

                qArray = DATA.searchTerms.split(/\s/g);

                if (DATA.startDate) {

                    $scope.query = {

                        patient: qArray[0] || ''
                    };

                    $scope.q1 = $scope.searchPtName = qArray[0] || '';

                } else {

                    $scope.query = {

                        firstName: qArray[0] || '',
                        lastName: qArray[1] || '',
                        socialSecurity: qArray[2] || ''
                    };

                    $scope.q1 = $scope.searchFirstName = qArray[0] || '';
                    $scope.q2 = $scope.searchLastName = qArray[1] || '';
                    $scope.q3 = $scope.searchSsn = qArray[2] || '';
                }

                $scope.currentStartDate = DATA.startDate;
                $scope.currentEndDate = DATA.endDate;

                $scope.searchStartDate = DATA.startDate;
                $scope.searchEndDate = DATA.endDate;

                console.log($scope.query);
            }());
        } else {

            $scope.searchTerms = '';
        }

        $scope.$on('submitQuery', function (source, locChange, type, $event) {

            var aptUrl,
                admUrl,
                startDate,
                endDate,
                ptLastName;

            if (source.targetScope.calendarSearch) {

                if (source.targetScope.calendarSearch.$invalid) {

                    console.log('Form is invalid.');

                    return false;
                }
            }

            if (type === 'pt') {

                $scope.q1 = source.targetScope.searchFirstName || '';
                $scope.q2 = source.targetScope.searchLastName || '';
                $scope.q3 = source.targetScope.searchSsn || '';

                $scope.searchTerms = $scope.q1 + '+' + $scope.q2 + '+' + $scope.q3;

                $scope.query = {

                    firstName: source.targetScope.searchFirstName || '',
                    lastName: source.targetScope.searchLastName || '',
                    socialSecurity: source.targetScope.searchSsn || ''
                };

                if (locChange) {

                    window.location = '/patients/search?origin=search&searchTerms=' + $scope.searchTerms;
                }

            }  else if (type === 'visit') {

                startDate = source.targetScope.searchStartDate;
                endDate = source.targetScope.searchEndDate || source.targetScope.searchStartDate;
                ptLastName = source.targetScope.searchPtName || '';

                if (locChange) {

                    window.location = '/calendar/day?startDate=' + startDate +
                            '&endDate=' + endDate + '&searchTerms=' + ptLastName;

                } else {

                    $scope.query = {

                        patient: ptLastName
                    };

                    $scope.currentStartDate = source.targetScope.searchStartDate;
                    $scope.currentEndDate = source.targetScope.searchEndDate;

                    $scope.$broadcast('getSearchQuery', aptUrl, admUrl, source.targetScope.searchStartDate,
                                    source.targetScope.searchEndDate);
                }
            }
        });
};