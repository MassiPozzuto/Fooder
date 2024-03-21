filterproducts("all");
function filterproducts(cname){
  var x,i;
    x = document.getElementsByClassName("box")
    if (cname="all") cname="";
    for (i=0;i<x.length; i++){
        removeClass(x[i], "show");
        if(x[i].className.indexOf(cname) > -1 )addClass(x[i],"show");
    }
    
}

function addClass(element, name){
    var i, arr1, arr2;
    arr1 = element.className.split(" ");
    arr2 = name.split(" ");
    for (i=0; i<arr2.length;i++){
        if(arr1.indexOf(arr2[i]) == -1){
            element.className += " " + arr2[i];
        }
    }
}

function removeClass(element,name){
var i, arr1, arr2;
arr1 = element.className.split(" ");
arr2 = name.split(" ");
for (i=0; i<arr2.length;i++){
    while(arr1.indexOf(arr2[i]) > -1){
        arr1.splice(arr1.indexOf(arr2[i]),1);


    }
}
element.className = arr1.join (" ")
}

