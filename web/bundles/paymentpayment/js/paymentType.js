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
    $("#paymentTypeSearch").validate({
        event: "blur", 
        rules: {
            'paymentTypeSearch[name]': { 
                regex: /^[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9\s\_\-\.\/]+$/ 
            }
        },
        messages: {
            'paymentTypeSearch[name]': { 
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
    $("#paymentTypeEdit").validate({
        event: "blur", 
        rules: {
            'paymentTypeEdit[name]': {        		
                regex: /^[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9\s\_\-\.\@\/]+$/ 
            },
            'paymentTypeEdit[description]': {        		
                regex: /^[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9\s\_\-\.\@\/]+$/ 
            },
            'paymentTypeEdit[cost]': {        		
                regex: /^(-)?\d+(\.\d\d)?$/
            },            
        },
        messages: {
            'paymentTypeEdit[description]': { 
                regex: 'Por favor ingrese letras (a-z), números (0-9) ó (-),(_),(@)' 
            } ,
            'paymentTypeEdit[name]': { 
                regex: 'Por favor ingrese letras (a-z), números (0-9) ó (-),(_),(@)' 
            },
            'paymentTypeEdit[cost]': { 
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
	$("#paymentTypeEdit_cost").keyup(function(){
	if ($(this).val() != '')
	$(this).val($(this).attr('value').replace(/[^0-9'\.]/g, ""));
	});
});