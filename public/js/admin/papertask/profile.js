angularApp.controller('PapertaskProfileController', function($scope, $http, $timeout, $q) {
    $scope.translationTM = [];
    $scope.translation = [];
    $scope.languages = [];
    $scope.languageGroups = [];
    $scope.newLanguagePricePair = nullTranslation = {
        'id': null,
        'sourceLanguage': null,
        'targetLanguage': null,
        'professionalPrice': null,
        'businessPrice': null,
        'premiumPrice': null
    };

    $scope.desktopSoftwares = [];
    $scope.softwarePrices = [];
    $scope.softwarePrice = nullPrice = {
        'id': null,
        'languageGroup': {},
        'desktopSoftware': {},
        'priceApplePerPage': null,
        'priceWindowPerPage': null,
        'priceApplePerHour': null,
        'priceWindowPerHour': null
    };

    $scope.engineeringCategories = [];
    $scope.units = [];
    $scope.engineeringPrices = [];
    $scope.engineeringPrice = nullEngineeringPrice = {
        'id': null,
        'engineeringCategory': {},
        'unit': {},
        'price': null
    };

    $scope.interpretingServices = [];
    $scope.interpretingPrices = [];
    $scope.interpretingPrice = nullInterpretingPrice = {
        'id': null,
        'sourceLanguage': {},
        'targetLanguage': {},
        'interpretingService': {},
        'pricePerDay': null,
        'pricePerHalfDay': null
    };

    function init(){
        // validate
        $('form').validate();

        // Get list translationTM
        $http.get("/api/papertask/translationtm").success(function($data){
           $scope.translationTM = $data['translationTM'];
            console.log($data['translationTM']);
        }).error(function($e){
           alert('error');
        });

        // update translationTM
        $scope.updateTranslationTM = function(){
            var validate = $('form[name=formTM]').valid();
            if(validate == true){
                hideModal();
                $.each($scope.translationTM, function(){
                    console.log($(this)[0].rate);
                    if($(this)[0].rate){
                        $http.put('/api/papertask/translationtm/' + $(this)[0].id + '/', {
                            rate: $(this)[0].rate
                        });
                    }
                });
            }
        };

        // hide target language option as source language
        $('select[name=sourceLanguage]').on('change', function(){
            $('select[name=targetLanguage] option').show();
           $('select[name=targetLanguage] option[value='+ $(this).val() +']').hide();
        });

        // Get list translation
        getListTranslation();

        // init add new row -> reset all row value val
        $scope.initAddNewRow = function(){
            $scope.newLanguagePricePair = nullTranslation;
            $scope.softwarePrice = nullPrice
        };

        // create translation
        $scope.createLanguagePricePair = function(){
            var validate = $('form[name=formTranslation]').valid();
            if(validate == true){
                // hide modal
                hideModal();
                if($scope.newLanguagePricePair.id > 0){
                    $http.put('/api/papertask/translation/' + $scope.newLanguagePricePair.id +'/',
                        $scope.newLanguagePricePair
                    ).success(function($data){
                    });
                }else{
                    $http.post('/api/papertask/translation/', $scope.newLanguagePricePair).success(function($data){
                        getListTranslation();
                        $scope.newLanguagePricePair = nullTranslation;
                    });
                }
                console.log('LanguegPricePair is created.');
            }
        };

        // update translation
        $scope.editTranslation = function(pair){
            $scope.newLanguagePricePair = pair;
            console.log(pair);
        }

        // delete translation
        $scope.deleteTranslation = function(id){
            bootbox.confirm(confirmDeleteText, function(result) {
                if(result == true){
                    $http.delete('/api/papertask/translation/' + id).success(function(){
                        console.log('deleted translation');
                        getListTranslation();
                        scrollToDiv('translation');
                    });
                }
            });
        };

        // get list languages
        $http.get("/api/common/language").success(function($data){
            $scope.languages = $data;
            console.log($data);
        });

        // get list language groups
        $http.get("/api/common/language-group").success(function($data){
            $scope.languageGroups = $data;
            console.log($data);
        });

        //get list desktop software and interpreting services
        $http.get("/api/user/price-data").success(function($data){
            $scope.desktopSoftwares = $data['softwares'];
            $scope.interpretingServices = $data['services'];
        });

        //get list software prices
        getListSoftwarePrices();

        // edit software price
        $scope.editSoftwarePrice = function(price){
            $scope.softwarePrice = price;
        }

        // add software price
        $scope.addSoftwarePrice = function(){
            var validate = $('form[name=softwarePriceForm]').valid();
            if(validate == true){
                if($scope.softwarePrice.id > 0){
                    // update software price
                    $http.put('/api/papertask/desktop-publishing/'+ $scope.softwarePrice.id + '/',
                        $scope.softwarePrice).success(function($data){
                        console.log('Added software price');
                    });
                }else{
                    // add software price
                    $http.post('/api/papertask/desktop-publishing', $scope.softwarePrice).success(function($data){
                        console.log('Added software price');
                    });
                }
                getListSoftwarePrices();
                hideModal();
            }
        }

        // delete software price
        $scope.deleteSoftwarePrice = function($id){
            bootbox.confirm(confirmDeleteText, function(result) {
                if(result == true){
                    $http.delete('/api/papertask/desktop-publishing/' + $id).success(function(){
                        console.log('deleted software price');
                        getListSoftwarePrices();
                        scrollToDiv('desktop-publishing');
                    });
                }
            });
        };

        //get list engineering prices
        getListEngineeringPrices();

        // get list engineering categories
        $http.get('/api/common/engineering-category').success(function($data){
            $scope.engineeringCategories = $data;
            console.log('Got list engineering categories');
        });

        // get list units
        $http.get('/api/common/unit').success(function($data){
            $scope.units = $data;
            console.log('Got list units');
        });

        // add engineering price
        $scope.addEngineeringPrice = function(){
            var validate = $('form[name=engineeringPriceForm]').valid();
            if(validate == true){
                if($scope.engineeringPrice.id > 0){
                    // update engineering price
                    $http.put('/api/papertask/engineering/'+ $scope.engineeringPrice.id +'/', $scope.engineeringPrice)
                        .success(function($data){
                        console.log('Updated item %s', $scope.engineeringPrice.id);
                    });
                }else{
                    // add engineering price
                    $http.post('/api/papertask/engineering/', $scope.engineeringPrice).success(function($data){
                        console.log('Added new engineering price');
                    });
                }
                getListEngineeringPrices();
                hideModal();
            }
        }

        // edit engineering price
        $scope.editEngineeringPrice = function($price){
            $scope.engineeringPrice = $price;
        }

        // delete engineering price
        $scope.deleteEngineeringPrice = function($id){
            bootbox.confirm(confirmDeleteText, function(result) {
                if(result == true){
                    $http.delete('/api/papertask/engineering/' + $id).success(function(){
                        console.log('deleted engineering price');
                        getListEngineeringPrices();
                        scrollToDiv('engineering');
                    });
                }
            });
        };

        // get list interpreting prices
        getListInterpretingPrices();

        // add interpreting price
        $scope.addInterpretingPrice = function(){
            var validate = $('form[name=interpretingPriceForm]').valid();
            if(validate == true){
                if($scope.interpretingPrice.id > 0){
                    // update interpreting price
                    $http.put('/api/papertask/interpreting/'+ $scope.interpretingPrice.id +'/', $scope.interpretingPrice)
                        .success(function($data){
                            console.log('Updated item %s', $scope.interpretingPrice.id);
                        });
                }else{
                    // add interpreting price
                    $http.post('/api/papertask/interpreting/', $scope.interpretingPrice).success(function($data){
                        console.log('Added new interpreting price');
                    });
                }
                getListInterpretingPrices();
                hideModal();
            }
        }

        // edit interpreting price
        $scope.editInterpretingPrice = function($price){
            $scope.interpretingPrice = $price;
        }

        // delete interpreting price
        $scope.deleteInterpretingPrice = function($id){
            bootbox.confirm(confirmDeleteText, function(result) {
                if(result == true){
                    $http.delete('/api/papertask/interpreting/' + $id).success(function(){
                        console.log('deleted interpreting price');
                        getListInterpretingPrices();
                        scrollToDiv('interpreting');
                    });
                }
            });
        };
    }

    function getListTranslation(){
        $http.get("/api/papertask/translation").success(function($data){
            $scope.translation = $data['translation'];
            console.log($data['translation']);
        }).error(function($e){
            alert('error');
        });
    }

    function getListSoftwarePrices(){
        $http.get("/api/papertask/desktop-publishing").success(function($data){
            $scope.softwarePrices = $data['softwarePrices'];
            console.log($data['softwarePrices']);
            console.log('Got list software prices');
        }).error(function($e){
            alert('error');
        });
    }

    function getListEngineeringPrices(){
        $http.get("/api/papertask/engineering").success(function($data){
            $scope.engineeringPrices = $data['engineering'];
            console.log($scope.engineeringPrices);
            console.log('Got list engineering prices');
        }).error(function($e){
            alert('error');
        });
    }

    function getListInterpretingPrices(){
        $http.get("/api/papertask/interpreting").success(function($data){
            $scope.interpretingPrices = $data['interpreting'];
            console.log($scope.interpretingPrices);
            console.log('Got list interpreting prices');
        }).error(function($e){
            alert('error');
        });
    }

    function hideModal(){
        $('.modal').modal('hide');
    }

    function scrollToDiv(divId){
        jQuery('html, body').animate({
            scrollTop: jQuery('#' + divId).position().top
        }, 500);
    }

    init();
});