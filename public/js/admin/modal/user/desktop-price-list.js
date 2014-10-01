/**
 * Created by antiprovn on 10/1/14.
 */
angularApp.controller("DesktopPriceListController", function($scope, $http){

    function desktopPricePlaceholder(){
        return {
            language: $scope.languages[0],
            software: $scope.softwares[0]
        };
    }

    /**
     * Save desktop price from modal
     * @param desktopPrice
     */
    $scope.saveDesktopPrice = function(desktopPrice){

        var desktopPriceData = {
            userId: $scope.userInfo.id,
            languageId: desktopPrice.language.id,
            softwareId: desktopPrice.software.id,
            priceMac: desktopPrice.priceMac,
            pricePc: desktopPrice.pricePc,
            priceHourMac: desktopPrice.priceHourMac,
            priceHourPc: desktopPrice.priceHourPc
        }
        $http.post("/api/user/" + $scope.userInfo.id + "/desktopPrice", desktopPriceData)
            .success(function($data){
                jQuery("#modal-dtp").modal("hide");
                $scope.desktopPrices.push($data['desktopPrice']);
                setModalControllerData('desktopPrice', desktopPricePlaceholder())
            });
    };

    $scope.deleteDesktopPrice = function($index){
        var desktopPrice = $scope.desktopPrices[$index];
        $http.delete("/api/user/" + $scope.userInfo.id + "/desktopPrice/" + desktopPrice.id)
            .success(function(){
                $scope.desktopPrices.splice($index, 1);
            });
    };

    $scope.$watch(function(){
        return $scope.languages && $scope.languages.length > 0;
    }, function(){
        setModalControllerData('desktopPrice', desktopPricePlaceholder());
    });
});