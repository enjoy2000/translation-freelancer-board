angularApp.controller('PapertaskProfileController', function($scope, $http, $timeout, $q) {
    $scope.translationTM = [];

    function init(){
        $http.get("/api/papertask/translationtm").success(function($data){
           $scope.translationTM = $data['translationTM'];
            console.log($data['translationTM']);
        }).error(function($e){
           alert('error');
        });

        $scope.updateTranslationTM = function(){
            $.each($scope.translationTM, function(){
                console.log($(this)[0].rate);
                if($(this)[0].rate){
                    $http.put('/api/papertask/translationtm', {
                        id: $(this)[0].id,
                        rate: parseInt($(this)[0].rate)
                    }).success(function(){
                        console.log('ok');
                    });
                }
            });
        };
    }
    init();
});