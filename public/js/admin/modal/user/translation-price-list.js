/**
 * Created by antiprovn on 10/1/14.
 */
angularApp.controller("TranslationPriceListController", function($scope, $http){

    function translationPricePlaceholder(){
        return {
            sourceLanguage: $scope.languages[0],
            targetLanguage: $scope.languages[0],
            userId: $scope.userInfo.id
        };
    }

    /**
     * Save translation price from modal
     * @param translationPrice
     */
    $scope.saveTranslationPrice = function(translationPrice){
        var translationPriceData = {
            userId: $scope.userInfo.id,
            sourceLanguageId: translationPrice.sourceLanguage.id,
            targetLanguageId: translationPrice.targetLanguage.id,
            price: translationPrice.price
        }
        $http.post("/api/user/" + $scope.userInfo.id + "/translationPrice", translationPriceData)
            .success(function($data){
                jQuery("#modal-translation").modal("hide");
                $scope.translationPrices.push($data['translationPrice']);
                setModalControllerData('translationPrice', translationPricePlaceholder())
            });
    };

    $scope.deleteTranslationPrice = function($index){
        var translationPrice = $scope.translationPrices[$index];
        $http.delete("/api/user/" + $scope.userInfo.id + "/translationPrice/" + translationPrice.id)
            .success(function(){
                $scope.translationPrices.splice($index, 1);
            });
    };

    $scope.$watch(function(){
        return $scope.languages && $scope.languages.length > 0;
    }, function(){
        setModalControllerData('translationPrice', translationPricePlaceholder());
    });
});