
$(document).ready(function() {

	var mangas = [''];
/*   var mangasjp = [''];
 */
	var codes = [''];

$.getJSON( "../js/manga.json", function( data ) {
  var items = [];
  $.each( data, function( key, val ) {
   let cantidad = data[key].length;
    for (i=0; i < cantidad; i++ ){
    mangas[i] = data[key][i]['title'];
/*     mangas[i][i] = data[key][i]['titlejp']; 
 */    codes[i] = data[key][i]['ID']; 
   }
  });



       $("#searchbar").autocomplete({
        source: mangas,
        select: function( event, ui ) {
					var suggestion = $(ui)[0].item.value
				var index = mangas.indexOf(suggestion);
				var codeTo = codes[index]
					 window.location.href="manga?manga="+codeTo;				                 								
                },
        appendTo:(".menu-container")
         });
       });

});

