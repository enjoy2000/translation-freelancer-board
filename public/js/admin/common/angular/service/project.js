/**
 * Created by eastagile on 11/11/14.
 */
angularApp.factory("ProjectStatus", function(){
    var statuses = [{
        'id': 1,
        'name': 'Quote',
        'decorator': 'info'
    },{
        'id': 2,
        'name': 'Ordered',
        'decorator': 'danger'
    }];
    return {
        get: function ($id) {
            for (var i = 0; i < statuses.length; i++) {
                if (statuses[i].id == $id) {
                    return statuses[i];
                }
            }
        },
        all: function () {
            return statuses;
        }
    }
});


angularApp.factory("ProjectServiceLevel", function(){
    var levels = [{
        decorator: 'success',
        id: 1,
        name: 'Professional',
        price: {
            USD: 1.00,
            CNY: 10.00
        }
    },{
        decorator: 'info',
        id: 2,
        name: 'Business',
        price: {
            USD: 2.00,
            CNY: 20.00
        }
    }, {
        decorator: 'primary',
        id: 3,
        name: 'Premium',
        price: {
            USD: 3.00,
            CNY: 30.00
        }
    }];
    return {
        get: function($id){
            for(var i = 0; i < levels.length; i++){
                if(levels[i].id == $id){
                    return levels[i];
                }
            }
        },
        all: function(){
            return levels;
        }
    }
});


angularApp.factory("DateFormatter", function(){
    var month_names_short = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    function short($date){
        var date = new Date($date.date);
        return date.getFullYear() + "." + month_names_short[date.getMonth()] + "." + date.getDate();
    }

    return {
        short: short
    }
});


angularApp.factory("ProjectApi", function($http){
    return {
        get: function($id, $func){
            return $http.get("/api/admin/project/" + $id)
                .success(function($data){
                    var project = $data.project;
                    $func(project);
                });
        },
        list: function($params, $func){
            return $http.get("/api/admin/project/?" + jQuery.param($params))
                .success(function($data){
                    var projects = $data.projects;
                    var pages = $data.pages;
                    $func(projects, pages);
                });
        },
        delete: function($id, $func){
            return $http.delete("/api/admin/project/" + $id)
                .success(function($data){
                    $func();
                });
        }
    }
});