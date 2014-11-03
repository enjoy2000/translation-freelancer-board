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

angularApp.controller('CreateProjectController', function($scope, $http, $timeout, $q, $sce, CurrentUser, TableItemListService){
    $scope.project = {
        dtps: [],
        translations: [],
        files: []
    };

    $scope.order = {
    };

    $scope.targets = {

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

    $scope.init = function(){
        $http.get("/api/data/project/")
            .success(function($data){
                jQuery.extend(true, $scope, $data);  // copy data to scope
                // trusted html
                trustedHtml();
                var shareData = ['interpretingUnits', 'engineeringUnits', 'dtpUnits'];
                for(var i = 0; i < shareData.length; i++){
                    var key = shareData[i];
                    setModalControllerData(key, $scope[key]);
                }

                $scope.project.targetLanguages = [];
                $timeout(function(){
                    jQuery("select.multiselect").multiselect("destroy").multiselect();
                });
            });
        setModalControllerData('project', $scope.project);
    };

    $scope.projectType = function(){
        if($scope.project.translations.length > 0 || $scope.project.dtps.length > 0){
            return "normal";
        }
        if($scope.project.interpreting){
            return "interpreting";
        }
        return "";
    };

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

    $scope.submit = function(){
        console.log(TableItemListService.data());
        $http.post("/api/admin/project/", $scope.project)
            .success(function($data){

            })
            .error(function($data){

            });
    };

    function existsIdInArray(arr, id){
        for(var i = 0; i < arr.length; i++){
            if(arr[i].id == id){
                return true;
            }
        }
        return false;
    };

    /** order information condition **/
    $scope.hasTypeTranslationNoTM = function(){
        return existsIdInArray($scope.project.translations, 1);
    };
    $scope.hasTypeTranslationUseTM = function(){
        return existsIdInArray($scope.project.translations, 2);
    };
    $scope.hasTypeTranslationShow = function(){
        return $scope.hasTypeTranslationUseTM() || $scope.hasTypeTranslationNoTM();
    };
    $scope.hasTypeDesktopPublishingMacOrWin = function(){
        return $scope.hasTypeDesktopPublishingMac() || $scope.hasTypeDesktopPublishingWin();
    };
    $scope.hasTypeDesktopPublishingMac = function(){
        return existsIdInArray($scope.project.dtps, 1)
    };
    $scope.hasTypeDesktopPublishingWin = function(){
        return existsIdInArray($scope.project.dtps, 2)
    };
    $scope.hasTypeDesktopPublishingEngineer = function(){
        return existsIdInArray($scope.project.dtps, 3);
    };
    /** end order information condition **/

    $scope.getTarget = function(language){
        if(typeof $scope.targets[language.id] == 'undefined'){
            $scope.targets[language.id] = {
                interpretings: []
            };
        }
        return $scope.targets[language.id];
    };

    $scope.init();

    $scope.test = function(){
        console.log($scope.project);
        console.log($scope.order);
    };
});

angularApp.factory("TableItemListService", function(){
    var $scopes = [];
    var listener;
    var isNew = false;
    var modalId = "#modal-interpreting";
    var vars = {
        item: {}
    };
    var itemCloned = {};
    function setListener($scope){
        listener = $scope;
    }
    return {
        addScope: function($scope){
            if($scopes.indexOf($scope) === -1){
                $scopes.push($scope);
            }
        },
        data: function(){
            var data = [];
            for(var i = 0; i < $scopes.length; i++){
                data.push($scopes[i].data());
            }
            return data;
        },
        cancel: function(){
            jQuery.extend(true, vars.item, itemCloned);
            $(modalId).modal("hide");
        },
        save: function(){
            $(modalId).find("form").validate();
            if(!$(modalId).find("form").valid()){
                return;
            }
            if(isNew){
                listener.add(vars.item);
            }
            $(modalId).modal("hide");
        },
        setModalId: function(id){
            modalId = id;
        },
        showModal: function($scope, $item){
            if($item === false){
                $item = {};
                isNew = true;
            } else {
                isNew = false;
            }
            setListener($scope);
            vars.item = $item;
            itemCloned = {};
            jQuery.extend(true, itemCloned, $item);
            $(modalId).modal("show");
        },
        vars: vars
    }
});

angularApp.controller('TableItemController', function($scope, CurrentUser, TableItemListService){
    $scope.CurrentUser = CurrentUser;
    $scope.TableItemListService = TableItemListService;
    $scope.localIdentifier = $scope.identifier;
    $scope.items = [];
    $scope.$modalId = "";
    TableItemListService.addScope($scope);
    $scope.add = function($item){
        $scope.items.push($item);
    };
    $scope.remove = function($index){
        $scope.items.splice($index, 1);
    };
    $scope.showModal = function($item){
        TableItemListService.setModalId($scope.$modalId);
        TableItemListService.showModal($scope, $item);
    };
    $scope.setModalId = function($modalId){
        $scope.$modalId = $modalId;
    }
    $scope.data = function(){
        return {
            items: $scope.items,
            identifier: $scope.localIdentifier
        };
    }
});

angularApp.controller('TableModalController', function($scope, TableItemListService){
    $scope.TableItemListService = TableItemListService;
    $scope.vars = TableItemListService.vars;
});