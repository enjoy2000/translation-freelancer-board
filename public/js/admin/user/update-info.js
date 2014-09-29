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
                    $scope.catTools = $data['catTools'];
                    $scope.specialisms = $data['specialisms'];
                    $scope.operatingSystems = $data['operatingSystems'];

                    updateUserInfoPriceData();

                    $timeout(function(){
                        $(".multiselect").multiselect("destroy");
                    }).then(function(){
                        $(".multiselect").multiselect();
                    });

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