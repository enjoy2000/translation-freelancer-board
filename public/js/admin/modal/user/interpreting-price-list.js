/**
 * Created by antiprovn on 10/1/14.
 */
angularApp.controller("InterpretingPriceListController", function($scope, $http){
    function interpretingPricePlaceholder(){
        return {
            sourceLanguage: $scope.languages[0],
            targetLanguage: $scope.languages[0],
            service: $scope.services[0]
        };
    }

    /**
     * Save interpreting price from modal
     * @param interpretingPrice
     */
    $scope.saveInterpretingPrice = function(interpretingPrice){
        var interpretingPriceData = {
            userId: $scope.userInfo.id,
            sourceLanguageId: interpretingPrice.sourceLanguage.id,
            targetLanguageId: interpretingPrice.targetLanguage.id,
            serviceId: interpretingPrice.service.id,
            priceDay: interpretingPrice.priceDay,
            priceHalfDay: interpretingPrice.priceHalfDay
        }
        $http.post("/api/user/" + $scope.userInfo.id + "/interpretingPrice", interpretingPriceData)
            .success(function($data){
                jQuery("#modal-interpreting").modal("hide");
                $scope.interpretingPrices.push($data['interpretingPrice']);
                setModalControllerData('interpretingPrice', interpretingPricePlaceholder())
            });
    };
    $scope.deleteInterpretingPrice = function($index){
        var interpretingPrice = $scope.interpretingPrices[$index];
        $http.delete("/api/user/" + $scope.userInfo.id + "/interpretingPrice/" + interpretingPrice.id)
            .success(function(){
                $scope.interpretingPrices.splice($index, 1);
            });
    };

    $scope.$watch(function(){
        return $scope.languages && $scope.languages.length > 0;
    }, function(){
        setModalControllerData('interpretingPrice', interpretingPricePlaceholder());
    });
});