/**
 * Created by antiprovn on 10/8/14.
 */
angularApp.run(function($rootScope){
    var i = 1;
    var element = jQuery("#files > input")[0];
    var elementCloned = jQuery(element).clone(true);
    function addFile(element){
        angular.element(element).scope().addFile(element);
        jQuery(element).filestyle("destroy");
        jQuery(element).hide();
        var newElement = jQuery(elementCloned).clone(true);
        newElement.prop('id', "filestyle-" + i);
        i++;
        jQuery(element).after(newElement);
        jQuery(newElement).filestyle({
            input: false,
            icon: false,
            buttonText: "Add files",
            buttonName: "btn-xs btn-primary",
            badge: false
        });
        jQuery(newElement).change(function(){
            addFile(this);
        });
    }
    jQuery(element).filestyle({
        input: false,
        icon: false,
        buttonText: "Add files",
        buttonName: "btn-xs btn-primary",
        badge: false
    });
    jQuery(element).change(function(){
        addFile(this);
    });
});
angularApp.controller('CreateProjectController', function($scope, $http, $timeout, $q, $sce){
    $scope.project = {
        dtps: [],
        translations: [],
        files: []
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

                $scope.project.targetLanguages = [];
                $timeout(function(){
                    jQuery("select.multiselect").multiselect("destroy").multiselect();
                });
            });
    }

    $scope.projectType = function(){
        if($scope.project.translations.length > 0 || $scope.project.dtps > 0){
            return "normal";
        }
        if($scope.project.interpreting){
            return "interpreting";
        }
        return "";
    }

    $scope.setInterpreting = function($interpreting){
        jQuery(".project-types .active").removeClass("active");
        $scope.project.translations = [];
        $scope.project.dtps = [];
        $scope.project.interpreting = $interpreting;
    };

    $scope.clearInterpreting =function (){
        jQuery("#project-interpreting .active").removeClass("active");
        jQuery("#project-interpreting :checked").prop("checked", false);
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

    $scope.addFile = function($fileInput){
        for(var i = 0; i < $fileInput.files.length; i++){
            var file = $fileInput.files[i];
            var file_time = file.lastModifiedDate.getYear() + "-"
                + file.lastModifiedDate.getMonth() + "-"
                + file.lastModifiedDate.getDate() + " "
                + file.lastModifiedDate.getHours() + ":"
                + file.lastModifiedDate.getMinutes() + ":"
                + file.lastModifiedDate.getSeconds()
            $scope.project.files.push({
                name: file.name,
                size: Math.ceil(file.size / 1024) + " Kb",
                time: file_time
            });
        }
        $timeout(function(){});  // made template re-render
    };

    $scope.removeFile = function($index){
        $scope.project.files.splice($index, 1);
        jQuery("#files input").slice($index, $index + 1).remove();
    };

    init();

    $scope.test = function(){
        console.log($scope.project);
    };
});