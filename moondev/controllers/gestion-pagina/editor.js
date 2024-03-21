"use strict";

/* global show_modal */
window.show_modal = function show_modal(id) {
    document.getElementById(id).style.display = "block";
}

window.hide_modal = function hide_modal(id) {
    document.getElementById(id).style.display = "none";
}

window.edit = function edit(id) {
    window.stop_iterating = false;
    window.inputs = document.querySelectorAll(".ingresadores");
    var table_object = document.getElementById("table_" + id).childNodes;
    window.edit_iterator = 0;
    var input_selected;
    table_object.forEach(element => {
        if (window.stop_iterating == false) {
            if (window.inputs[window.edit_iterator] == null) {
                window.stop_iterating = true;
            } else {
                if (!(/div/.test(element.innerHTML))) {
                    /*console.log("\n");
                    console.log(window.inputs[window.edit_iterator]);
                    console.log(window.inputs[window.edit_iterator].id);*/
                    input_selected = document.getElementById(window.inputs[window.edit_iterator].id).value = element.innerHTML;
                    window.edit_iterator++;
                }
            }
        }
    });
    show_modal("modal-object-edit");
}