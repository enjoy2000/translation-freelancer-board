/**
 * Created by antiprovn on 11/1/14.
 */

angularApp.factory("CurrentUser", function($http) {
    var $user = {};
    $http.get("/api/user/current")
        .success(function($data){
            jQuery.extend(true, $user, $data['user']);
        });

    function price($price){
        return $user.currency + " " + $price;
    }
    return {
        info: $user,
        is_admin: function(){
            return true;
        },
        price: price
    };
});