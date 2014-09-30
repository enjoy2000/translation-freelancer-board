/**
 * Created by antiprovn on 9/27/14.
 */
angularApp.run(function($rootScope){
    $(document).ready(function(){
        $('.summernote').summernote();
    });
    var edit = function() {
        $('.click2edit').summernote({focus: true});
    };
    var save = function() {
        var aHTML = $('.click2edit').code(); //save HTML If you need(aHTML: array).
        $('.click2edit').destroy();
    };
});
angularApp.controller('UpdateInfoController', function($scope, $http, $timeout, $q){
    $scope.catTools = [];
    $scope.countries = [];
    $scope.languages = [];

    $scope.translationPrice = {};
    $scope.translationPrices = [];

    $scope.userInfo = {
        "city": null,
        "country": {
            "select": null
        },
        "currency": null,
        "createdTime": null,
        "email": null,
        "firstName": null,
        "gender": false,
        "group": null,
        "id": null,
        "isActive": null,
        "lastLogin": null,
        "lastName": null,
        "phone": null,
        "profileUpdated": null
    };

    /**
     * Mark resource active params
     */
    function generateActiveResources(){
        $scope.userInfo.resources = $scope.userInfo.resources;
        for(var i = 0; i < $scope.userInfo.resources.length; i++){
            $scope.resource_active[$scope.userInfo.resources[i]] = 'active';
        }
    }

    function initModal(){
        setModalControllerData('desktopPrice', {});
        setModalControllerData('interpretingPrice', {});
        setModalControllerData('translationPrice', {});

        setModalControllerData('languages', $scope.languages);
        setModalControllerData('services', $scope.services);
        setModalControllerData('softwares', $scope.softwares);
    }

    /** end mapping function **/

    $http.get("/api/user/info")
        .success(function($data){
            $scope.userInfo = $data['user'];
            if($scope.countries.length){
                $scope.userInfo.country = findOption($scope.countries, $scope.userInfo.country);
            }
            generateActiveResources();

            $http.get("/api/user/resource")
                .success(function($data){
                    $scope.resources = $data['resources'];
                });

            $http.get("/api/user/priceData")
                .success(function($data){
                    /** map data **/
                    $scope.languages = $data['languages'];
                    $scope.services = $data['services'];
                    $scope.softwares = $data['softwares'];

                    initModal();
                });
        });

    $http.get("/api/common/country")
        .success(function($data){
            $scope.countries = $data['countries'];
            if($scope.userInfo.country){
                $scope.userInfo.country = findOption($scope.countries, $scope.userInfo.country);
            }
        });

    /**
     * Submit the form
     */
    $scope.submit = function(){
        var requestInfo = $http.put("/api/user/" + $scope.userInfo.id + "/info/", $scope.userInfo);

        // wait all done
        $q.all([requestInfo]).then(function(result){
            // TODO: change this callback
            console.log(result);
            alert("Success update all");
        });
    };

    /**
     * Display activate class
     */
    $scope.active_class = function(a, b){
        return a == b ? 'active' : '';
    };
});