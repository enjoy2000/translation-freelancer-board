/**
 * Created by antiprovn on 9/28/14.
 */

function findOption(options, value){
    for(var i = 0; i < options.length; i++){
        if(options[i].select == value.select){
            return options[i];
        }
    }
    return value;
}

function findOptions(options, ids){
    var values = [];
    for(var i = 0; i < options.length; i++){
        if(ids.indexOf(options[i].id)!=-1){
            values.push(options[i]);
        }
    }
    return values;
}

function getIds(objects, attr){
    var ids = [];
    for(var i = 0; i < objects.length; i++){
        if(attr){
            ids.push(objects[i][attr]);
        } else {
            ids.push(objects[i].id);
        }
    }
    return ids;
}

/**
 * Call a function only once if success
 * usage: callOnce(function[, param1, param2...])
 * @returns {*}
 */
function callOnce(){
    window.callOnceSuccess = window.callOnceSuccess || [];
    var func = arguments[0];
    if(window.callOnceSuccess.indexOf(func) !== -1){
        return false;
    }
    var args = [];
    for(var i = 1; i < arguments.length; i++){
        args.push(arguments[i]);
    }
    if(result = func.apply(args)){
        window.callOnceSuccess.push(func);
        return result;
    }
    return false;
}

function setModalControllerData(key, value){
    angular.element("#modalContainer").scope().setData(key, value);
}