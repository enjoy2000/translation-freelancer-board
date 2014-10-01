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
    $scope.resource_active = {};
    $scope.resources = [];
    $scope.specialisms = [];
    $scope.translationPrice = {};
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

    function translationPricePlaceholder(){
        return {
            sourceLanguage: $scope.languages[0],
            targetLanguage: $scope.languages[0],
            userId: $scope.userInfo.id
        };
    }

    function desktopPricePlaceholder(){
        return {
            language: $scope.languages[0],
            software: $scope.softwares[0]
        };
    }

    function interpretingPricePlaceholder(){
        return {
            sourceLanguage: $scope.languages[0],
            targetLanguage: $scope.languages[0],
            service: $scope.services[0]
        };
    }

    function initModal(){
        setModalControllerData('desktopPrice', desktopPricePlaceholder());
        setModalControllerData('interpretingPrice', interpretingPricePlaceholder());
        setModalControllerData('translationPrice', translationPricePlaceholder());

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

    $http.get("/api/user/" + USER_ID + "")
        .success(function($data){
            $scope.userInfo = $data['user'];
            if($scope.countries.length){
                $scope.userInfo.country = findOption($scope.countries, $scope.userInfo.country);
            }
        });
    $http.get("/api/user/" + USER_ID + "/freelancer")
        .success(function($data){
            $scope.freelancerInfo = $data['freelancer'];
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

        var requestInfo = $http.put("/api/user/" + $scope.userInfo.id, $scope.userInfo);
        var requestFreelancer = $http.put("/api/user/" + $scope.userInfo.id + "/freelancer/", {
            'DesktopCatTools': getIds($scope.freelancerInfo.DesktopCatTools),
            'DesktopOperatingSystems': getIds($scope.freelancerInfo.DesktopOperatingSystems),
            'InterpretingSpecialisms': getIds($scope.freelancerInfo.InterpretingSpecialisms),
            'Resources': getIds($scope.freelancerInfo.Resources),
            'TranslationCatTools': getIds($scope.freelancerInfo.TranslationCatTools),
            'TranslationSpecialisms': getIds($scope.freelancerInfo.TranslationSpecialisms)
        });

        // wait all done
        $q.all([requestFreelancer, requestInfo])
            .then(function(result){
                // TODO: change this callback
                alert("Success update all");
            });
    };

    /**
     * Toggle resource
     */
    $scope.toggleResource = function($id){
        var $index = $scope.freelancerInfo.Resources.indexOf($id);
        if($index == -1){
            $scope.freelancerInfo.Resources.push($id);
        } else {
            $scope.freelancerInfo.Resources.splice($index, 1);
        }
    };

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

    /**
     * Save interpreting price from modal
     * @param interpretingPrice
     */
    $scope.saveInterpretingPrice = function(interpretingPrice){
        var interpretingPriceData = {
            userId: $scope.userInfo.id,
            sourceLanguageId: interpretingPrice.sourceLanguage.id,
            targetLanguageId: interpretingPrice.targetLanguage.id,
            serviceId: interpretingPrice.service.id,
            priceDay: interpretingPrice.priceDay,
            priceHalfDay: interpretingPrice.priceHalfDay
        }
        $http.post("/api/user/" + $scope.userInfo.id + "/interpretingPrice", interpretingPriceData)
            .success(function($data){
                jQuery("#modal-interpreting").modal("hide");
                $scope.interpretingPrices.push($data['interpretingPrice']);
                setModalControllerData('interpretingPrice', interpretingPricePlaceholder())
            });
    };
    $scope.deleteInterpretingPrice = function($index){
        var interpretingPrice = $scope.interpretingPrices[$index];
        $http.delete("/api/user/" + $scope.userInfo.id + "/interpretingPrice/" + interpretingPrice.id)
            .success(function(){
                $scope.interpretingPrices.splice($index, 1);
            });
    };
});