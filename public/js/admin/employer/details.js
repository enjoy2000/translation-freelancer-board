angularApp.run( function ( $rootScope ) {
	
}) 

angularApp.controller('PapertaskEmployerDetailController', function($scope, $http, $timeout, $q) {
	/**
	 * 
	 */
	$scope.userId 	= "";
	$scope.countries 	= [];
	$scope.pages 		= [];
	$scope.employers 	= [];
	
	$scope.init = function (str_uid) {
		$scope.userId = str_uid;
		console.log ( $scope.userId );
	}
	
	/**
	 * Get country from country id
	 */
	$scope.getCountry = function ( str_countryid ) {
		if ( $scope.countries.length == 0 || str_countryid == null)
			return '';
		
		var str_label = '';
		
		angular.forEach($scope.countries, function ( v, k ) {
			if ( v.select == str_countryid ) {
				str_label = v.label;
			}
		});
		
		return str_label;
	}
	
	$scope.onViewClicked = function ( str_empid ) {
		console.log ( str_empid );
	}
	$scope.onEditClicked = function ( str_empid ) {
		console.log ( str_empid );
	}
	$scope.onDeleteClicked = function ( str_empid ) {
		var delEmp = $http.delete("/api/user/" + str_empid + "/employer", {id: str_empid});
		$q.all([delEmp])
        .then(function(result){
        	$http.get("/api/user/employer?page=1")
		        .success(function($data){
		            $scope.pages = $data.pages;
		            $scope.employers = $data.employers;
		    });
        });
	}
	
	$scope.onBtnPreviousClicked = function () {
		$http.get("/api/user/employer?page="+ $scope.pages.previous)
	        .success(function($data){
	            $scope.pages = $data.pages;
	            $scope.employers = $data.employers;
	    });
	}
	
	$scope.onBtnGoto = function ( int_index ) {
		$http.get("/api/user/employer?page="+ (int_index*1 + 1))
	        .success(function($data){
	            $scope.pages = $data.pages;
	            $scope.employers = $data.employers;
	    });
	}
	
	$scope.onBtnNextClicked = function () {
		$http.get("/api/user/employer?page="+ $scope.pages.next)
	        .success(function($data){
	            $scope.pages = $data.pages;
	            $scope.employers = $data.employers;
	    });
	}
	
});