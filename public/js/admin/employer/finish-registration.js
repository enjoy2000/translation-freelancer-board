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
    $scope.operatingSystems = [];
    $scope.softwares = [];

    $scope.translationPrices = [];
    $scope.desktopPrices = [];
    $scope.interpretingPrices = [];

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

    function updateUserInfoPriceData(){
        var $info = $scope.freelancerInfo;
        $info.TranslationCatTools = findOptions($scope.catTools, $info.TranslationCatTools);
        $info.TranslationSpecialisms = findOptions($scope.specialisms, $info.TranslationSpecialisms);
        $info.DesktopCatTools = findOptions($scope.catTools, $info.DesktopCatTools);
        $info.DesktopOperatingSystems = findOptions($scope.operatingSystems, $info.DesktopOperatingSystems);
        $info.InterpretingSpecialisms = findOptions($scope.specialisms, $info.InterpretingSpecialisms);
    }


    function initModal(){
        setModalControllerData('languages', $scope.languages);
        setModalControllerData('services', $scope.services);
        setModalControllerData('softwares', $scope.softwares);
    }


    /** end mapping function **/
    function init($userId){
        $http.get("/api/user/" + $userId + "")
            .success(function($data){
                $scope.userInfo = $data['user'];
                if($scope.countries.length){
                    $scope.userInfo.country = findOption($scope.countries, $scope.userInfo.country);
                }
            });
        $http.get("/api/user/" + $userId + "/employer")
            .success(function($data){
                $scope.employerInfo = $data['employer'];
                $scope.translationPrices = $data['translationPrices'];
                $scope.interpretingPrices = $data['interpretingPrices'];
                $scope.desktopPrices = $data['desktopPrices'];

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
                    });
            });

        $http.get("/api/common/country")
            .success(function($data){
                $scope.countries = $data['countries'];
                if($scope.userInfo.country){
                    $scope.userInfo.country = findOption($scope.countries, $scope.userInfo.country);
                }
            });
    };

    init(USER_ID);

    /**
     * Submit the form
     */
    $scope.submit = function(){
        var form = jQuery("#UpdateInfoController form");
        form.validate().settings.ignore = ":disabled,:hidden";
        if(form.valid()){

            var requestInfo = $http.put("/api/user/" + $scope.userInfo.id, $scope.userInfo);
            // wait all done
            $q.all([requestInfo])
                .then(function(result){
                    // TODO: change this callback
                    alert("Success update all");
                });
        }
    };

});