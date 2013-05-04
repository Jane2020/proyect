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
	$("#memberTypeSearch").validate({
        event: "blur", 
        rules: {
            'memberTypeSearch[documentNumber]': { 
                regex: /^[0-9\-]+$/ 
            },
            'memberTypeSearch[name]': { 
                regex: /^[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9\s\_\-\.\/]+$/ 
            }            ,
            'memberTypeSearch[lastname]': { 
                regex: /^[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9\s\_\-\.\/]+$/ 
            }
        },
        messages: {
            'memberTypeSearch[documentNumber]': { 
                regex: 'Por favor ingrese números (0-9) ó (-).' 
            },
            'memberTypeSearch[name]': { 
                    regex: 'Por favor ingrese letras (a-z), números (0-9) ó (-),(_)' 
                },
            'memberTypeSearch[lastname]': { 
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
    $("#memberEdit").validate({
        event: "blur", 
        rules: {
            'memberEdit[documentNumber]': {        		
            	required:true,
                regex: /^(?:\+)?\d{10}$/ 
            },
            'memberEdit[name]': {     
            	required:true,
                regex: /^[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9\s\_\-\.]+$/ 
            },
            'memberEdit[lastname]': { 
            	required:true,
            	regex: /^[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9\s\_\-\.]+$/
            },    
            'memberEdit[birthDate]': {        		
                regex: /^\d{2}\-\d{2}\-\d{4}$/
            },   
            'memberEdit[email]': {        		
            	regex: /^(?:[a-z0-9!#$%&'*+\/=?^_`{|}~-]\.?){0,63}[a-z0-9!#$%&'*+\/=?^_`{|}~-]@(?:(?:[a-z0-9](?:[a-z0-9-]{0,61}[a-z0-9])?\.)*[a-z0-9](?:[a-z0-9-]{0,61}[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\])$/i
            },   
            'memberEdit[address]': {        		
            	regex: /^[a-zA-Z0-9ÁÉÍÓÚÑáéíóúñ\s\,\.\:\;\-\#]+$/
            }, 
            'memberEdit[phone]': {        		
            	regex: /^(?:\+)?\d{9}$/ 
            }, 
            'memberEdit[celularPhone]': {        		
            	regex: /^(?:\+)?\d{10}$/ 
            }
        },
        messages: {
            'memberEdit[documentNumber]': {
            	require:'Por favor ingrese la cédula de identidad.',
                regex:'Por favor ingrese 10 dígitos.'                	
            } ,
            'memberEdit[name]': { 
            	require:'Por favor ingrese el Nombre.',
                regex: 'Valor del nombre es incorrecto.' 
            },
            'memberEdit[lastname]': { 
            	require:'Por favor ingrese el Apellido.',
            	regex: 'Valor del apellido es incorrecto.'
            } ,
            'memberEdit[birthDate]': { 
                regex: 'Valor de la fecha de nacimiento es incorrecta.' 
            } ,
            'memberEdit[email]': { 
                regex: 'Valor del e-mail es incorrecto.' 
            } ,
            'memberEdit[address]': { 
                regex: 'Valor de la dirección es incorrecta.' 
            } ,
            'memberEdit[phone]': { 
                regex: 'Por favor ingrese 9 dígitos.'  
            } ,
            'memberEdit[celularPhone]': { 
                regex: 'Por favor ingrese 10 dígitos.'
            } ,
        },
        debug: true,
        errorElement: "div",
        submitHandler: function(form){
            form.submit();
        }
    });
}