angularApp.run( function ( $rootScope ) {
	
}) 

angularApp.controller('PapertaskEmployerListController', function($scope, $http, $timeout, $q) {
	/**
	 * 
	 */
	$scope.companies 	= [];
	$scope.countries 	= [];
	$scope.pages 		= [];
	$scope.employers 	= [];
	
	$scope.init = function () {
		$http.get("/api/user/employer?page=1")
	        .success(function($data){
	            $scope.pages = $data.pages;
	            $scope.employers = $data.employers;
	    });
		
		$http.get("/api/common/country")
	        .success(function($data){
	            $scope.countries = $data['countries'];
	    });
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
		document.location.href = "/admin/employer/detail?id=" + str_empid;
	}
	$scope.onEditClicked = function ( str_empid ) {
		console.log (' a ');
		document.location.href = "/admin/employer/edit?userId=" + str_empid;
	}
	$scope.onDeleteClicked = function ( str_empid ) {
        bootbox.confirm ( "Are you sure!", function ( bflag ) {
            if ( bflag ) {
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
        })		
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