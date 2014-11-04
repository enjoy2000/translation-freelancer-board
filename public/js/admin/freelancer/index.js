/**
 * Created by hat.dao on 10/14/2014.
 */
angularApp.controller('listFreelancerController', function($scope, $http, $timeout, $q){
    $scope.list = [];
    $scope.pages = [];
    $scope.rangeCustom = [];

    function init(){
        selectPage(1);
        jQuery(document).ready(function(){
           $('.pager.btn-group button').click(function(){
              selectPage(parseInt(jQuery(this).data('page')));
           });
        });
    }

    function selectPage($page){
        $http.get("/api/user/freelancer", {
            params: {
                page: $page
            }
        }).success(function($data){
            $scope.list = $data['freelancerList'];
            $scope.pages = $data['pages'];
            var N = $scope.pages.pageCount;
            $scope.rangeCustom = Array.apply(null, {length: N}).map(Number.call, Number);
            console.log($data);
        });
    }
    init();
});