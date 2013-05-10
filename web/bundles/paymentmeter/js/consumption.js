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
    $("#consumptionEdit").validate({
        event: "blur", 
        rules: {
            'consumptionEdit[meterCurrentReading]': {        		
                regex: /^[0-9]{1,11}$/ 
            },
            'consumptionEdit[readDate]': {        		
                regex: /^\d{2,4}\-\d{1,2}\-\d{1,2}$/
            },   
            'consumptionEdit[description]': {        		
                regex: /^[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9\s\_\-\.\@\/]+$/ 
            },  
        },
        messages: {
            'consumptionEdit[description]': { 
                regex: 'Por favor ingrese letras (a-z), números (0-9) ó (-),(_),(@).' 
            } ,
            'consumptionEdit[meterCurrentReading]': { 
                regex: 'Por favor ingrese una lectura válida.' 
            },
            'consumptionEdit[readDate]': { 
                regex: 'Por favor ingrese una fecha de inicio válida.' 
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
	var currentDate = new Date();
	$( "#consumptionEdit_readDate" ).datepicker({ 
		dateFormat: "yy-mm-dd"     }).datepicker('setDate', currentDate);	
});



$(document).ready(function(){
	$("#consumptionEdit_meterCurrentReading").keyup(function(){
	if ($(this).val() != '')
	$(this).val($(this).attr('value').replace(/[^0-9']/g, ""));
	});
});