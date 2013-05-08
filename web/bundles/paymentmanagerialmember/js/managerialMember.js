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
    $("#managerialMemberSearch").validate({
        event: "blur", 
        rules: {
            'managerialMemberSearch[name]': { 
                regex: /^[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9\s\_\-\.\@\/]+$/ 
            }
        },
        messages: {
            'managerialMemberSearch[name]': { 
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
    $("#managerialMemberEdit").validate({
        event: "blur", 
        rules: {
            'managerialMemberEdit[memberName]': {        		
                required: true
            },
            'managerialMemberEdit[charge]': {        		
            	required: true 
            },
            'managerialMemberEdit[managerial]': {        		
            	required: true
            },            
        },
        messages: {
            'managerialEdit[memberName]': { 
            	require: 'Por favor ingrese el nombre del miembro.' 
            } ,
            'managerialEdit[charge]': { 
            	require: 'Por favor ingrese el cargo.' 
            },
            'managerialEdit[managerial]': { 
            	require: 'Por favor ingrese la directiva.' 
            } ,          
        },
        debug: true,
        errorElement: "div",
        submitHandler: function(form){
            form.submit();
        }
    });
}

$(function() {
	
	$( "#managerialMemberEdit_activationDate" ).datepicker({ 
		dateFormat: "yy-mm-dd",
		onSelect: function( selectedDate ) {
            $( "#managerialMemberEdit_desactivationDate" ).datepicker( "option", "minDate", selectedDate );
    }
     });	
	
	$( "#managerialMemberEdit_desactivationDate" ).datepicker({ 
		dateFormat: "yy-mm-dd",
	     onSelect: function( selectedDate ) {
	             $( "#managerialMemberEdit_activationDate" ).datepicker( "option", "maxDate", selectedDate );
	     }
		 });	
});