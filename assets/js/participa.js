(function($){
    var participacion = {
        init : function(){
            this.bindEvents();
            return this;
        },
        bindEvents : function(){
            $('#institucion').chosen();
            $('#categoria').chosen({max_selected_options: 5});
        }
    }
        $(function(){
        window.participacion = participacion.init();
    });
})(jQuery);

function ValidaSoloNumeros() {
    if ((event.keyCode < 48) || (event.keyCode > 57)) 
    event.returnValue = false;
}