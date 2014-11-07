/**
 * Created by hat.dao on 10/14/2014.
 */
angularApp.controller('listFreelancerController', function($scope, $http, $timeout, $q){
    $scope.list = [];
    $scope.pages = [];
    $scope.rangeCustom = [];

    $scope.catTools = [];
    $scope.operatingSystems = [];
    $scope.resources = [];
    $scope.specialisms = [];
    $scope.ratings = [];
    $scope.sources = [];
    $scope.countries = [];

    $scope.searchParams = {
        'search': null,
        'name': null,
        'idFreelancer': null,
        'email': null,
        'type': null,
        'source': null,
        'target': null,
        'rate': null,
        'specialism': null,
        'country': null,
        'includeInactive': null,
        'specialismTested': null,
        'senior': null,
        'page': null
    };

    function init(){
        selectPage(1);
        jQuery(document).ready(function(){
           $('.pager.btn-group button').click(function(){
              selectPage(parseInt($(this).data('page')));
           });
        });

        // delete freelancer
        $scope.deleteFreelancer = function($id){
            bootbox.confirm(DELETE_CONFIRM_TEXT, function(result) {
                if(result == true){
                    $http.delete('/api/user/'+$id+'/freelancer').success(function($data){
                        console.log('Deleted user with id %s', $id);
                        selectPage($scope.pages.current);
                    });
                }
            });
        };
        
        // get freelancer data
        getFreelancerData();

        // search submit
        $scope.advancedSearch = function(){
            selectPage(1);
        }
    }

    function selectPage($page){
        // check search
        var search = 0;
        for(var key in $scope.searchParams) {
            var obj = $scope.searchParams[key];
            if (obj != null) {
                search++;
            }
        };
        if(search > 0){
            $scope.searchParams.page = $page;
            $scope.searchParams.search = 1;
            var $params = $scope.searchParams;
            console.log('search');
        }else{
            var $params = {page: $page};
            console.log('no search');
        }

        $http.get("/api/user/freelancer", {
            params: $params
        }).success(function($data){
            $scope.list = $data['freelancerList'];
            $scope.pages = $data['pages'];
            if($data['pages']){
                var N = $scope.pages.pageCount;
                $scope.rangeCustom = Array.apply(null, {length: N}).map(Number.call, Number);
            }
            console.log($data);
        });
    }

    function getFreelancerData(){
        $http.get('/api/user/freelancer-data').success(function($data){
            $scope.catTools = $data['catTools'];
            $scope.operatingSystems = $data['operatingSystems'];
            $scope.resources = $data['resources'];
            $scope.specialisms = $data['specialisms'];
            $scope.ratings = $data['ratings'];
            $scope.countries = $data['countries'];
            $.each($scope.resources, function(){
                $.each(this.resources, function(){
                    $scope.sources.push(this);
                });
            });
            console.log($data);
            console.log($scope.sources);
        });
    }

    // init
    init();
});