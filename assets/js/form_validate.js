$( document ).ready(function() {
	jQuery("#property-add-form").validate({
		rules:{
			township_name: {
				required:true,	
			},
			country_name: {
				required:true,	
			},
			city_name: {
				required:true,	
			},
			zipcode: {
				required:true,
				number:true,	
			},
			address: {
				required:true,	
			},
		},
		messages:{
			township_name: {
				required:'Please enter township name',
			},
			country_name: {
				required:'Please select country',
			},
			city_name: {
				required:'Please enter city name',
			},
			zipcode: {
				required:'Please enter area zipcode',	
			},
			address: {
				required:'Please enter address',
			},
		}
});
jQuery("#update_property_form").validate({
		rules:{
			township_name: {
				required:true,	
			},
			country_name: {
				required:true,	
			},
			city_name: {
				required:true,	
			},
			zipcode: {
				required:true,
				number:true,	
			},
			address: {
				required:true,	
			},
		},
		messages:{
			township_name: {
				required:'Please enter township name',
			},
			country_name: {
				required:'Please select country',
			},
			city_name: {
				required:'Please enter city name',
			},
			zipcode: {
				required:'Please enter area zipcode',	
			},
			address: {
				required:'Please enter address',
			},
		}
});
});