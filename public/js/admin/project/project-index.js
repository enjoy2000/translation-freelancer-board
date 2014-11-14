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

    var params = $location.search();
    var page = 1;
    if(typeof params['p'] != 'undefined'){
        page = parseInt(params['page']);
    }
    var url = '/api/admin/project';

    ProjectApi.list({
        page: page
    }, function($projects, $pages){
        $scope.items = $projects;
        $scope.pages = $pages;
    });

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

    $scope.remove = remove;

    /** paginator **/

    /** end paginator **/
});

angularApp.controller('ProjectIndexController', function($scope){
    $scope.goToDetail = function($project){
        location.href = "/admin/project/detail/#?id=" + $project.id;
    };

    $scope.goToEdit = function($project){
        location.href = "/admin/project/detail/#edit?id=" + $project.id;
    };
});