/**
 * Created by antiprovn on 10/2/14.
 */
angularApp.controller("CompaniesListController", function($scope, $http){

    function countryPlaceholder(){
        return {
            country: $scope.countries[0]
        };
    }

    /**
     * Save company
     * @param company
     */
    $scope.saveCompany = function(company){
        var $data = jQuery.extend(true, {}, company);
        $data.country = $data.country.select;
        $http.post("/api/common/company", $data)
            .success(function($data){
                jQuery("#modal-company").modal("hide");
                $scope.companies.push($data['company']);
                setModalControllerData('company', countryPlaceholder())
            });
    };

    function ready(){
        return ($scope.countries && $scope.countries.length > 0);
    }

    $scope.$watch(function(){
        return ready();
    }, function(){
        if(ready()){
            setModalControllerData('country', countryPlaceholder());
        }
    });
});