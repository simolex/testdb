function toggleElement(id) {
	var Obj = document.getElementById(id);
	if (Obj.style.display != 'none')
		Obj.style.display = 'none';
	else
		Obj.style.display = 'inline';
}
