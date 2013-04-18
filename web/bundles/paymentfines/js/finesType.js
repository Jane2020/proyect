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
    $("#finesTypeSearch").validate({
        event: "blur", 
        rules: {
            'finesTypeSearch[name]': { 
                regex: /^[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9\s\_\-\.\@\/]+$/ 
            }
        },
        messages: {
            'finesTypeSearch[name]': { 
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
