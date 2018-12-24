/*
* Storage存储工具   兼容localStorage、cookie，优先采用localStorage
*
* 设置参数
* @function set( key, value );
*
* 获取参数
* @function get( key );
*
* 删除参数
* @function remove( key );
*
* 清除所有参数
* @function remove();
*
* */


var Storage = (function (window) {
    var _Cookie = {
        expires: 31536000000,
        path: "/",
        set: function (key, value, expires) {
            if (key == "" || typeof(key) != "string" || key.match(/[,; ]/)) return false;
            if (value.toString().match(/[,; ]/) || typeof(value) == "undefined") return false;
            if (expires==undefined||expires <= 0 || typeof(expires) != "number") expires = this.expires;
            var dt = new Date();
            dt.setTime(dt.getTime() + expires);
            document.cookie = key + "=" + encodeURIComponent(value) + ";expires=" + dt.toGMTString() + ";path=" + this.path;
            return true;
        },
        get: function (key) {
            if (key == "" || typeof(key) != "string" || key.match(/[,; ]/)) return null;
            var cookie = document.cookie;
            return cookie.match( new RegExp(""+key+"=([^;][^;]*)") )?decodeURIComponent( RegExp.$1 ):null;
        },
        remove: function (key) {
            if (key == "" || typeof(key) != "string" || key.match(/[,; ]/)) return false;
            var dt = new Date();
            dt.setTime(dt.getTime());
            document.cookie = key + "=" + encodeURIComponent("") + ";expires=" + dt.toGMTString() + ";path=" + this.path;
            return true;
        },
        clear: function () {
            var keys = document.cookie.match(/[^ =;]+(?=\=)/g);
            if(keys) {
                for(var i = keys.length; i--;){
                    this.del(keys[i]);
                }
            }
        }
    };
    var _Storage = {
        set: function(key, value) {
            if (key == "" || typeof(key) != "string" || key.match(/[,; ]/)) return false;
            if (value.toString().match(/[;]/) || typeof(value) == "undefined") return false;
            localStorage.setItem(key, value);
            return true;
        },
        get: function(key) {
            if (key == "" || typeof(key) != "string" || key.match(/[,; ]/)) return null;
            var value = localStorage.getItem(key);
            if (value) {
                try {
                    var value_json = JSON.parse(value);
                    if (typeof value_json === 'object') {
                        return value_json;
                    } else if (typeof value_json === 'number') {
                        return value_json;
                    }
                } catch(e) {
                    return value;
                }
            } else {
                return null;
            }
        },
        remove: function(key) {
            localStorage.removeItem(key);
            return true;
        },
        clear: function() {
            localStorage.clear();
        }
    };

    var adapter = "";
    if (window.sessionStorage!=undefined) {
        adapter = _Storage;
    } else {
        adapter = _Cookie;
    }
    return {
        get: function( key ) {
            return adapter.get( key );
        },
        set: function( key ,value ,expires) {
            return adapter.set( key ,value ,expires );
        },
        remove: function( key ) {
            return adapter.remove( key );
        },
        clear: function() {
            adapter.clear();
        }

    }
})(window);


