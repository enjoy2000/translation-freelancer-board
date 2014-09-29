/**
 * Created by antiprovn on 9/29/14.
 */
angularApp.run(function($rootScope){
    jQuery("#modalContainer form").each(function(){
        jQuery(this).validate({
            errorPlacement: function (error, element) {
                element.before(error);
            }
        });
    });
});
angularApp.controller("ModalController", function($scope){

    /**
     * Set data to controller
     * @param name
     * @param value
     */
    $scope.setData = function(name, value){
        $scope[name] = value;
    };

    /**
     * Post data back to main controller
     * @param modalSelector to find form and do the validation
     * @param element in target controller
     * @param function name in target controller
     * @param ... param list passed to target controller
     */
    $scope.submitTo = function(){
        var isValid = true;

        var modalSelector = arguments[0];
        if(modalSelector){
            var form = jQuery(modalSelector).find("form");
            form.validate().settings.ignore = ":disabled,:hidden";
            isValid = form.valid();
        }

        if(isValid){
            var elementSelector = arguments[1];
            var functionName = arguments[2];
            var args = [];
            for(var i = 3; i < arguments.length; i++){
                args.push(arguments[i]);
            }
            angular.element(elementSelector).scope()[functionName].apply(null, args);
        }
    }
});