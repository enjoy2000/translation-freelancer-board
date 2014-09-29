/**
 * Created by antiprovn on 9/27/14.
 */
angularApp.run(function($rootScope){
    $("#form").steps({
        bodyTag: "fieldset",
        showFinishButtonAlways: true,
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
    $scope.countries = [];
    $scope.desktopCatTools = [];
    $scope.desktopOperatingSystems = [];
    $scope.interpretingSpecialisms = [];
    $scope.resource_active = {};
    $scope.resources = [];
    $scope.translationCatTools = [];
    $scope.translationSpecialisms = [];
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

    function attachUserTranslationCatTools(){
        if($scope.userInfo.id && $scope.translationCatTools){
            var values = findOptions($scope.translationCatTools, $scope.userInfo.TranslationCatTools);
            $scope.userInfo.TranslationCatTools = values;
            return true;
        }
    }

    function attachUserTranslationSpecialisms(){
        if($scope.userInfo.id && $scope.translationSpecialisms){
            var values = findOptions($scope.translationSpecialisms, $scope.userInfo.TranslationSpecialisms);
            $scope.userInfo.TranslationSpecialisms = values;
            return true;
        }
    }

    function attachUserDesktopCatTools(){
        if($scope.userInfo.id && $scope.desktopCatTools){
            var values = findOptions($scope.desktopCatTools, $scope.userInfo.DesktopCatTools);
            $scope.userInfo.DesktopCatTools = values;
            return true;
        }
    }

    function attachUserDesktopOperatingSystems(){
        if($scope.userInfo.id && $scope.desktopOperatingSystems){
            var values = findOptions($scope.desktopOperatingSystems, $scope.userInfo.DesktopOperatingSystems);
            $scope.userInfo.DesktopOperatingSystems = values;
            return true;
        }
    }

    function attachUserInterpretingSpecialisms(){
        if($scope.userInfo.id && $scope.interpretingSpecialisms){
            var values = findOptions($scope.interpretingSpecialisms, $scope.userInfo.InterpretingSpecialisms);
            $scope.userInfo.InterpretingSpecialisms = values;
            return true;
        }
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

            $http.get("/api/user/translation")
                .success(function($data){
                    $scope.translationCatTools = $data['translationCatTools'];
                    $scope.translationSpecialisms = $data['translationSpecialisms'];
                    callOnce(attachUserTranslationCatTools);
                    callOnce(attachUserTranslationSpecialisms);
                    $timeout(function(){
                        jQuery("#userTranslationCatTools")
                            .add("#userTranslationSpecialisms")
                            .multiselect('rebuild');
                    }, 10);
                });
            $http.get("/api/user/desktop-publish")
                .success(function($data){
                    $scope.desktopCatTools = $data['desktopCatTools'];
                    $scope.desktopOperatingSystems = $data['desktopOperatingSystems'];
                    callOnce(attachUserDesktopCatTools);
                    callOnce(attachUserDesktopOperatingSystems);
                    $timeout(function(){
                        jQuery("#userDesktopCatTools")
                            .add("#userDesktopOperatingSystems")
                            .multiselect('rebuild');
                    }, 10);
                });
            $http.get("/api/user/interpreting")
                .success(function($data){
                    $scope.interpretingSpecialisms = $data['interpretingSpecialisms'];
                    callOnce(attachUserInterpretingSpecialisms);
                    $timeout(function(){
                        jQuery("#userInterpretingSpecialisms")
                            .multiselect('rebuild');
                    }, 10);
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

        $q.all([requestDesktop, requestInfo, requestInterpreting, requestResource, requestTranslation])
            .then(function(result){
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
});