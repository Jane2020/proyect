jQuery.noConflict();
$.validator.addMethod( 
    "regex", 
    function(value, element, regexp) { 
        return this.optional(element) || regexp.test(value); 
    }, 
    "Please check your input." 
    );
function validateForm() {
    $(document).ready(function(){
        $("#mensaje").hide();
        $("#filter").validate({
            event: "blur",
            rules: {
                'filter[documentNumber]': {
                	regex: /^[0-9]+$/ 
                },
                'filter[name]': {
                	regex: /^[ a-zA-ZáéíóúÁÉÍÓÚñÑ0-9\_\.]+$/ 
                }             
            },
            messages: {
                'filter[documentNumber]': {
                	'regex':"Por favor ingrese números (0-9)"     
                }, 
                'filter[name]': {
                	'regex':"Por favor ingrese letras (a-z), (0-9), (.) ó (_)"     
                }                
            },
            debug: true,
            errorElement: "div",
            submitHandler: function(form){                    
                form.submit();
            }
        });
    });
}