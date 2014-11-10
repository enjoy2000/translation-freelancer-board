angularApp.controller('viewFreelancerController', function($scope, $http, $timeout, $q){
    $scope.freelancer = [];

    // get freelancer
    function getFreelancer(){
        $http.get('/api/user/' + USER_ID).success(function($data){
            $scope.freelancer = $data;
            console.log($scope.freelancer);
        });
    }

    getFreelancer();
});