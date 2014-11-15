angularApp.controller('viewFreelancerController', function($scope, $http, $timeout, $q){
    $scope.user = {};
    $scope.freelancerData = {};
    $scope.freelancer = {};
    $scope.resourcesType = [];
    $scope.resume = {};

    $scope.TranslationSpecialisms = [];
    $scope.TranslationCatTools = [];
    $scope.operatingSystems = [];
    $scope.DesktopCatTools = [];
    $scope.InterpretingSpecialisms = [];
    $scope.InterpretingCatTools = [];

    $scope.password = null;
    $scope.passwordChanged = 0;

    $scope.bankInfo = {
        'id': null,
        'freelancer': {},
        'paypal': null,
        'alipay': null,
        'account': null,
        'address': null,
        'city': null,
        'name': null,
        'accountNo': null,
        'swift': null,
        'routingNumber': null,
        'user_id': USER_ID
    };

    function getBankInfo(){
        $http.get('/api/user/' + USER_ID + '/bank-info').success(function($data){
            if($data['bankInfo']){
                $scope.bankInfo = $data['bankInfo'];
                console.log($scope.bankInfo);
            }
        });
    }

    // get user
    function getUser(){
        $http.get('/api/user/' + USER_ID).success(function($data){
            $scope.user = $data;
            console.log($scope.user);
        });
    }

    function getFreelancer(){
        $http.get('/api/user/' + USER_ID + '/freelancer').success(function($data){
            $scope.freelancer = $data['freelancer'];
            console.log($scope.freelancer);

            // get data after freelancer was loaded
            getFreelancerData();
            getFreelancerResume();
            getBankInfo();
        });
    }

    function getFreelancerData(){
        $http.get('/api/user/freelancer-data').success(function($data){
            $scope.freelancerData = $data;
            console.log($scope.freelancerData);
            // get resource group
            $.each($scope.freelancerData.resources, function(){
                var that = this;
                $.each(this.resources, function(){
                    if($scope.freelancer.Resources.indexOf(this.id) >= 0){
                        $scope.resourcesType[that.group.name] = 1;
                    }
                });
            });
            // get translation specialism
            $scope.TranslationSpecialisms = findOptions($scope.freelancerData.specialisms,
                $scope.freelancer.TranslationSpecialisms);
            // get desktop translation cat tools
            $scope.TranslationCatTools = findOptions($scope.freelancerData.catTools,
                $scope.freelancer.TranslationCatTools);
            // get operating systems
            $scope.operatingSystems = findOptions($scope.freelancerData.operatingSystems,
                $scope.freelancer.DesktopOperatingSystems);
            // get desktop cat tools
            $scope.DesktopCatTools = findOptions($scope.freelancerData.catTools,
                $scope.freelancer.DesktopCatTools);
            // get interpreting specialism
            $scope.InterpretingSpecialisms = findOptions($scope.freelancerData.specialisms,
                $scope.freelancer.InterpretingSpecialisms);

            console.log($scope.InterpretingSpecialisms);
        });
    }

    function getFreelancerResume(){
        $http.get('/api/user/' + USER_ID + '/resume').success(function($data){
            $scope.resume = $data['resume'];
            console.log($scope.resume);
        });
    }

    function init(){
        $scope.resetPassword = function(){
            $http.put('/api/user/' + USER_ID, {'password': $scope.password}).success(function($data){
                if($data.success == 1){
                    $scope.password = null;
                    $scope.passwordChanged = 1;
                    console.log($data);
                }
            });
        }
        getUser();
        getFreelancer();
    }
    init();
});