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
    $("#expenseSearch").validate({
        event: "blur", 
        rules: {
            'expenseSearch[expenseName]': { 
                regex: /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/
            },
            'expenseSearch[expenseRuc]': { 
                regex: /^[0-9]+$/ 
            },
        },
        messages: {
            'expenseSearch[expenseName]': { 
                regex: 'Por favor ingrese letras (a-z)' 
            } ,
            'expenseSearch[expenseRuc]': { 
            	regex: 'Por favor ingrese números (0-9).' 
            } ,
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
	
	$( "#expenseSearch_expenseDate" ).datepicker({ 
		dateFormat: "yy-mm-dd",
     });
});

$(document).ready(function(){
	$("#expenseSearch_expenseRuc").keyup(function(){
	if ($(this).val() != '')
	$(this).val($(this).attr('value').replace(/[^0-9']/g, ""));
	});
});