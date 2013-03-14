/**
 * This are all the controllers for the patient view.
 * User: Justin Lowery
 * Date: 7/28/12
 * Time: 6:24 PM
 */

PAS.ctrlr.patient = function ctrlrDotPatient($scope, $http, $q, $filter, $timeout, $rootScope, dataServices,
                                             ptServices) {

    "use strict";


    /************************************\
     * This is the patient section
     */

    function checkForValues(inputToCheck, selectedValue) {

        var value;

        if (inputToCheck || selectedValue === "Yes") {

            value = 'true';

        } else {

            value = 'false';
        }

        return value;
    }

    // Assign input widths to inputs parents
    $scope.eventFormInputWidth = 'span12';
    $scope.eventFormTextareaWidth = 'span12';

    if (DATA.reg) {

        $scope.pt = DATA.reg.pt;
        $scope.pg = DATA.reg.pg;
        $scope.md = DATA.reg.md;
        $scope.gr = DATA.reg.gr;
        $scope.ins = DATA.reg.ins;

        if (DATA.reg.pt.uniqueId) {

            $scope.pt.age = DATA.reg.pt.dateOfBirth ? ptServices.calcAge(DATA.reg.pt.dateOfBirth) : null;
        }

        if (DATA.reg.pg) {

            // Form controls for showing/hiding sections
            $scope.haveGuardianship = checkForValues($scope.pg.p1.firstName, $scope.haveGuardianship);
        }

        if (DATA.reg.ins) {

            $scope.hasPrimary = checkForValues($scope.ins.primary.relationship, $scope.hasPrimary);
            $scope.hasSecondary = checkForValues($scope.ins.secondary.relationship, $scope.hasSecondary);
            $scope.hasTertiary = checkForValues($scope.ins.tertiary.relationship, $scope.hasTertiary);
        }

        // "Use Same As Above" functions for Guarontor "Self"
        $scope.isGuarontorSelf = function isGuarantorSelf() {

            if ($scope.gr.relationship === "Self" || $scope.pt.age < 18) {

                $scope.gr.firstName = $scope.pt.firstName;
                $scope.gr.lastName = $scope.pt.lastName;
                $scope.gr.streetAddress = $scope.pt.streetAddress;
                $scope.gr.apptNum = $scope.pt.apptNum;
                $scope.gr.city = $scope.pt.city;
                $scope.gr.state = $scope.pt.state;
                $scope.gr.zip = $scope.pt.zip;
            }
        };

        // "Use Same As Above" functions for Policy Holder for "Self"
        $scope.isHolderSelf = function isHolderSelf(type) {

            if ($scope.ins[type].relationship === "Self") {

                $scope.ins[type].notSelf.firstName = $scope.pt.firstName;
                $scope.ins[type].notSelf.lastName = $scope.pt.lastName;
                $scope.ins[type].notSelf.dateOfBirth = $scope.pt.dateOfBirth;
                $scope.ins[type].notSelf.sex = $scope.pt.sex;
                $scope.ins[type].notSelf.socialSecNumb = $scope.pt.socialSecurity;
                $scope.ins[type].notSelf.homePhone = $scope.pt.homePhone;
                $scope.ins[type].notSelf.streetAddress = $scope.pt.streetAddress;
                $scope.ins[type].notSelf.apptNum = $scope.pt.apptNum;
                $scope.ins[type].notSelf.city = $scope.pt.city;
                $scope.ins[type].notSelf.state = $scope.pt.state;
                $scope.ins[type].notSelf.zip = $scope.pt.zip;
                $scope.ins[type].notSelf.employer = $scope.pt.employer;
                $scope.ins[type].notSelf.employerPhone = $scope.pt.employerPhone;
            }
        };
    }


    /************************************\
     * This is the appointment section
     */


    if (DATA.apt) {

        $scope.ptInfo = DATA.apt.ptInfo;
        $scope.md = DATA.apt.md;
        $scope.aptDetails = DATA.apt.aptDetails;
        $scope.status = DATA.apt.status;
        $scope.notes = DATA.apt.notes;

        $scope.newApt = function () {

            $scope.ptInfo = DATA.newApt.ptInfo;
            $scope.md = DATA.newApt.md;
            $scope.aptDetails = DATA.newApt.aptDetails;
            $scope.status = DATA.newApt.status;
            $scope.notes = DATA.newApt.notes;

            DATA.apt = DATA.newApt;
        };
    }


    /************************************\
     * This is the admission section
     */


    if (DATA.adm) {

        $scope.ptInfo = DATA.adm.ptInfo;
        $scope.aptDetails = DATA.adm.aptDetails;
        $scope.status = DATA.adm.status;
        $scope.notes = DATA.adm.notes;
        $scope.admDetails = DATA.adm.admDetails;
        $scope.md = DATA.adm.md;
        $scope.location = DATA.adm.location;

        $scope.newAdm = function () {

            $scope.ptInfo = DATA.newAdm.ptInfo;
            $scope.aptDetails = DATA.newAdm.aptDetails;
            $scope.status = DATA.newAdm.status;
            $scope.notes = DATA.newAdm.notes;
            $scope.admDetails = DATA.newAdm.admDetails;
            $scope.md = DATA.newAdm.md;
            $scope.location = DATA.newAdm.location;

            DATA.adm = DATA.newAdm;
        };
    }


    /************************************\
     * This is the aptList section
     */


    $scope.futureApts = function (item) {

        var status;

        if (item.ptStatus === 'Scheduled') {

            status = 'Scheduled';

        } else if (item.ptStatus === 'Checked-In') {

            status = 'Checked-In';

        } else {

            return;
        }

        return item.ptStatus === status;
    };

    $scope.pastApts = function (item) {

        var status;

        if (item.ptStatus === 'Checked-Out') {

            status = 'Checked-Out';

        } else if (item.ptStatus === 'Canceled') {

            status = 'Canceled';

        } else if (item.ptStatus === 'No-Show') {

            status = 'No-Show';

        } else {

            return;
        }

        return item.ptStatus === status;
    };

    $scope.apts = DATA.aptList;


    /************************************\
     * This is the admList section
     */


    $scope.admt = function (item) {

        return item.ptStatus === 'Admitted';
    };
    $scope.dc = function (item) {

        return item.ptStatus === 'Discharged';
    };

    $scope.adms = DATA.admList;


    /************************************\
     * This is the out-patient billing section
     */

    if (DATA.opSbList) {

        $scope.urlNewApt = '/patients/op-superbills?patientId=' + $scope.pt.uniqueId +
                '&origin=search&data=appointment&data2=superbill&searchTerms=' + $scope.searchTerms + '&stage=new';

        $scope.sbs = DATA.opSbList;
        $scope.claims = DATA.opClaimList;

        $scope.opSb = DATA.opSb;
        $scope.opSb.opSbDetails = DATA.opSb.opSbDetails || {};

        $scope.claim = DATA.opClaim;

        if ($scope.opSb.opSbDetails.opSbId) {

            $scope.aptChosen = 'true';

        } else {

            $scope.aptChosen = 'false';
        }
    }

    $scope.getNonSbApts = function getNonSbApts(ptId) {

        var url = '/opsbasync/getaptswithnoopsb?patientId=' + ptId;

        dataServices.fn.query(url).then(function (returned) {

            $scope.apts = returned.data;
        });
    };


    /************************************\
     * This is the out-patient claim section
     */

    if (DATA.opClList) {

        $scope.claims = DATA.opClList;

        $scope.opCl = DATA.opCl;
        $scope.opSb = DATA.opSb;
        $scope.opCl.opClDetails = DATA.opCl.opClDetails || {};

        $scope.claim = DATA.opCl;
    }

    $scope.getNonClSbs = function getNonClSbs(ptId) {

        var url = '/opclasync/getsbswithnoopcl?patientId=' + ptId;

        dataServices.fn.query(url).then(function (returned) {

            $scope.sbs = returned.data;
        });
    };


    /************************************\
     * This is the save patient data function
     */


    // Warning blocks

    $scope.requiredCheck = $scope.patientInfo ? $scope.patientInfo.$error.required : false;
    $scope.patternCheck = $scope.patientInfo ? $scope.patientInfo.$error.pattern : false;

    $scope.save = function (type, form) {

        if ($rootScope.invalidDate) {

            return;
        }

        console.log($rootScope.isSaved);
        console.log($rootScope.isSaving);

        $rootScope.isSaving = 'true';

        console.log($rootScope.isSaved);
        console.log($rootScope.isSaving);

        form = $scope[form];

        if (form.$valid) {

            dataServices.fn.save(type).then(function (returned) {

                var url;

                $rootScope.isSaving = 'false';
                $rootScope.isSaved = 'true';

                console.log($rootScope.isSaved);
                console.log($rootScope.isSaving);

                $timeout(function () { $rootScope.clearSaved(); }, 1000);

                console.log('Submission Complete');

                // TODO: Push this data to the scope rather than query the DB

                if (type === 'apt' || type === 'adm') {

                    console.log('Returning id - ' + parseInt(returned.data, 10) + ' - for newly created event.');

                    $scope[type + 'Details'][type + 'Id'] = parseInt(returned.data, 10);

                    $scope[type + 'Details'][type + 'Id'] = parseInt(returned.data, 10);

                    url = '/' + type.toLowerCase() + 'async/get' + type.toLowerCase() +
                            's?patientId=' + $scope.pt.uniqueId;

                    dataServices.fn.query(url).then(function (returned) {

                        $scope[type + 's'] = returned.data;
                    });

                    $scope.aptChosen = 'true';

                } else if (type === 'opSb' || type === 'opCl') {

                    console.log(returned.data);

                    $scope[type][type + 'Details'][type + 'Id'] = parseInt(returned.data, 10);

                } else if (type === 'accItem') {

                    console.log('Returning id - ' + parseInt(returned.data, 10) + ' - for newly created event.');

                    $scope[type][type + 'Id'] = parseInt(returned.data, 10);

                    $scope[type][type + 'Id'] = parseInt(returned.data, 10);

                    url = '/' + type.toLowerCase() + 'async/get' + type.toLowerCase() +
                        's?patientId=' + $scope.pt.uniqueId;

                    dataServices.fn.query(url).then(function (returned) {

                        var length = returned.data.length;

                        $scope[type + 's'] = returned.data.accItems;
                        $scope.accountBalance = returned.data.currentBalance;
                    });

                    $scope.aptChosen = 'true';
                }

            });

        } else {

            console.log('Please fill in all required fields.');
        }
    };


    /************************************\
     * This is the submit patient data function
     */


    $scope.submit = function (type, form, form2) {

        var subArray;

        form = $scope[form];
        form2 = $scope[form2];

        DATA.sns.subType = type;
        DATA.sns.uniqueId = $scope.pt.uniqueId;

        subArray = [DATA.sns, DATA[type]];

        dataServices.fn.save(type).then(function (returned) {

            if (type === 'apt' || type === 'adm') {

                $scope[type + 'Details'][type + 'Id'] = parseInt(returned.data, 10);

                var url = '/' + type.toLowerCase() + 'async/get' + type.toLowerCase() +
                        's?patientId=' + $scope.pt.uniqueId;

                dataServices.fn.query(url).then(function (returned) {

                    $scope[type + 's'] = returned.data;
                });

            } else if (type === 'opSb') {

                $scope[type][type + 'Details'][type + 'Id'] = parseInt(returned.data, 10);
            }

            if (!(form.$invalid) && !(form2.$invalid)) {

                dataServices.fn.submit(subArray, type).then(function (returned) {

                    if (parseInt(returned.data, 10) !== 0) {

                        console.log("Submission complete.");

                        jQuery('.modal').modal('hide');

                    } else {

                        $scope.badSig = DATA.sns.badSig;
                    }
                });
            }
        });
    };


    /************************************\
     * This is the register patient function
     */


    $scope.register = function (type, form) {

        dataServices.fn.register(type, $scope[form]);
    };


    /************************************\
     * Diag and Proc Code Section
     */


    $scope.icdTypes = ['ICD10', 'ICD9'];
    $scope.icdType = 'ICD10';

    $scope.$on('searchCodes', function (localScope, keys, type, icd) {

        var url;

        keys = encodeURI(keys);
        icd = encodeURI(icd);

        url = '/' + type + 'codesasync/search?q=' + keys + '&type=' + icd;

        console.log(url);

        dataServices.fn.query(url).then(function (returned) {

            //console.log(returned.data);

            $scope[type + 'List'] = returned.data;
        });
    });

    $scope.aptSearch = function (terms) {

        console.log(terms);

        $scope.aptQuery = terms;
    };

    $scope.selectCode = function (type) {

        console.log('select code');

        if (type === 'proc' || type === 'diag') {

            $scope.opSb[type + 'Codes'] = $scope.opSb[type + 'Codes'] || [];

            $scope.opSb[type + 'Codes'].push(this[type]);

        } else if (type === 'mod') {

            console.log(this);

            $scope.opSb.procCodes[$scope.procToMod].modifier = this.mod.code;

            if ($scope.opCl) {

                $scope.opCl.procCodes[$scope.procToMod].modifier = this.mod.code;
            }
        }

        jQuery('.modal').modal('hide');
    };

    $scope.removeCode = function (type, index) {

        $scope.opSb[type + 'Codes'].splice(index, 1);
    };

    $scope.reorderCodes = function (array) {

        function compareItems(a, b) {

            return a.order - b.order;
        }

        array.sort(compareItems);
    };

    $scope.initAndLinkMod = function (index) {

        $scope.procToMod = index;

        dataServices.fn.query('/modifiersasync/get').then(function (returned) {

            // console.log(returned.data);

            $scope.modList = returned.data;
        });
    };


    /************************************\
     * These are the Post to Account Functions
     */


    $scope.postTypes = ['Bill', 'Payment', 'Adjustment', 'Refund'];

    $scope.accountBalance = '0.00';

    $scope.payors = [];

    $scope.previewBill = function previewBill() {

        dataServices.fn.query('/accitemasync/getopclobjects?opClId=' + this.item.opClId).
            then(function (returned) {

                $scope.aptDetails = returned.data.apt.aptDetails;
                $scope.opSb = returned.data.opSb;
                $scope.opCl = returned.data.opCl;
            });
    };

    $scope.selectPostType = function selectPostType() {

        if ($scope.accItem.postType === 'Bill') {

            $scope.billReq = true;

        } else if ($scope.accItem.postType === 'Payment') {

            $scope.payReq = true;

        } else if ($scope.accItem.postType === 'Adjustment') {

            $scope.adjReq = true;

        } else if ($scope.accItem.postType === 'Refund') {

            $scope.refReq = true;

        }
    };

    if (DATA.accItems) {

        dataServices.fn.query('/accitemasync/getaccitems?patientId=' + $scope.pt.uniqueId).
                then(function (returned) {

                var length = returned.data.length;

                $scope.accItems = returned.data.accItems;
                $scope.accountBalance = returned.data.currentBalance;
            });
    }

    if (DATA.accItem) {

        $scope.accItem = DATA.accItem;
        $scope.accItem.uniqueId = $scope.pt.uniqueId;
    }

    if ($scope.ins) {

        $scope.getPayors = (function getPayors() {

            var payors = ['Patient', $scope.ins.primary.comp, $scope.ins.secondary.comp, $scope.ins.tertiary.comp],
                iter = 0,
                length = payors.length;

            for (iter; iter < length; iter++) {

                if (payors[iter] !== '') {

                    $scope.payors.push(payors[iter]);
                }
            }

            console.log($scope.payors);
        }());
    }

    $scope.getPtClaims = function getPtClaims(ptId) {

        var url = '/opclasync/getopclbypt?patientId=' + $scope.pt.uniqueId;

        dataServices.fn.query(url).then(function (returned) {

            $scope.claims = returned.data;
        });
    };

    $scope.selectCl = function selectCl() {

        console.log(this);

        $scope.accItem.opClId = this.opCl.opClId;
        $scope.accItem.claimNum = this.opCl.claimNum;
        $scope.accItem.payor = this.opCl.billTo;
        $scope.accItem.totalProcedures = this.opCl.procCount;
        $scope.accItem.debit = this.opCl.totalCharges;

        jQuery('.modal').modal('hide');
    };


    /************************************\
     * This is the selecting an event function
     */


    $scope.$on('useTimeSlot', function (localScope, date, time, md) {

        $scope.aptDetails.startDate = date;
        $scope.aptDetails.startTime = time;
        $scope.md.clinic = md;

    });

    $scope.selectApt = function selectApt(_aptId, claim) {

        var aptId = _aptId || this.apt.aptId,
            url =  '/aptasync/getapt?aptId=' + aptId;

        dataServices.fn.query(url).then(function (returned) {

            DATA.apt = returned.data;

            $scope.ptInfo = returned.data.ptInfo;
            $scope.md = returned.data.md;
            $scope.aptDetails = returned.data.aptDetails;
            $scope.status = returned.data.status;
            $scope.notes = returned.data.notes;

            if (!claim) {
                $scope.opSb.opSbDetails.authNotes = returned.data.notes.authorization;
                $scope.opSb.opSbDetails.aptId = returned.data.aptDetails.aptId;
            }

            $scope.aptChosen = 'true';

            $scope.urlEditApt = '/patients/op-billing?patientId=' + $scope.pt.uniqueId +
                    '&aptId=' + $scope.aptDetails.aptId +
                    '&origin=search&data=appointment&data2=superbill&searchTerms=' + $scope.searchTerms +
                    '&stage=new';

            if (!claim) {
                jQuery('.modal').modal('hide');
            }
        });
    };

    $scope.selectSb = function selectSb() {

        var aptUrl =  '/aptasync/getapt?aptId=' + this.opSb.aptId,
            sbUrl =  '/opsbasync/getopsb?opSbId=' + this.opSb.opSbId;

        console.log(this.opSb.opSbId);

        $scope.selectApt(this.opSb.aptId, true);

        dataServices.fn.query(sbUrl).then(function (returned) {

            console.log(returned);

            $scope.opSb = returned.data;
            $scope.opCl.opClDetails.opSbId = returned.data.opSbDetails.opSbId;
            $scope.opCl.procCodes = $scope.opSb.procCodes;
            $scope.opCl.diagCodes = $scope.opSb.diagCodes;

            jQuery('.modal').modal('hide');
        });
    };
};