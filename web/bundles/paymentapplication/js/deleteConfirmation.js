function dialogOpenRef(url) {
    $( "#dialog" ).html("");
   var id = 0;
    var cid = $('input[id^=cb]');    
    $.each(cid, function(index, value){        
        if(id==0 && value.checked){
            id=value.value;
        }        
    })        
    if(id != 0){
        $.post(url, {
            cid:id,
			link: link
        } ,function(data){
            $( "#dialog" ).html(data);
            $( "#dialog" ).dialog( "open" );
        }); 
	} else {
        alert('Por favor seleccione un elemento para eliminar.');
    }    
}

$(function(){

	function updateTips( t ) {
        $( ".validateTips" )
        .text( t )
        .addClass( "ui-state-highlight" );        
    }

    function checkLength( o, n, min, max ) {
        if ( o.val().length > max || o.val().length < min ) {
            o.addClass( "ui-state-error" );
            updateTips( "La longitud de " + n + " debe estar entre " + min + " y " + max + " caracteres." );
            return false;
        } else {
            return true;
        }
    }

    function checkRegexp( o, regexp, n ) {
        if ( !( regexp.test( o.val() ) ) ) {
            o.addClass( "ui-state-error" );
            updateTips( n );
            return false;
        } else {
            return true;
        }
    }


    $( "#dialog" ).dialog({
        autoOpen: false,
        height: 320,
        width: 330,
        modal: true,
        open:function(){            
            
        },     
        buttons: {
            "Aceptar": function() { 
                var remark = $('#remark');                
                var bValid = true; 
                     
                bValid = bValid && checkLength( remark, "Observación", 6, 512 ); 
                bValid = bValid && checkRegexp( remark, /^[a-zA-Z0-9áéíóúÁÉÍÓÚÑñ_¿?!¡\s\,\.\(\)\:\;\-\#]+$/, "La observación debe contener (a-z) ó (0-9)." );
               
                if ( bValid ) {
                	$('#dialog-form-exec').submit();
                }
            },
            "Cancelar": function() {                
                $( this ).dialog( "close" );
            }
        },
        close: function() {            
        }
    });       
});
