/**
 * Created by antiprovn on 9/29/14.
 */
angularApp.controller("ModalController", function($scope){
    $scope.setData = function(name, value){
        $scope[name] = value;
    };
});