function addParam(){
	
	let element = "";
	
	element += "<a>Param <font onclick=\"delParam(this);\">del</font></a>";
	element += "<input type=\"text\" name=\"params[]\" value=\"\">";
	element += "<input type=\"text\" name=\"values[]\" value=\"\">";
	
	//
	
	let parent = document.querySelector('#params');

	//
	
	let p = document.createElement('div');
	p.className = "param";
	p.innerHTML = element;

	//
	
	parent.appendChild(p);
}

function delParam(element){
	
	element.parentNode.parentNode.remove();
}