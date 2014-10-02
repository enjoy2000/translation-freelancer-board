/**
 * Created by antiprovn on 9/27/14.
 */
angularApp.run(function($rootScope){
    $("#form").steps({
        bodyTag: "fieldset",
        showFinishButtonAlways: true,
        paginationPosition: "both",
        onStepChanging: function (event, currentIndex, newIndex) {
            // Always allow going backward even if the current step contains invalid fields!
            if (currentIndex > newIndex) {
                return true;
            }

            // Forbid suppressing "Warning" step if the user is to young
            if (newIndex === 3 && Number($("#age").val()) < 18) {
                return false;
            }

            var form = $(this);

            // Clean up if user went backward before
            if (currentIndex < newIndex) {
                // To remove error styles
                $(".body:eq(" + newIndex + ") label.error", form).remove();
                $(".body:eq(" + newIndex + ") .error", form).removeClass("error");
            }

            // Disable validation on fields that are disabled or hidden.
            form.validate().settings.ignore = ":disabled,:hidden";

            // Start validation; Prevent going forward if false
            return form.valid();
        },
        onStepChanged: function (event, currentIndex, priorIndex) {
            // Suppress (skip) "Warning" step if the user is old enough.
            if (currentIndex === 2 && Number($("#age").val()) >= 18) {
                $(this).steps("next");
            }

            // Suppress (skip) "Warning" step if the user is old enough and wants to the previous step.
            if (currentIndex === 2 && priorIndex === 3) {
                $(this).steps("previous");
            }
        },
        onFinishing: function (event, currentIndex) {
            var form = $(this);

            // Disable validation on fields that are disabled.
            // At this point it's recommended to do an overall check (mean ignoring only disabled fields)
            form.validate().settings.ignore = ":disabled";

            // Start validation; Prevent form submission if false
            return form.valid();
        },
        onFinished: function (event, currentIndex) {
            var form = $(this);

            angular.element('#UpdateInfoController').scope().submit();
        }
    }).validate({
        errorPlacement: function (error, element) {
            element.before(error);
        },
        rules: {
            confirm: {
                equalTo: "#password"
            }
        }
    });
});
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
    };
    $scope.freelancerInfo = {};

    /**
     * Mark resource active params
     */
    function generateActiveResources(){
        $scope.freelancerInfo.Resources = $scope.freelancerInfo.Resources;
        for(var i = 0; i < $scope.freelancerInfo.Resources.length; i++){
            $scope.resource_active[$scope.freelancerInfo.Resources[i]] = 'active';
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
        var $info = $scope.freelancerInfo;
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
                $scope.userInfo = $data['user'];
                $scope.translationPrices = $data['translationPrices'];
                $scope.interpretingPrices = $data['interpretingPrices'];
                $scope.desktopPrices = $data['desktopPrices'];
                if($scope.countries.length){
                    $scope.userInfo.country = findOption($scope.countries, $scope.userInfo.country);
                }

                if($scope.userInfo.group.isFreelancer){
                    loadFreelancerData();
                } else if ($scope.userInfo.group.isEmployer) {
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
                if($scope.userInfo.country){
                    $scope.userInfo.country = findOption($scope.countries, $scope.userInfo.country);
                }
            });
    };

    function loadFreelancerData(){

        $http.get("/api/user/" + $scope.userInfo.id + "/freelancer")
            .success(function($data){
                $scope.freelancerInfo = $data['freelancer'];
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

        $http.get("/api/user/" + $scope.userInfo.id + "/employer")
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

        $http.get("/api/user/" + $scope.userInfo.id + "/freelancer")
            .success(function($data){
                $scope.freelancerInfo = $data['freelancer'];
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
        return $http.put("/api/user/" + $scope.userInfo.id + "/freelancer/" + $scope.freelancerInfo.id, {
            'DesktopCatTools': getIds($scope.freelancerInfo.DesktopCatTools),
            'DesktopOperatingSystems': getIds($scope.freelancerInfo.DesktopOperatingSystems),
            'InterpretingSpecialisms': getIds($scope.freelancerInfo.InterpretingSpecialisms),
            'Resources': getIds($scope.freelancerInfo.Resources),
            'TranslationCatTools': getIds($scope.freelancerInfo.TranslationCatTools),
            'TranslationSpecialisms': getIds($scope.freelancerInfo.TranslationSpecialisms)
        });
    }

    function updateEmployer(){
        return $http.put("/api/user/" + $scope.userInfo.id + "/employer/" + $scope.employerInfo.id, $scope.employerInfo);
    }

    $scope.submitGroup = function(){
        if($scope.userInfo.group.isFreelancer){
            return updateFreelancer();
        } else if ($scope.userInfo.group.isEmployer){
            return updateEmployer();
        } else {
            return updateAdmin();  // TODO: implement this
        }
    }

    /**
     * Submit the form
     */
    $scope.submit = function(){

        var requestInfo = $http.put("/api/user/" + $scope.userInfo.id, $scope.userInfo);
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
        console.log($scope.freelancerInfo.Resources);
        var $index = $scope.freelancerInfo.Resources.indexOf($id);
        if($index == -1){
            $scope.freelancerInfo.Resources.push($id);
        } else {
            $scope.freelancerInfo.Resources.splice($index, 1);
        }
        console.log($scope.freelancerInfo.Resources);
    };

    /**
     * Display activate class
     */
    $scope.active_class = function(a, b){
        return a == b ? 'active' : '';
    };
});