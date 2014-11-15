/**
 * Created by eastagile on 11/11/14.
 */
angularApp.controller('ItemListController', function($scope, $location, ProjectApi, ProjectServiceLevel, ProjectStatus,
                                                     DateFormatter, CurrentUser, $timeout){
    $scope.CurrentUser = CurrentUser;
    $scope.DateFormatter = DateFormatter;
    $scope.ProjectApi = ProjectApi;
    $scope.ProjectServiceLevel = ProjectServiceLevel;
    $scope.ProjectStatus = ProjectStatus;
    $scope.pages = {};
    $scope.maxSize = 7;
    $scope.page = 1;

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

    $scope.loadItems = function(){
        ProjectApi.list({
            page: $scope.page
        }, function($projects, $pages){
            $scope.items = $projects;
            $scope.pages =$pages;
        });
    }

    function pageChanged(){
        $scope.loadItems();
        console.log("Change to page " + $scope.page);
    }

    $scope.pageChanged = pageChanged;
    $scope.remove = remove;

    $scope.loadItems();
});

angularApp.controller('ProjectIndexController', function($scope){
    $scope.goToDetail = function($project){
        location.href = "/admin/project/detail/#?id=" + $project.id;
    };

    $scope.goToEdit = function($project){
        location.href = "/admin/project/detail/#edit?id=" + $project.id;
    };

    $scope.refresh = function(){
        angular.element('#projectsList').scope().loadItems();
    }
});