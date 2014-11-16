/**
 * Created by eastagile on 11/11/14.
 */
angularApp.controller('ItemListController', function($scope, $location, ProjectApi, ProjectServiceLevel, ProjectStatus,
                                                     DateFormatter, CurrentUser, $timeout, PayStatus, ProjectField,
                                                     StaffApi){
    $scope.CurrentUser = CurrentUser;
    $scope.DateFormatter = DateFormatter;
    $scope.ProjectApi = ProjectApi;
    $scope.ProjectServiceLevel = ProjectServiceLevel;
    $scope.ProjectStatus = ProjectStatus;
    $scope.PayStatus = PayStatus;
    $scope.ProjectField = ProjectField;
    $scope.StaffApi = StaffApi;

    $scope.pages = {};
    $scope.maxSize = 7;
    $scope.page = 1;
    $scope.filter = {};

    function remove($index){
        var project = $scope.items[$index];
        bootbox.confirm("Are you sure to delete project '" + project.reference + "'?", function(value){
            if(value){
                ProjectApi.delete(project.id, function(){
                    $timeout(function(){
                        $scope.items.splice($index, 1);
                    }, 1)
                });
            };
        });
    }

    function loadItems(page, func){
        var params = $scope.filter;
        params.page = page;
        $scope.items = [];
        ProjectApi.list(params, function($projects, $pages){
            $scope.items = $projects;
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

    $scope.pageChanged = pageChanged;
    $scope.remove = remove;
    $scope.search = search;
    $scope.loadItems = loadItems;

    $scope.loadItems($scope.page);

    function simpleLoad(btn, state) {
        if (state) {
            btn.children().addClass('fa-spin');
            btn.contents().last().replaceWith(" Loading");
        } else {
            btn.children().removeClass('fa-spin');
            btn.contents().last().replaceWith(" Refresh");
        }
    }

    $scope.refresh = function(){
        $scope.items = [];
        var btn = $('#loading-example-btn');
        simpleLoad(btn, true);
        $scope.loadItems(function(){
            simpleLoad(btn, false);
        });
    };

});

angularApp.controller('ProjectIndexController', function($scope, StaffApi, LanguageApi){

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
    }, function($pms, $pages){
        $scope.pms = $pms;
    });

    StaffApi.list({
        type: 1
    }, function($sales, $pages){
        $scope.sales = $sales;
    });

    LanguageApi.list({}, function($languages){
        $scope.languages = $languages;
    })
});