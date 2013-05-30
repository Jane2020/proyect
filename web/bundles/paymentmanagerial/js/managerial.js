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
    setValidationsEdit();
}

function setValidations(){
    $("#managerialSearch").validate({
        event: "blur", 
        rules: {
            'managerialSearch[name]': { 
                regex: /^[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9\s\_\-\.\@\/]+$/ 
            }
        },
        messages: {
            'managerialSearch[name]': { 
                regex: 'Por favor ingrese letras (a-z), números (0-9) ó (-),(_),(@)' 
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

function setValidationsEdit(){
    $("#managerialEdit").validate({
        event: "blur", 
        rules: {
            'managerialEdit[name]': {        		
                regex: /^[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9\s\_\-\.\@\/]+$/ 
            },
            'managerialEdit[ruc]': {        		
                regex: /^[0-9]{13}$/ 
            },
            'managerialEdit[startDate]': {        		
                regex: /^\d{2,4}\-\d{1,2}\-\d{1,2}$/
            },   
            'managerialEdit[endDate]': {        		
                regex: /^\d{2,4}\-\d{1,2}\-\d{1,2}$/
            },  
        },
        messages: {
            'managerialEdit[name]': { 
                regex: 'Por favor ingrese letras (a-z), números (0-9) ó (-),(_),(@).' 
            } ,
            'managerialEdit[ruc]': { 
                regex: 'Por favor ingrese un Ruc Valido.' 
            },
            'managerialEdit[startDate]': { 
                regex: 'Por favor ingrese una fecha de inicio válida.' 
            } ,
            'managerialEdit[endDate]': { 
                regex: 'Por favor ingrese una fecha de fin válida.' 
            } ,
        },
        debug: true,
        errorElement: "div",
        submitHandler: function(form){
            form.submit();
        }
    });
}

$(function() 
		 {
			$( "#managerialEdit_startDate" ).datepicker({dateFormat: "yy-mm-dd",  changeMonth: true,
				changeYear: true});
		 });

$(function() 
		 {
			$( "#managerialEdit_endDate" ).datepicker({dateFormat: "yy-mm-dd",  changeMonth: true,
				changeYear: true});
		 });

$(function() {
	
	$( "#managerialEdit_startDate" ).datepicker({ 
		dateFormat: "yy-mm-dd",
		onSelect: function( selectedDate ) {
            $( "#managerialEdit_endDate" ).datepicker( "option", "minDate", selectedDate );
    }
     });	
	
	$( "#managerialEdit_endDate" ).datepicker({ 
		dateFormat: "yy-mm-dd",
	     onSelect: function( selectedDate ) {
	             $( "#managerialEdit_startDate" ).datepicker( "option", "maxDate", selectedDate );
	     }
		 });	
});

$(document).ready(function(){
	$("#managerialEdit_ruc").keyup(function(){
	if ($(this).val() != '')
	$(this).val($(this).attr('value').replace(/[^0-9']/g, ""));
	});
});