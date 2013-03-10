PHI.controller('Ctrlr', ['$scope', 'dataService', function ($scope, dataService) {

        $scope.sexes = ['Male', 'Female', 'Other'];

        $scope.states = [

            {value: "AL", text: "Alabama"},
            {value: "AK", text: "Alaska"},
            {value: "AZ", text: "Arizona"},
            {value: "AR", text: "Arkansas"},
            {value: "CA", text: "California"},
            {value: "CO", text: "Colorado"},
            {value: "VT", text: "Vermont"},
            {value: "VA", text: "Virginia"},
            {value: "WA", text: "Washington"},
            {value: "WV", text: "West Virginia"},
            {value: "WI", text: "Wisconsin"},
            {value: "WY", text: "Wyoming"}
        ];

        $scope.save = function () {

            dataService.set($scope.user);
	        $scope.savedData = dataService.get();
        };
    }]);