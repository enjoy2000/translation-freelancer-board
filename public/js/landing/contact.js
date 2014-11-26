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
    $scope.response = {
        result: null,
        message: null
    };
    $scope.submitted = false;

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
                        $scope.submitted = true;
                        console.log($data);
                        $scope.form = $data['data'];
                        $scope.response.result = $data['result'];
                        $scope.response.message = $data['message'];
                    },
                    error: function($error){
                        $scope.response.result = false;
                        $scope.response.message = 'Please try again later';
                    },
                    complete: function(){
                        $scope.submitted = true;
                    }
                })
            }
        }
    }

    init();
});