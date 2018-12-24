/**
 * Created by UTstarcom on 2017/8/23.
 */
(function (window) {
    window.onkeydown = function (event) {
        var key_code = event.which || event.keyCode;
        if (GeneralCtrl.onKeyDown(key_code, event)) {
            return;
        }
        //console.log("Framework onkeydown:" + key_code);
        switch (key_code) {
            case KeyEvent.KEY_LEFT:
                GeneralCtrl.findNextView("left");
                break;
            case KeyEvent.KEY_RIGHT:
                GeneralCtrl.findNextView("right");
                break;
            case KeyEvent.KEY_UP:
                GeneralCtrl.findNextView("up");
                break;
            case KeyEvent.KEY_DOWN:
                GeneralCtrl.findNextView("down");
                break;
            case KeyEvent.KEY_OK:
                GeneralCtrl.onGlobalClickLisenter(GeneralCtrl.currentId);
                break;
            case KeyEvent.SPACE:
                GeneralCtrl.onBackspaceClickLisenter();
                break;
        }
    };
    window["KeyEvent"] = {
        KEY_0: 48, //w
        KEY_1: 49, //w
        KEY_2: 50, //w
        KEY_3: 51, //w
        KEY_4: 52, //w
        KEY_5: 53, //w
        KEY_6: 54, //w
        KEY_7: 55, //w
        KEY_8: 56, //w
        KEY_9: 57, //w
        W: 87, //w
        KEY_UP: 38,//KEY_UP
        a: 65, //a
        KEY_LEFT: 37, //KEY_LEFT
        s: 83, //s
        KEY_DOWN: 40,//KEY_DOWN
        d: 68, //d
        KEY_RIGHT: 39, //KEY_RIGHT
        KEY_OK: 13,//KEY_OK,enter
        KEY_DEL: 46, //KEY_BACK
        KEY_BACK: 32, //KEY_BACK
        SPACE: 8// 空格
    };
    window["Utils"] = {
        getParameter: function (name) {
            var value = undefined;
            try {
                var startIndex = window.location.search.indexOf("?");
                if (startIndex < 0) {
                    return value;
                }
                var params = window.location.search.substring(startIndex + 1);
                var paramList = params.split("&");
                for (var i = 0; i < paramList.length; i++) {
                    var paramStr = paramList[i];
                    if (paramStr.indexOf("=") < 0) {
                        continue;
                    }
                    var tmp = paramStr.split("=");
                    var key = tmp[0];
                    if (key == name) {
                        value = tmp[1];
                        break;
                    }
                }
            } catch (e) {
                console.error(e);
            }
            return value;
        },
        getCookie: function (name) {
            var arr, reg = new RegExp("(^| )" + name + "=([^;]*)(;|$)");
            if (arr = document.cookie.match(reg)) {
                return unescape(arr[2]);
            } else {
                return undefined;
            }
        },
        setCookie: function (name, value) {
            var Days = 1;
            var exp = new Date();
            exp.setTime(exp.getTime() + Days * 24 * 60 * 60 * 1000);
            try {
                var stb_type = Authentication.CTCGetConfig("STBType");
                if (stb_type != undefined && stb_type.indexOf("EC1308H") != -1) {
                    document.cookie = name + "=" + escape(value);
                } else {
                    document.cookie = name + "=" + escape(value) + ";expires=" + exp.toGMTString();
                }
            } catch (e) {
                document.cookie = name + "=" + escape(value) + ";expires=" + exp.toGMTString();
            }
        },
        delCookie: function (name) {
            var exp = new Date();
            exp.setTime(exp.getTime() - 1);
            var cval = getCookie(name);
            if (cval != null)
                document.cookie = name + "=" + cval + ";expires=" + exp.toGMTString();
        },
        getDataByAjax: function (reqMethod, reqUrl, params, resultType, result) {
            var request = new XMLHttpRequest();
            request.onreadystatechange = function () {
                if (request.readyState == 4) {
                    if (resultType == "json") {
                        result && result(request.status, request.responseText);
                    } else {
                        result && result(request.status, request.responseXML);
                    }
                }
            };
            if (reqMethod == "GET") {
                request.open("GET", reqUrl + "?" + params, true);
                request.send()
            } else if (reqMethod == "POST") {
                request.open("POST", options.url, true);
                request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                request.send(params)
            }
        },
        isEmptyString: function (strValue) {
            return strValue == undefined || strValue == "" || strValue == "null" || strValue == null;
        }
    };
    window["GeneralCtrl"] = {
        currentId: undefined,
        currentView: undefined,
        onKeyDown: function (keyCode, event) {
            return false;
        },
        findNextView: function (direction) {
            //console.log("findNextView direction:" + direction + "/ currentId:" + this.currentId);
            if (Utils.isEmptyString(this.currentId)) {
                return;
            }
            var view = document.getElementById(this.currentId);
            if (view == undefined) {
                return;
            }
            var nextId = view.getAttribute(direction);
            if (Utils.isEmptyString(nextId)) {
                return;
            }
            var nextView = document.getElementById(nextId);
            if (nextView == undefined) {
            	
                return;
            }
            this.currentView = nextView;
            this.onGlobalFocusChanged(this.currentId, false);
            this.onGlobalFocusChanged(nextId, true);
            this.currentId = nextId;
        },
        onGlobalFocusChanged: function (id, hasFocused) {
            var flag = this.onGlobalFocusLisenter(id, hasFocused);
            if (flag || Utils.isEmptyString(id)) {
                return;
            }
            if (hasFocused) {
                this.requestFocus(id);
            } else {
                this.releaseFocus(id);
            }
        },
        onGlobalFocusLisenter: function (id, hasFocused) {
            return false;
        },
        onGlobalClickLisenter: function (id) {
        },
        onBackspaceClickLisenter:function(){
        },
        setNextLeftFocuseView: function (id, nextId) {
            if (Utils.isEmptyString(id)) {
                return;
            }
            var view = document.getElementById(id);
            if (view == undefined) {
                return;
            }
            view.setAttribute("left", nextId);
        },
        setNextUpFocuseView: function (id, nextId) {
            if (Utils.isEmptyString(id)) {
                return;
            }
            var view = document.getElementById(id);
            if (view == undefined) {
                return;
            }
            view.setAttribute("up", nextId);
        },
        setNextRightFocuseView: function (id, nextId) {
            if (Utils.isEmptyString(id)) {
                return;
            }
            var view = document.getElementById(id);
            if (view == undefined) {
                return;
            }
            view.setAttribute("right", nextId);
        },
        setNextDownFocuseView: function (id, nextId) {
            if (Utils.isEmptyString(id)) {
                return;
            }
            var view = document.getElementById(id);
            if (view == undefined) {
                return;
            }
            view.setAttribute("down", nextId);
        },
        setNextFocuseView: function (id, nextLeftId, nextUpId, nextRightId, nextDownId) {
            if (Utils.isEmptyString(id)) {
                return;
            }
            var view = document.getElementById(id);
            if (view == undefined) {
                return;
            }
            view.setAttribute("left", nextLeftId);
            view.setAttribute("up", nextUpId);
            view.setAttribute("right", nextRightId);
            view.setAttribute("down", nextDownId);
        },
        setDrawable: function (id, normal_status, selected_status) {
            if (Utils.isEmptyString(id)) {
                return;
            }
            var view = document.getElementById(id);
            if (view == undefined) {
                return;
            }
            view.setAttribute("normal_status", normal_status);
            view.setAttribute("selected_status", selected_status);
        },
        init: function (defaultId) {
            this.currentId = defaultId;
            this.requestFocus(defaultId);
            this.onGlobalFocusLisenter(defaultId, true);
        },
        requestFocus: function (obj) {
            if (obj == undefined) {
                return;
            }
            var view = undefined;
            if (obj instanceof Element) {
                view = obj;
            } else {
                view = document.getElementById(obj);
            }
            if (view == undefined) {
                return;
            }
            var selectedClass = view.getAttribute("selected_status");
            if (selectedClass == undefined) {
                return;
            }
            view.className = selectedClass;
            this.currentView = view;
        },
        releaseFocus: function (obj) {
            if (obj == undefined) {
                return;
            }
            var view = undefined;
            if (obj instanceof Element) {
                view = obj;
            } else {
                view = document.getElementById(obj);
            }
            if (view == undefined) {
                return;
            }
            var normalClass = view.getAttribute("normal_status");
            var selectedClass = view.getAttribute("selected_status");
            if (normalClass == undefined || selectedClass == undefined) {
                return;
            }
            view.className = normalClass;
            this.currentView = undefined;
        }
    };
    window["Map"] = {
        Jdata: {},
        put: function (key, value) {
            this.Jdata[key] = value;
        },
        get: function (key) {
            return this.Jdata[key];
        },
        remove: function (key) {
            this.Jdata[key] = undefined;
        },
        clear: function () {
            this.Jdata = {}
        }
    }
})(window);
