import { customRef } from "vue";

export function debounceRef(value, delay){
    let timeout
    return customRef(function(track, trigger){
        return {
            get: function(){
                track()
                return value
            },
            set: function(newValue){
                clearTimeout(timeout)
                timeout = setTimeout(function(){
                    value = newValue
                    trigger()
                }, delay);
            }
        }
    })
}
