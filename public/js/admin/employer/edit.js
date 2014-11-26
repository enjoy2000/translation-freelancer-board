/**
 * Created by G
 *
 */
angularApp.run( function ($rootScope) {    
    $(".summernote").summernote();
    $("#form").validate({
        errorPlacement: function (error, element) {
            element.before(error);
        },
        rules: {
            confirmpwd: {
                equalTo: "#password"
            },
            email: {
                required: true,
                email: true
            }
        },
        submitHandler: function( form ) {
            angular.element('#EmployerController').scope().submit();
        }
    });
});
angularApp.controller('PapertaskEmployerEditController', function($scope, $http, $timeout, $q) {
    $scope.countries = [];
    $scope.languages = [];
    $scope.resources = [];
    $scope.softwares = [];
    $scope.companies = [];
    $scope.isActive = 0;
    
    $scope.userId = '';
    
    // For Engineering Price
    $scope.units 	 = [];
    $scope.engineeringCategories = [];
    
    $scope.translationPrices = [];
    $scope.desktopPrices = [];
    $scope.interpretingPrices = [];
    $scope.engineeringPrices = [];
    
    $scope.editTranslation = -1;
    $scope.editDtp = -1;
    $scope.editInterpreting = -1;
    $scope.editEngineering = -1;
    
    $scope.employer = { };

    /**
     * Mark resource active params
     */
    function initModal(){
        setModalControllerData('languages', $scope.languages);
        setModalControllerData('services', $scope.services);
        setModalControllerData('softwares', $scope.softwares);
    }

    /** end mapping function **/
    $scope.init = function( str_uid ){
    	$scope.userId = str_uid;
        var priceDataRequest = $http.get("/api/user/priceData")
            .success(function($data){
                $scope.languages = $data['languages'];
                $scope.services = $data['services'];
                $scope.softwares = $data['softwares'];
                initModal();
            });

        $http.get("/api/user/" + $scope.userId)
        	.success( function ( $data ) {
        		var ptr_user = $data.user;
        		$scope.isActive = ptr_user.isActive;

        		$scope.employer = {
    		    	isActive: ptr_user.isActive,
    		    	profileUpdated: ptr_user.profileUpdated,
    				email: ptr_user.email,
    				username: $data.employer.name,
    				firstname: ptr_user.firstName,
    				surname: ptr_user.lastName,
    				gender: ptr_user.gender,
    				city: ptr_user.city,
    				lastName: ptr_user.lastName,
    				phone: ptr_user.phone,
    				country: ptr_user.country,
    				position: ptr_user.position,
    				company: ptr_user.company,
    				currency:ptr_user.currency,
    				defaultServiceLevel: $data.employer.defaultServiceLevel,
    				tmRatio: $data.tmRatios,
    				comments: ptr_user.comments,
    				company: $data.employer.company,
    				employerId: $data.employer.id
    			};
        		$scope.translationPrices = $data.translationPrices;
        		$scope.engineeringPrices = $data.engineeringPrices;
        		$scope.desktopPrices = $data.desktopPrices;
        		$scope.interpretingPrices = $data.interpretingPrices;
        		$("#EmployerController").fadeIn();
        	});
        $http.get("/api/common/country")
            .success(function($data){
                $scope.countries = $data['countries'];
                setModalControllerData('countries', $scope.countries);
                if($scope.employer.country){
                    $scope.employer.country = findOption($scope.countries, $scope.employer.country);
                }
        });
        $http.get("/api/common/company")
	        .success(function($data){
	            $scope.companies = $data['companies'];
        });
        $http.get("/api/common/unit")
	        .success(function($data){
	            $scope.units = $data;
	            setModalControllerData('units', $scope.units);
	    });
        $http.get("/api/common/engineeringCategory")
	        .success(function($data){
	            $scope.engineeringCategories = $data;
	            setModalControllerData('engineeringCategories', $scope.engineeringCategories);
	    });
    };
 
    /**
     * Submit the form
     */
    $scope.submit = function(){
    	$scope.employer.comments = $('.summernote').code();

    	var ptr_employer = {
    			isActive: $scope.employer.isActive,
    			profileUpdated: $scope.employer.profileUpdated,
    			lastName: $scope.employer.surname,
    			firstName: $scope.employer.firstname,
    			defaultServiceLevel: $scope.employer.defaultServiceLevel,
    			email: $scope.employer.email, 
    			city: $scope.employer.city,
    			country: $scope.employer.country,
    			currency: $scope.employer.currency,
    			phone: $scope.employer.phone,
    			gender: $scope.employer.gender,
    			position: $scope.employer.position,
    			company: $scope.employer.company,
    			comments: $('.summernote').code(),
    	};
    	$http.put("/api/user/"+$scope.userId, ptr_employer)
        	.success(function($data){
	            $http.put("/api/user/"+$scope.employer.employerId+"/employer?user_id="+$scope.userId, ptr_employer).success(function(){
	        });	            
        });
    	if ( $scope.employer.tmRatio && $scope.employer.tmRatio.id ) {
    		$http.put("/api/user/" + $scope.employer.tmRatio.id + "/tmratio", {
    			userId: $scope.userId,
    			repetitions: $scope.employer.tmRatio.repetitions,
    			yibai: $scope.employer.tmRatio.yibai,
    			jiuwu: $scope.employer.tmRatio.jiuwu,
    			bawu: $scope.employer.tmRatio.bawu,
    			qiwu: $scope.employer.tmRatio.qiwu,
    			wushi: $scope.employer.tmRatio.wushi,
    			nomatch: $scope.employer.tmRatio.nomatch
    		});
    	} else {
    		$http.post("/api/user/tmratio", {
    			userId: $scope.userId,
    			repetitions: $scope.employer.tmRatio.repetitions,
    			yibai: $scope.employer.tmRatio.yibai,
    			jiuwu: $scope.employer.tmRatio.jiuwu,
    			bawu: $scope.employer.tmRatio.bawu,
    			qiwu: $scope.employer.tmRatio.qiwu,
    			wushi: $scope.employer.tmRatio.wushi,
    			nomatch: $scope.employer.tmRatio.nomatch
    		});
    	}
    	
    };
    
    /**
     * Translation Prices
     */
    $scope.translationPricePlaceholder = function () {
    	return {
            sourceLanguage: $scope.languages[0],
            targetLanguage: $scope.languages[0],
            price: 0
        };
    }
    
    $scope.saveTranslationPrice = function( translationPrice ){
    	if ( $scope.editTranslation == -1 ) {
    		$http.post("/api/user/translationprice", 
				{
    				userId: $scope.userId,
					sourceLanguageId: translationPrice.sourceLanguage.id, 
					targetLanguageId: translationPrice.targetLanguage.id, 
					price: translationPrice.price
				}).success(function( data ) {
					$scope.translationPrices.push( data.translationPrice );
    			});
    	} else {
    		$http.put("/api/user/" + translationPrice.id + "/translationprice", 
				{
    				userId: $scope.userId,
					sourceLanguageId: translationPrice.sourceLanguage.id, 
					targetLanguageId: translationPrice.targetLanguage.id, 
					price: translationPrice.price
				}).success(function( data ) {
					$scope.translationPrices[$scope.editTranslation] = {sourceLanguage: data.sourceLanguage, targetLanguage: data.targetLanguage, price: data.price, id: data.id}
    			});
    		
    	}
    	jQuery("#modal-translation").modal("hide");
    	setModalControllerData('translationPrice', $scope.translationPricePlaceholder);
    	$scope.editTranslation = -1;
    };
    
    $scope.deleteTranslationPrice = function ( index, tid ) {    	
        bootbox.confirm("Are you sure", function( bflag ) {
            if ( bflag == true ) {
                $http.delete("/api/user/" + tid + "/translationprice", {
                    userId: $scope.userId            
                }).success(function( data ) {                
                    $scope.translationPrices.splice(index, 1);
                });                
            }
        });       
    }
    
    $scope.editTranslationPrice = function ( index, tid ) {
    	$scope.editTranslation = index;
    	setModalControllerData('translationPrice', $scope.translationPrices[index]);
    	jQuery("#modal-translation").modal("show");
    }
    
    /**
     * Desktop Price
     */
    $scope.dtpPricePlaceholder = function () {
    	return {
    		language: {},
    		priceHourMac: 0,
    		priceHourPc: 0,
    		priceMac: 0,
    		pricePc: 0,
    		software: {}
        };
    }
    $scope.saveDesktopPrice = function (desktopPrice ) {
    	if ( $scope.editDtp == -1) {
    		$http.post("/api/user/desktopprice", {
    			userId: $scope.userId,
    			languageId: desktopPrice.language.id,
    			softwareId: desktopPrice.software.id,
    			priceHourMac: desktopPrice.priceHourMac,
    			priceMac: desktopPrice.priceMac,
    			pricePc: desktopPrice.pricePc,
    			priceHourPc: desktopPrice.priceHourPc
    		}).success(function (data){
    			$scope.desktopPrices.push ( data.desktopPrice );
    		});
    	} else {
    		$http.put("/api/user/" + desktopPrice.id + "/desktopprice", {
    			userId: $scope.userId,
    			languageId: desktopPrice.language.id,
    			softwareId: desktopPrice.software.id,
    			priceHourMac: desktopPrice.priceHourMac,
    			priceMac: desktopPrice.priceMac,
    			pricePc: desktopPrice.pricePc,
    			priceHourPc: desktopPrice.priceHourPc
    		}).success( function (data) {
    			$scope.desktopPrices[ $scope.editDtp ] = data.desktopPrice;
    		});
    	}
    	
    	jQuery("#modal-dtp").modal("hide");
    	setModalControllerData('desktopPrice', $scope.dtpPricePlaceholder);
    	$scope.editDtp = -1;
    }
    $scope.editDesktopPrice = function ( ind ) {
    	$scope.editDtp = ind;
    	setModalControllerData('desktopPrice', $scope.desktopPrices[ind]);
    	jQuery("#modal-dtp").modal("show");
    }
    $scope.deleteDesktopPrice = function ( ind, did ) {
        bootbox.confirm("Are you sure!", function (bflag) {
            if ( bflag )
                $http.delete("/api/user/" + did + "/desktopprice", {
                    userId: $scope.userId            
                }).success(function( data ) {                
                    $scope.desktopPrices.splice( ind, 1 );
                });    
        });
    	
    }
    
    /**
     * Interpreting price
     */
    $scope.interpretingPricePlaceholder = function () {
    	return {
    		priceDay: 0,
    		priceHalfDay: 0,
    		service: {},
    		sourceLanguage: {},
    		targetLanguage: {}
    	};
    }
    $scope.saveInterpretingPrice = function ( interpretingPrice ) {
    	console.log ( interpretingPrice);
    	if ( $scope.editInterpreting == -1) {
    		$http.post("/api/user/interpretingprice", {
    			userId: $scope.userId,
    			priceDay: interpretingPrice.priceDay,
    			priceHalfDay: interpretingPrice.priceHalfDay,
    			sourceLanguageId: interpretingPrice.sourceLanguage.id,
    			targetLanguageId: interpretingPrice.targetLanguage.id,
    			serviceId: interpretingPrice.service.id
    		}).success(function( data ){
    			$scope.interpretingPrices.push ( data.interpretingPrice );
    		});
    	} else {
    		$http.put("/api/user/" + interpretingPrice.id + "/interpretingprice", {
    			userId: $scope.userId,
    			priceDay: interpretingPrice.priceDay,
    			priceHalfDay: interpretingPrice.priceHalfDay,
    			sourceLanguageId: interpretingPrice.sourceLanguage.id,
    			targetLanguageId: interpretingPrice.targetLanguage.id,
    			serviceId: interpretingPrice.service.id
    		}).success(function( data ) {
    			$scope.interpretingPrices[ $scope.editInterpreting ] = data.interpretingPrice;
    		});
    	}
    	
    	jQuery("#modal-interpreting").modal("hide");
    	setModalControllerData('interpretingPrice', $scope.interpretingPricePlaceholder);
    	$scope.editInterpreting = -1;
    }
    $scope.editInterpretingPrice = function (ind) {
    	$scope.editInterpreting = ind;
    	setModalControllerData('interpretingPrice', $scope.interpretingPrices[ind]);
    	jQuery("#modal-interpreting").modal("show");
    }
    $scope.deleteInterpretingPrice = function (ind, iid) {
        bootbox.confirm( "Are you sure!", function ( bflag ) {
            if ( bflag ) 
               $http.delete("/api/user/" + iid + "/interpretingprice", {
                    userId: $scope.userId            
                }).success(function( data ) {                
                    $scope.interpretingPrices.splice( ind, 1 );
                }); 
        });
    }
    
    /**
     * Company
     */
    $scope.countryPlaceholder = function () {
    	return {};
    }
    $scope.saveCompany = function(company){
        var $data = jQuery.extend(true, {}, company);
        $data.country = $data.country.select;
        $http.post("/api/common/company", $data)
            .success(function($data){
                jQuery("#modal-company").modal("hide");
                $scope.companies.push($data['company']);
                setModalControllerData('company', $scope.countryPlaceholder())
            });
    }
    
    /**
     * Engineering Price
     */
    $scope.engineerPlaceholder = function () {
    	return {};
    }
    
    $scope.saveEngineeringPrice = function( engineerPrice ) {
    	if ( $scope.editEngineering == -1) {
    		$http.post("/api/user/engineeringprice", {
    			userId: $scope.userId,
    			engineeringCategory: engineerPrice.engineeringCategory,
    			unit: engineerPrice.unit,
    			price: engineerPrice.price
    		}).success(function ( data ) {
    			$scope.engineeringPrices.push ( data.engineeringPrice );
    		});
    	} else {
    		$http.put("/api/user/" + engineerPrice.id + "/engineeringPrice", {
    			userId: $scope.userId,
    			engineeringCategory: engineerPrice.engineeringCategory,
    			unit: engineerPrice.unit,
    			price: engineerPrice.price
    		}).success(function( data ) { 
    			$scope.engineeringPrices[$scope.editEngineering] = data.engineeringPrice;
    		});
    	}
    	
    	jQuery("#modal-eng").modal("hide");
    	setModalControllerData('engineerPrice', $scope.engineerPlaceholder());
    	$scope.editEngineering = -1;
    }
    $scope.deleteEngineeringPrice = function (ind, eid) {
        bootbox.confirm( "Are you sure!", function ( bflag ) {
            if ( bflag ) {
                $http.delete("/api/user/" + eid + "/engineeringprice", {
                    userId: $scope.userId
                }).success(function (data ){
                    $scope.engineeringPrices.splice( ind, 1 );
                });        
            }
        });    	
    }
    $scope.editEngineeringPrice = function (ind) {
    	$scope.editEngineering = ind;
    	setModalControllerData('engineerPrice', $scope.engineeringPrices[ind]);
    	jQuery("#modal-eng").modal("show");
    }

    /**
     * Display activate class
     */
    $scope.active_class = function(a, b){
        return a == b ? 'active' : '';
    };
    
    $scope.setActive = function ( str_flag ) {
    	$scope.employer.isActive = str_flag;
    }
    $scope.setGender = function ( str_gender ) {
    	$scope.employer.gender = str_gender;
    }
    $scope.setCurrency = function ( str_currency ) {
    	$scope.employer.currency = str_currency;
    } 
    $scope.setProfileUploaded = function ( str_flag ) {
    	$scope.employer.profileUploaded = str_flag;
    }
    $scope.setServiceLevel = function ( str_servicelevel ) {
    	$scope.employer.defaultServiceLevel = str_servicelevel;
    }
});
