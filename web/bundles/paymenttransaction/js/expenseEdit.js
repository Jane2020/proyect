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
    setValidationsEdit();
}

function setValidationsEdit(){
    $("#expenseEdit").validate({
        event: "blur", 
        rules: {
            'expenseEdit[expenseNumber]': {        		
                regex: /^[0-9\-\.\/]+$/ 
            },
            'expenseEdit[expenseRuc]': {        		
                regex: /^[0-9]{13}$/ 
            },
            'expenseEdit[expenseDate]': {        		
                regex: /^\d{2,4}\-\d{1,2}\-\d{1,2}$/
            },   
            'expenseEdit[expenseName]': {        		
                regex: /^[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9\s\_\-\.\@\/]+$/
            },  
            'expenseEdit[expenseAddress]': {        		
                regex: /^[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9\s\_\-\.\@\/]+$/
            },  
            'expenseEdit[expensePhone]': {        		
                regex: /^(?:\+)?\d{9,10}$/ 
            },  
            'expenseEdit[expenseIva]': {        		
                regex: /^(-)?\d+(\.\d\d)?$/
            },  
            'expenseEdit[expenseValue]': {        		
                regex: /^(-)?\d+(\.\d\d)?$/
            }, 
            'expenseEdit[expenseDescription]': {        		
                regex: /^[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9\s\_\-\.\@\/]+$/
            }, 
        },
        messages: {
            'expenseEdit[expenseName]': { 
                regex: 'Por favor ingrese letras (a-z), números (0-9) ó (-),(_),(@).' 
            } ,
            'expenseEdit[expenseRuc]': { 
                regex: 'Por favor ingrese un Ruc Valido.' 
            },
            'expenseEdit[expenseDate]': { 
                regex: 'Por favor ingrese una fecha válida.' 
            } ,
            'expenseEdit[expenseNumber]': { 
                regex: 'Por favor ingrese un numero de factura válido.' 
            } ,
            'expenseEdit[expenseAddress]': { 
                regex: 'Por favor ingrese letras (a-z), números (0-9) ó (-),(_),(@).' 
            } ,
            'expenseEdit[expensePhone]': { 
                regex: 'Por favor ingrese un numero de telefono válido.' 
            } ,
            'expenseEdit[expenseIva]': { 
                regex: 'Por favor ingrese el valor de iva válido.' 
            } ,
            'expenseEdit[expenseValue]': { 
                regex: 'Por favor ingrese el valor de la factura válido.' 
            } ,
            'expenseEdit[expenseDescription]': { 
                regex: 'Por favor ingrese letras (a-z), números (0-9) ó (-),(_),(@).' 
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
	
	$( "#expenseEdit_expenseDate" ).datepicker({ 
		dateFormat: "yy-mm-dd",changeMonth: true, changeYear: true
     });
});

$(document).ready(function(){
	$("#expenseEdit_expenseRuc").keyup(function(){
	if ($(this).val() != '')
	$(this).val($(this).attr('value').replace(/[^0-9']/g, ""));
	});
});

$(document).ready(function(){
	$("#expenseEdit_expenseRuc").keyup(function(){
	if ($(this).val() != '')
	$(this).val($(this).attr('value').replace(/[^0-9']/g, ""));
	});
});

$(document).ready(function(){
	$("#expenseEdit_expenseIva").keyup(function(){
	if ($(this).val() != '')
	$(this).val($(this).attr('value').replace(/[^0-9'\.]/g, ""));
	});
});

$(document).ready(function(){
	$("#expenseEdit_expenseValue").keyup(function(){
	if ($(this).val() != '')
	$(this).val($(this).attr('value').replace(/[^0-9'\.]/g, ""));
	});
});