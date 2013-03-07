
/* jasmine specs for controllers go here */
describe('Testing PAS:', function () {

    'use strict';

    beforeEach(module('PAS'));

    describe('ctrlr-global.js -', function () {
        var scope, ctrl, $httpBackend;

        beforeEach(inject(function(_$httpBackend_, $rootScope, $controller) {

            $httpBackend = _$httpBackend_;
            $httpBackend.whenGET('/preferencesasync/getmasterdataflag').respond({data: '1'});

            scope = $rootScope.$new();
            ctrl = $controller(PAS.ctrlr.global, {$scope: scope});
        }));

        it('Testing userRole and userFirstName', function () {

            expect(scope.userRole).toBe('ai_admin');
            expect(scope.userFirstName).toBe('Tester');
        });

        it('Is userRole ai_admin', function () {

            expect(scope.admin).toBe('true');
        });

        it('check to see if getUserMode has run', function () {

            scope.getUserMode.then(function (returned) {

                expect(scope.userMode).toEqual('1');
            });
        });

        it('Testing all form select values to be Arrays and > 0', function() {

            expect(Array.isArray(scope.states)).toBe(true);
            expect(scope.states.length).toBeGreaterThan(0);
            expect(Array.isArray(scope.suffixes)).toBe(true);
            expect(scope.suffixes.length).toBeGreaterThan(0);
            expect(Array.isArray(scope.sexes)).toBe(true);
            expect(scope.sexes.length).toBeGreaterThan(0);
            expect(Array.isArray(scope.maritalStatuses)).toBe(true);
            expect(scope.maritalStatuses.length).toBeGreaterThan(0);
            expect(Array.isArray(scope.employmentStatuses)).toBe(true);
            expect(scope.employmentStatuses.length).toBeGreaterThan(0);
            expect(Array.isArray(scope.relationships.parents)).toBe(true);
            expect(scope.relationships.parents.length).toBeGreaterThan(0);
            expect(Array.isArray(scope.relationships.payors)).toBe(true);
            expect(scope.relationships.payors.length).toBeGreaterThan(0);
            expect(Array.isArray(scope.mds)).toBe(true);
            expect(scope.mds.length).toBeGreaterThan(0);
            expect(Array.isArray(scope.clinics)).toBe(true);
            expect(scope.clinics.length).toBeGreaterThan(0);
            expect(Array.isArray(scope.aptLengths)).toBe(true);
            expect(scope.aptLengths.length).toBeGreaterThan(0);
            expect(Array.isArray(scope.aptTypes)).toBe(true);
            expect(scope.aptTypes.length).toBeGreaterThan(0);
            expect(Array.isArray(scope.aptStatuses)).toBe(true);
            expect(scope.aptStatuses.length).toBeGreaterThan(0);
            expect(Array.isArray(scope.admStatuses)).toBe(true);
            expect(scope.admStatuses.length).toBeGreaterThan(0);
            expect(Array.isArray(scope.admTypes)).toBe(true);
            expect(scope.admTypes.length).toBeGreaterThan(0);
            expect(Array.isArray(scope.trtSpecialties)).toBe(true);
            expect(scope.trtSpecialties.length).toBeGreaterThan(0);
            expect(Array.isArray(scope.wards)).toBe(true);
            expect(scope.wards.length).toBeGreaterThan(0);
            expect(Array.isArray(scope.profs)).toBe(true);
            expect(scope.profs.length).toBeGreaterThan(0);
            expect(Array.isArray(scope.payMethods)).toBe(true);
            expect(scope.payMethods.length).toBeGreaterThan(0);
            expect(Array.isArray(scope.payCats)).toBe(true);
            expect(scope.payCats.length).toBeGreaterThan(0);
        });

        it('Testing Sign & Sumbit models', function () {

            expect(scope.sns.profId).toBe('Professor Neehra');
            expect(scope.badSig).toBe(false);
        });

        it('Testing search list model', function () {

            expect(Array.isArray(scope.list)).toBe(true);
            expect(scope.list[0].firstName).toBe('Justin');
        });

        it('Testing query model', function () {

            expect(scope.query).toBe('');
        });

        it('Testing searchTerms model', function () {

            expect(scope.searchTerms).toBe('');
        });
    });
});
