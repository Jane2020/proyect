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
    $("#paymentSearch").validate({
        event: "blur", 
        rules: {
            'paymentSearch[name]': { 
                regex: /^[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9\s\_\-\.\/]+$/ 
            }
        },
        messages: {
            'paymentSearch[name]': { 
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

function setValidationsEdit(){
    $("#paymentEdit").validate({
        event: "blur", 
        rules: {
            'paymentEdit[name]': {        		
                regex: /^[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9\s\_\-\.\@\/]+$/ 
            },
            'paymentEdit[description]': {        		
                regex: /^[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9\s\_\-\.\@\/]+$/ 
            },
            'paymentEdit[cost]': {        		
                regex: /^(-)?\d+(\.\d\d)?$/
            },            
        },
        messages: {
            'paymentEdit[description]': { 
                regex: 'Por favor ingrese letras (a-z), números (0-9) ó (-),(_),(@)' 
            } ,
            'paymentEdit[name]': { 
                regex: 'Por favor ingrese letras (a-z), números (0-9) ó (-),(_),(@)' 
            },
            'paymentEdit[cost]': { 
                regex: 'Por favor ingrese una cantidad valida.' 
            } ,
        },
        debug: true,
        errorElement: "div",
        submitHandler: function(form){
            form.submit();
        }
    });
}

$(document).ready(function(){
	$("#paymentEdit_cost").keyup(function(){
	if ($(this).val() != '')
	$(this).val($(this).attr('value').replace(/[^0-9'\.]/g, ""));
	});
});