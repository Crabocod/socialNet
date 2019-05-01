function newPost() {
	var a = document.getElementsByClassName('newPost')[0];
	a.classList.toggle("visible");
}
function fileVis(){
	var a = document.getElementsByClassName('addFile')[0];
	a.classList.toggle("visible");
}
function like(id1,login,id){
	var numLike = document.getElementById(id1);
	var request = new XMLHttpRequest();

	request.onreadystatechange = function (){
		if (request.readyState == 4) {
			numLike.innerHTML = request.responseText;
			let elem = document.getElementById(id); 
            if (elem.classList.contains('like1'))
                {   
                    elem.classList.add('like2');
                    elem.classList.remove('like1');
                }
            else 
                {
                    elem.classList.add('like1');
                    elem.classList.remove('like2');
                }
		 }
	}
	request.open('POST', 'ajax.php' );
	request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	request.send('post_id='+id1+'&login='+login);
}
