/**
 * Created by eastagile on 11/11/14.
 */
angularApp.controller('ProjectDetailController', function($scope, $location, ProjectService){
    var params = $location.search();
    var projectId = params['id'];
    ProjectService.get(projectId, function($project){
        $scope.project = $project;
    });
});