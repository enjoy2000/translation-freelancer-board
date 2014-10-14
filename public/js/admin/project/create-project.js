/**
 * Created by antiprovn on 10/8/14.
 */
angularApp.controller('CreateProjectController', function($scope, $http, $timeout, $q, $sce){
    $scope.project = {
        dtps: [],
        translations: []
    };

    function trustedHtml(){
        var keys = ['dtps'];
        for(var i = 0; i < keys.length; i++){
            var key = keys[i];
            for(var j = 0; j < $scope[key].length; j++){
                $scope[key][j].name = $sce.trustAsHtml($scope[key][j].name)
            }
        }
    }

    function init(){
        $http.get("/api/data/project/")
            .success(function($data){
                jQuery.extend(true, $scope, $data);  // copy data to scope

                // trusted html
                trustedHtml();

                $scope.project.sourceLanguage = $scope.languages[0];
                $scope.project.targetLanguages = [];
                $timeout(function(){
                    jQuery("select.multiselect").multiselect("destroy").multiselect();
                });
            });
    }

    $scope.setInterpreting = function($interpreting){
        jQuery(".project-types .active").removeClass("active");
        $scope.project.translations = [];
        $scope.project.dtps = [];
        $scope.project.interpreting = $interpreting;
    };

    $scope.clearInterpreting =function (){
        jQuery("#project-interpreting .active").removeClass("active");
        $scope.project.interpreting = null;
    };

    $scope.addTranslation = function($translation){
        $scope.clearInterpreting();
        var $index = $scope.project.translations.indexOf($translation);
        if($index == -1){
            $scope.project.translations.push($translation);
        } else {
            $scope.project.translations.splice($index, 1);
        }
    };

    $scope.addDtp = function($dtp){
        $scope.clearInterpreting();
        var $index = $scope.project.dtps.indexOf($dtp);
        if($index == -1){
            $scope.project.dtps.push($dtp);
        } else {
            $scope.project.dtps.splice($index, 1);
        }
    };

    init();

    $scope.test = function(){
        console.log($scope.project);
    };
});