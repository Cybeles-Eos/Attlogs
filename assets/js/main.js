/** 
*-----------------------------------
* Common jQuery for the whole site.
*-----------------------------------
*/
(function () {
	"use strict";
	globallyAjaxHeaderSet();
	tooltipsbootstrap();
});

/*
* This function we are using for setup globally ajax header
*/
function globallyAjaxHeaderSet(){
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
}	

function tooltipsbootstrap(){
	var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
	var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
		return new bootstrap.Tooltip(tooltipTriggerEl)
	});
}
