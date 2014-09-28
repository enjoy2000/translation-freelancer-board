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
