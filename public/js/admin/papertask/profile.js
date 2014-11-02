angularApp.controller('PapertaskProfileController', function($scope, $http, $timeout, $q) {
    $scope.translationTM = [];
    $scope.translation = [];
    $scope.languages = [];
    $scope.newLanguagePricePair = nullTranslation = {
        'id': null,
        'sourceLanguage': null,
        'targetLanguage': null,
        'professionalPrice': null,
        'businessPrice': null,
        'premiumPrice': null
    };

    $scope.softwarePrices = [];
    $scope.softwarePrice = nullPrice = {

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
                $('.modal').modal('hide');
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

        // init add translation -> reset translation val
        $scope.initAddTranslation = function(){
            $scope.newLanguagePricePair = nullTranslation;
        };

        // create translation
        $scope.createLanguagePricePair = function(){
            var validate = $('form[name=formTranslation]').valid();
            if(validate == true){
                // hide modal
                $('.modal').modal('hide');
                if($scope.newLanguagePricePair.id > 0){
                    $http.put('/api/papertask/translation/' + $scope.newLanguagePricePair.id +'/',
                        $scope.newLanguagePricePair
                    ).success(function($data){
                    });
                }else{
                    $http.post('/api/papertask/translation/', $scope.newLanguagePricePair).success(function($data){
                        getListTranslation();
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
                    });
                }
            });
        };

        // get list languages
        $http.get("/api/common/language").success(function($data){
            $scope.languages = $data;
            console.log($data);
        });

        //get list software prices
        getListSoftwarePrices();
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
        }).error(function($e){
            alert('error');
        });
    }

    init();
});