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