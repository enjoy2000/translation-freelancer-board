/**
 * Created by eastagile on 11/11/14.
 */
angularApp.controller('ItemListController', function($scope, $location, $timeout){
    $scope.pages = {};
    $scope.maxSize = 7;
    $scope.page = 1;
    $scope.filter = {};

    function remove($index){
        var item = $scope.items[$index];
        bootbox.confirm("Are you sure to delete?", function(value){
            if(value){
                $scope.ItemApi.delete(item.id, function(){
                    $timeout(function(){
                        $scope.items.splice($index, 1);
                    }, 1);
                });
            }
        });
    }

    function loadItems(page, func){
        var params = $scope.filter;
        params.page = page;
        $scope.items = [];
        $scope.ItemApi.list(params, function($items, $pages){
            $scope.items = $items;
            $scope.pages =$pages;
            if(typeof(func) == 'function'){
                func();
            }
        });
    }

    function search(){
        $scope.loadItems(1);
    }

    function pageChanged(){
        $scope.loadItems($scope.page);
        console.log("Change to page " + $scope.page);
    }

    function simpleLoad(btn, state){
        if (state) {
            btn.children().addClass('fa-spin');
            btn.contents().last().replaceWith(" Loading");
        } else {
            btn.children().removeClass('fa-spin');
            btn.contents().last().replaceWith(" Refresh");
        }
    }

    function refresh(){
        $scope.items = [];
        var btn = $('#loading-example-btn');
        simpleLoad(btn, true);
        $scope.loadItems(function(){
            simpleLoad(btn, false);
        });
    }

    $scope.pageChanged = pageChanged;
    $scope.remove = remove;
    $scope.search = search;
    $scope.loadItems = loadItems;
    $scope.refresh = refresh;

    $scope.loadItems($scope.page);

});

angularApp.controller('ProjectIndexController', function($scope, StaffApi, LanguageApi, ProjectApi, ProjectServiceLevel,
                                                         ProjectStatus, DateFormatter, CurrentUser, PayStatus,
                                                         ProjectField){

    $scope.CurrentUser = CurrentUser;
    $scope.DateFormatter = DateFormatter;
    $scope.ProjectApi = ProjectApi;
    $scope.ProjectServiceLevel = ProjectServiceLevel;
    $scope.ProjectStatus = ProjectStatus;
    $scope.PayStatus = PayStatus;
    $scope.ProjectField = ProjectField;
    $scope.StaffApi = StaffApi;

    /** This is for listing item controller **/
    $scope.ItemApi = ProjectApi;

    $scope.languages = {};
    $scope.pms = {};
    $scope.sales = {};

    $scope.goToDetail = function($project){
        location.href = "/admin/project/detail/#?id=" + $project.id;
    };

    $scope.goToEdit = function($project){
        location.href = "/admin/project/detail/#edit?id=" + $project.id;
    };

    StaffApi.list({
        type: 2
    }, function($pms){
        $scope.pms = $pms;
    });

    StaffApi.list({
        type: 1
    }, function($sales){
        $scope.sales = $sales;
    });

    LanguageApi.list({}, function($languages){
        $scope.languages = $languages;
    })
});