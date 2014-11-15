angularApp.controller('editBankInfoController', function($scope, $http){
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
    $scope.updated = false;

    function getBankInfo(){
        $http.get('/api/user/' + USER_ID + '/bank-info').success(function($data){
            if($data['bankInfo']){
                $scope.bankInfo = $data['bankInfo'];
                console.log($scope.bankInfo);
            }
        });
    }

    $scope.submit = function(){
        $('form[name=editBankInfo]').validate({
            rules: {
                paypal: {
                    required: true,
                    email: true
                },
                alipay: {
                    required: true,
                    email: true
                }
            }
        });
        var validate = $('form[name=editBankInfo]').valid();
        if(validate == true){
            if($scope.bankInfo.id > 0){  // update
                $http.put('/api/user/' + USER_ID + '/bank-info', $scope.bankInfo).success(function($data){
                    console.log($data);
                });
            }else{  // create
                $http.post('/api/user/' + USER_ID + '/bank-info', $scope.bankInfo).success(function($data){
                    console.log($data);
                });
            }
            $scope.updated = true;
        }
    }

    getBankInfo();
});