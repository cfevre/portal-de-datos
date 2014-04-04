(function($){
    var users = {
        init : function(){
            this.bindEvents();
            return this;
        },
        bindEvents : function(){
            if($('.form-filtros').length || $('#fromUsuario').length){
                $('#servicio').chosen();
            }
        },
        generateApiToken : function (userId, token) {
            $('.api-toke-container').html(token);
        }
    };

    $(function(){
       window.users = users.init();
    });
})(jQuery);