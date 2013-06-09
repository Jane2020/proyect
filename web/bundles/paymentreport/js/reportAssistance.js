jQuery.noConflict();
var doc = $(document);
doc.ready(loadEvents);
$.validator.addMethod( 
    "regex", 
    function(value, element, regexp) { 
        return this.optional(element) || regexp.test(value); 
    }, 
    "Please check your input." 
    ); 

function loadEvents(){	
	setValidations();   
}

function setValidations(){
	$("#memberAssistanceSearch").validate({
        event: "blur", 
        rules: {
            'memberAssistanceSearch[name]': { 
                regex: /^[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9\s\_\-\.\/]+$/
            }
        },
        messages: {
            'memberAssistanceSearch[name]': 
            { 
                regex: 'Por favor ingrese letras (a-z), números (0-9) ó (-),(_)' 
            }
        },
        debug: true,
        errorElement: "div",
        errorLabelContainer: $("div.error"),
        submitHandler: function(form){
            form.submit();
        }
    });
}

$(function() {
	$( "#memberAssistanceSearch_startDate" ).datepicker({ 
		dateFormat: "yy-mm-dd",changeMonth: true, changeYear: true,
		onSelect: function( selectedDate ) {
            $( "#memberAssistanceSearch_endDate" ).datepicker( "option", "minDate", selectedDate );
    }
     });	
	
	$( "#memberAssistanceSearch_endDate" ).datepicker({ 
		dateFormat: "yy-mm-dd",changeMonth: true,changeYear: true,
	     onSelect: function( selectedDate ) {
	             $( "#memberAssistanceSearch_startDate" ).datepicker( "option", "maxDate", selectedDate );
	     }
		 });	
});