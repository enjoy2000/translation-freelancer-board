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
    },{
        'id': 3,
        'name': 'Ongoing',
        'decorator': 'danger'
    },{
        'id': 4,
        'name': 'Reviewing',
        'decorator': 'danger'
    },{
        'id': 5,
        'name': 'Completed',
        'decorator': 'danger'
    },{
        'id': 6,
        'name': 'Rejected',
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


angularApp.factory("ProjectPriority", function(){
    var priorities = [{
        id: 1,
        name: 'Normal',
        decorator: 'primary'
    }, {
        id: 2,
        name: 'High',
        decorator: 'danger'
    }];

    return {
        get: function ($id) {
            for (var i = 0; i < priorities.length; i++) {
                if (priorities[i].id == $id) {
                    return priorities[i];
                }
            }
        },
        all: function () {
            return priorities;
        }
    }
});


angularApp.factory("ProjectField", function(){
    var fields = [{
        'id': 1,
        'name': 'Field 1'
    },{
        'id': 2,
        'name': 'Field 2'
    },{
        'id': 3,
        'name': 'Field 3'
    },{
        'id': 4,
        'name': 'Field 4'
    }];
    return {
        get: function ($id) {
            for (var i = 0; i < fields.length; i++) {
                if (fields[i].id == $id) {
                    return fields[i];
                }
            }
        },
        all: function () {
            return fields;
        }
    }
});


angularApp.factory("PayStatus", function(){
    var statuses = [{
        'id': 1,
        'name': 'Paid'
    },{
        'id': 2,
        'name': 'Unpaid'
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
    var month_names_full = [ "January", "February", "March", "April", "May", "June",
                             "July", "August", "September", "October", "November", "December" ];
    function short($date){
        var date = new Date($date.date);
        // 2014.Oct.10
        return date.getFullYear() + "." + month_names_short[date.getMonth()] + "." + date.getDate();
    }

    function format($date){
        if(typeof($date) == 'undefined'){
            return "";
        }
        var date = new Date($date.date);
        //15 October 2014 - 11:04 AM
        var hour = date.getHours();
        var t = "AM";
        if(hour > 12){
            hour = hour -12;
            t = "PM";
        }
        return date.getDate() + " " + month_names_full[date.getMonth()] + " " + date.getFullYear()
                + " - " + hour + ":" + date.getSeconds() + " " + t;
    }

    return {
        short: short,
        format: format
    }
});


angularApp.factory("API", function($http){

    function factory(url, singleKey, multipleKey){
        if(url[url.length - 1] != '/'){
            url += "/";
        }

        function get($id, $func){
            return $http.get(url + $id)
                .success(function($data){
                    var obj = $data[singleKey];
                    $func(obj);
                });
        }

        function list($params, $func){
            return $http.get(url + "?" + jQuery.param($params))
                .success(function($data){
                    var objs = $data[multipleKey];
                    var pages = $data.pages;
                    $func(objs, pages);
                });
        }

        function del($id, $func){
            return $http.delete(url + $id)
                .success(function($data){
                    var obj = $data[singleKey];
                    $func(obj);
                });
        }

        return {
            get: get,
            list: list,
            delete: del
        }
    }

    return {
        factory: factory
    };
});


angularApp.factory("ProjectApi", function(API){
    return API.factory('/api/admin/project/', 'project', 'projects');
});


angularApp.factory("StaffApi", function(API){
    return API.factory('/api/admin/staff/', 'staff', 'staffs');
});

angularApp.factory("LanguageApi", function(API){
    return API.factory('/api/admin/language/', 'language', 'languages');
});