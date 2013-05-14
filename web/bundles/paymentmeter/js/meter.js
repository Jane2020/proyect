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
    $("#meterSearch").validate({
        event: "blur", 
        rules: {
            'meterSearch[accountNumber]': { 
                regex: /^[0-9\-]+$/ 
            }
        },
        messages: {
            'meterSearch[accountNumber]': { 
                regex: 'Por favor ingrese números (0-9) ó (-).' 
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
    $("#meterEdit").validate({
        event: "blur", 
        rules: {
            'meterEdit[accountNumber]': {        		
            	required:true,
                regex: /^[0-9\_\-]+$/
            },
            'meterEdit[meterNumber]': {     
            	required:true,
            	regex: /^[0-9\_\-]+$/ 
            },
            'meterEdit[memberName]': { 
            	required:true            	
            },    
            'meterEdit[accountType]': {        		
            	required:true    
            }
        },
        messages: {
            'meterEdit[accountNumber]': {
            	require:'Por favor ingrese el Número de Cuenta.',
                regex:'Por favor ingrese correctamente el Número de Cuenta.'                	
            } ,
            'meterEdit[meterNumber]': { 
            	require:'Por favor ingrese el Número de Medidor.',
            	regex:'Por favor ingrese correctamente el Número de Medidor.'
            },
            'meterEdit[memberName]': { 
            	require:'Por favor ingrese el Nombre del Miembro.',            	
            } ,
            'meterEdit[accountType]': { 
                regex: 'Por favor ingrese el Tipo de Cuenta.' 
            }            
        },
        debug: true,
        errorElement: "div",
        submitHandler: function(form){
            form.submit();
        }
    });
}