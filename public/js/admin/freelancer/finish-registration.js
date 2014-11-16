/**
 * Created by antiprovn on 9/27/14.
 */
angularApp.controller('UpdateInfoController', function($scope, $http, $timeout, $q){
    $scope.catTools = [];
    $scope.countries = [];
    $scope.languages = [];
    $scope.resources = [];
    $scope.softwares = [];
    $scope.companies = [];

    $scope.operatingSystems = [];
    $scope.specialisms = [];

    $scope.desktopPrices = [];
    $scope.interpretingPrices = [];
    $scope.resource_active = {};
    $scope.translationPrices = [];

    $scope.user = $scope.userInfo = {
        "city": null,
        "country": null,
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
    };
    $scope.freelancer = {};

    /**
     * Mark resource active params
     */
    function generateActiveResources(){
        $scope.freelancer.Resources = $scope.freelancer.Resources;
        for(var i = 0; i < $scope.freelancer.Resources.length; i++){
            $scope.resource_active[$scope.freelancer.Resources[i]] = 'active';
        }
    }

    function findResources($resourceGroups, $ids){
        var resources = [];
        for(var i = 0; i < $resourceGroups.length; i++){
            for(var j = 0; j < $resourceGroups[i].resources.length; j++){
                var resource = $resourceGroups[i].resources[j];
                if($ids.indexOf(resource.id) != -1){
                    resources.push(resource);
                }
            }
        }
        return resources;
    }

    function updateFreelancerSkillData(){
        var $info = $scope.freelancer;
        $info.TranslationCatTools = findOptions($scope.catTools, $info.TranslationCatTools);
        $info.TranslationSpecialisms = findOptions($scope.specialisms, $info.TranslationSpecialisms);
        $info.DesktopCatTools = findOptions($scope.catTools, $info.DesktopCatTools);
        $info.Resources = findResources($scope.resources, $info.Resources);
        $info.DesktopOperatingSystems = findOptions($scope.operatingSystems, $info.DesktopOperatingSystems);
        $info.InterpretingSpecialisms = findOptions($scope.specialisms, $info.InterpretingSpecialisms);
    }

    function initModal(){
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
    function init($userId){
        $http.get("/api/user/" + $userId + "")
            .success(function($data){
                $scope.user = $scope.userInfo = $data['user'];
                $scope.translationPrices = $data['translationPrices'];
                $scope.interpretingPrices = $data['interpretingPrices'];
                $scope.desktopPrices = $data['desktopPrices'];
                if($scope.countries.length){
                    $scope.user.country = findOption($scope.countries, $scope.user.country);
                }

                if($scope.user.group.isFreelancer){
                    loadFreelancerData();
                } else if ($scope.user.group.isEmployer) {
                    loadEmployerData();
                } else {
                    loadAdminData();
                }
            });

        var priceDataRequest = $http.get("/api/user/priceData")
            .success(function($data){
                $scope.languages = $data['languages'];
                $scope.services = $data['services'];
                $scope.softwares = $data['softwares'];

                initModal();
            });

        $http.get("/api/common/country")
            .success(function($data){
                $scope.countries = $data['countries'];
                setModalControllerData('countries', $scope.countries);
                if($scope.user.country){
                    $scope.user.country = findOption($scope.countries, $scope.user.country);
                }
            });
    };

    function loadFreelancerData(){

        $http.get("/api/user/" + $scope.user.id + "/freelancer")
            .success(function($data){
                $scope.freelancer = $data['freelancer'];
                generateActiveResources();

                var priceDataRequest = $http.get("/api/user/freelancerData")
                    .success(function($data){
                        /** map data **/
                        $scope.catTools = $data['catTools'];
                        $scope.operatingSystems = $data['operatingSystems'];
                        $scope.specialisms = $data['specialisms'];
                        $scope.resources = $data['resources'];
                        rebuildMultiSelect();
                        updateFreelancerSkillData();
                    });
            });
    }

    function loadEmployerData(){

        $http.get("/api/user/" + $scope.user.id + "/employer")
            .success(function($data){
                $scope.employerInfo = $data['employer'];
                var priceDataRequest = $http.get("/api/user/employerData")
                    .success(function($data){
                    });
            });
        $http.get("/api/common/company")
            .success(function($data){
                $scope.companies = $data['companies'];
            });
    }

    function loadAdminData(){

        $http.get("/api/user/" + $scope.user.id + "/freelancer")
            .success(function($data){
                $scope.freelancer = $data['freelancer'];
                generateActiveResources();

                var priceDataRequest = $http.get("/api/user/freelancerData")
                    .success(function($data){
                        /** map data **/
                        $scope.catTools = $data['catTools'];
                        $scope.operatingSystems = $data['operatingSystems'];
                        $scope.specialisms = $data['specialisms'];
                        rebuildMultiSelect();
                    });

                var resourceRequest = $http.get("/api/user/resource")
                    .success(function($data){
                        $scope.resources = $data['resources'];
                    });
                $q.all([priceDataRequest, resourceRequest])
                    .then(function(){
                        updateFreelancerSkillData();
                    });
            });
    }

    init(USER_ID);

    function updateFreelancer(){
        return $http.put("/api/user/" + $scope.user.id + "/freelancer/" + $scope.freelancer.id, {
            'DesktopCatTools': getIds($scope.freelancer.DesktopCatTools),
            'DesktopOperatingSystems': getIds($scope.freelancer.DesktopOperatingSystems),
            'InterpretingSpecialisms': getIds($scope.freelancer.InterpretingSpecialisms),
            'Resources': getIds($scope.freelancer.Resources),
            'TranslationCatTools': getIds($scope.freelancer.TranslationCatTools),
            'TranslationSpecialisms': getIds($scope.freelancer.TranslationSpecialisms)
        });
    }

    function updateEmployer(){
        return $http.put("/api/user/" + $scope.user.id + "/employer/" + $scope.employerInfo.id, $scope.employerInfo);
    }

    $scope.submitGroup = function(){
        if($scope.user.group.isFreelancer){
            return updateFreelancer();
        } else if ($scope.user.group.isEmployer){
            return updateEmployer();
        } else {
            return updateAdmin();  // TODO: implement this
        }
    }

    /**
     * Submit the form
     */
    $scope.submit = function(){

        var requestInfo = $http.put("/api/user/" + $scope.user.id, $scope.user);
        var requestGroup = $scope.submitGroup();

        // wait all done
        $q.all([requestGroup, requestInfo])
            .then(function(result){
                location.href = "/admin/dashboard";
            });
    };

    /**
     * Toggle resource
     */
    $scope.toggleResource = function($id){
        console.log($scope.freelancer.Resources);
        var $index = $scope.freelancer.Resources.indexOf($id);
        if($index == -1){
            $scope.freelancer.Resources.push($id);
        } else {
            $scope.freelancer.Resources.splice($index, 1);
        }
        console.log($scope.freelancer.Resources);
    };

    /**
     * Display activate class
     */
    $scope.active_class = function(a, b){
        return a == b ? 'active' : '';
    };
});