function toggle (){

    // get elements to show/hide
    var items = document.getElementsByClassName('item');
	for (var i=1; i<items.length; i++) {
        // show item
        if (items[i].style.display == ''){
            items[i].style.display = 'block';
        // hide item
        } else {
            items[i].style.display = '';
        }
        }
}
