const menu    = document.getElementById('menu-label');
const sidebar = document.getElementsByClassName('sidebar')[0];


ceksidebar();

menu.addEventListener('click', function() {
	if(localStorage.getItem('sidebar')==1){
		localStorage.setItem('sidebar', '0');
	}
	else if(localStorage.getItem('sidebar')==0){
		localStorage.setItem('sidebar','1');	
	}
	sidebarClass();
})

function ceksidebar() {
	if (localStorage.getItem('sidebar') == 0) { 
		autoCheck();
		sidebarClass();
	}
}

function sidebarClass() {
	if(!localStorage.getItem('sidebar')){
		localStorage.setItem('sidebar','1');
	}
	if(localStorage.getItem('sidebar')==1){
		sidebar.classList.remove('hide');
	} else {
		sidebar.classList.add('hide');
	}
};

function autoCheck() {
	var checkbox = document.getElementById("menu-checkbox");
	checkbox.checked = true;
}