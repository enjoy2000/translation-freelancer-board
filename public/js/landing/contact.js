angularApp.controller('contactController', function($scope, $http) {
    $scope.form = {
        firstName: null,
        lastName: null,
        phone: null,
        email: null,
        company: null,
        jobTitle: null,
        comments: null
    };

    function init(){
        $('form[name=contactForm]').validate();

        // show price
        $scope.submitForm = function(){
            var validate = $('form[name=contactForm]').valid();
            if(validate == true){
                jQuery.ajax({
                    url: '/landing/index/contact-post/',
                    type: 'get',
                    data: $scope.form,
                    success: function($data){
                        console.log($data);
                    }
                })
            }
        }
    }

    init();
});