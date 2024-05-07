/************************************************** */
/*          Transparency section                    */
/************************************************** */
// Obtén el hash de la URL
var urlHref = window.location.href;

console.log(urlHref);


// Obtén la lista usando querySelectorAll
var list = document.querySelectorAll("ul.menu li a");

// Recorre los elementos de la lista y compara la url del elemento con la url de la URL
for (var i = 0; i < list.length; i++) {
	var itemText = list[i].href;
	if (itemText === urlHref) {
		list[i].setAttribute('style', 'color: #F3921A !important; font-weight: bold !important');
		
	}
	console.log("El texto del elemento de lista es: ", itemText);
} 