"use strict";

import { message } from "../message_handler.js";

$.ajaxSetup({
    async: false
});

if (typeof window.jsonresult === 'undefined') {
    $.getJSON("../controllers/failed/failed_messages.json", function (jsonresult) {
        window.jsonresult = jsonresult;
    });
    $.getJSON("../api/mysqli_messages.json", function (jsonresult) {
        //Esto fusiona dos objetos en uno solo.
        $.extend(window.jsonresult, jsonresult);
    });
}

var cookie = document.getElementById("cookie_error").innerHTML;
if (cookie == "") {
    message("global.non_error", 500, window.jsonresult);
} else {
    let parsed_cookie = JSON.parse(cookie);
    message(parsed_cookie["message"], "global_error", window.jsonresult)
}