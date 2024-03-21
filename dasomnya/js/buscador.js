
$(document).ready(function() {
    $("#idbusqueda").keyup(function(e){
        if(e.keyCode==13){
            search_manga();
        }
    });
});
function search_manga(){
    window.location.href="busqueda.php?text="+$("#idbusqueda").val();
}
 