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
    $scope.operatingSystems = [];
    $scope.resource_active = {};
    $scope.resources = [];
    $scope.specialisms = [];
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
        "profileUpdated": null,
        "resources": null,
        "DesktopCatTools": null,
        "DesktopOperatingSystems": null,
        "InterpretingSpecialisms": null,
        "TranslationCatTools": null,
        "TranslationSpecialisms": null
    }

    /**
     * Mark resource active params
     */
    function generateActiveResources(){
        $scope.userInfo.resources = $scope.userInfo.resources;
        for(var i = 0; i < $scope.userInfo.resources.length; i++){
            $scope.resource_active[$scope.userInfo.resources[i]] = 'active';
        }
    }

    function updateUserInfoPriceData(){
        var values = findOptions($scope.catTools, $scope.userInfo.TranslationCatTools);
        $scope.userInfo.TranslationCatTools = values;
        values = findOptions($scope.specialisms, $scope.userInfo.TranslationSpecialisms);
        $scope.userInfo.TranslationSpecialisms = values;
        values = findOptions($scope.catTools, $scope.userInfo.DesktopCatTools);
        $scope.userInfo.DesktopCatTools = values;
        values = findOptions($scope.operatingSystems, $scope.userInfo.DesktopOperatingSystems);
        $scope.userInfo.DesktopOperatingSystems = values;
        values = findOptions($scope.specialisms, $scope.userInfo.InterpretingSpecialisms);
        $scope.userInfo.InterpretingSpecialisms = values;
    }

    function initModal(){
        setModalControllerData('desktopPrice', {});
        setModalControllerData('interpretingPrice', {});
        setModalControllerData('translationPrice', {});

        setModalControllerData('languages', $scope.languages);
        setModalControllerData('services', $scope.services);
        setModalControllerData('softwares', $scope.softwares);
    }

    function rebuildMultiSelect(){
        $timeout(function(){
            $(".multiselect").multiselect("destroy");
        }).then(function(){
            $(".multiselect").multiselect();
        });
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
                    $scope.catTools = $data['catTools'];
                    $scope.languages = $data['languages'];
                    $scope.operatingSystems = $data['operatingSystems'];
                    $scope.specialisms = $data['specialisms'];
                    $scope.services = $data['services'];
                    $scope.softwares = $data['softwares'];

                    initModal();
                    updateUserInfoPriceData();

                    rebuildMultiSelect();
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

        var requestResource = $http.put("/api/user/" + $scope.userInfo.id + "/resource/", {
            'resources': $scope.userInfo.resources
        });

        var requestTranslation = $http.put("/api/user/" + $scope.userInfo.id + "/translation/", {
            'userTranslationCatTools': getIds($scope.userInfo.TranslationCatTools),
            'userTranslationSpecialisms': getIds($scope.userInfo.TranslationSpecialisms)
        });

        var requestDesktop = $http.put("/api/user/" + $scope.userInfo.id + "/desktop-publish/", {
            'userDesktopCatTools': getIds($scope.userInfo.DesktopCatTools),
            'userDesktopOperatingSystems': getIds($scope.userInfo.DesktopOperatingSystems)
        });

        var requestInterpreting = $http.put("/api/user/" + $scope.userInfo.id + "/interpreting/", {
            'userInterpretingSpecialisms': getIds($scope.userInfo.InterpretingSpecialisms)
        });

        // wait all done
        $q.all([requestDesktop, requestInfo, requestInterpreting, requestResource, requestTranslation])
            .then(function(result){
                // TODO: change this callback
                alert("Success update all");
            });
    };

    /**
     * Toggle resource
     */
    $scope.toggleResource = function($id){
        console.log($scope.userInfo.resources);
        var $index = $scope.userInfo.resources.indexOf($id);
        if($index == -1){
            $scope.userInfo.resources.push($id);
        } else {
            $scope.userInfo.resources.splice($index, 1);
        }
        console.log($scope.userInfo.resources);
    }

    /**
     * Display activate class
     */
    $scope.active_class = function(a, b){
        return a == b ? 'active' : '';
    };

    /**
     * Save translation price from modal
     * @param translationPrice
     */
    $scope.saveTranslationPrice = function(translationPrice){
        console.log(translationPrice);
    }

    /**
     * Save desktop price from modal
     * @param desktopPrice
     */
    $scope.saveDesktopPrice = function(desktopPrice){
        console.log(desktopPrice);
    }

    /**
     * Save interpreting price from modal
     * @param interpretingPrice
     */
    $scope.saveInterpretingPrice = function(interpretingPrice){
        console.log(interpretingPrice);
    }

    $scope.test = function(){
        console.log($scope.userInfo);
    }
});