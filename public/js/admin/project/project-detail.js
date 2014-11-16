/**
 * Created by eastagile on 11/11/14.
 */
angularApp.controller('ProjectDetailController', function($scope, $location, ProjectApi, DateFormatter, ProjectStatus,
                                                          ProjectServiceLevel, ProjectPriority){

    $scope.DateFormatter = DateFormatter;
    $scope.ProjectStatus = ProjectStatus;
    $scope.ProjectServiceLevel = ProjectServiceLevel;
    $scope.ProjectPriority = ProjectPriority;

    var params = $location.search();
    var projectId = params['id'];
    ProjectApi.get(projectId, function($project){
        $scope.project = $project;
    });
});