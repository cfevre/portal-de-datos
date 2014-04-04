(function($){
    var servicio = {
        init : function(){
            servicio.admin_url = $('#admin_url').val();
            servicio.codigo = $('#codigo-servicio').val();
            servicio.modal = $('#modal-backend');
            servicio.cacheElements();
            servicio.bindEvents();
            servicio.initPlugins();
            return servicio;
        },
        cacheElements : function(){
            servicio.formSeleccionarTodos = $('#form-seleccionar-todos');
            servicio.checkSeleccionarTodos = servicio.formSeleccionarTodos.find('#seleccionar-todos');
            servicio.contSeleccionarTodosPaginas = servicio.formSeleccionarTodos.find('.cont-seleecionar-todos-paginas');
            servicio.checkSeleccionarTodosPaginas = servicio.formSeleccionarTodos.find('#seleccionar-todos-paginas');
            servicio.tableDatasetsServicio = $('.table-datasets-servicio');
            servicio.contMensajesAcciones = $('.mensaje-acciones');
            servicio.servicioOficial = $('#servicio_oficial');
        },
        initPlugins : function(){
            if(servicio.servicioOficial.length)
                servicio.servicioOficial.chosen();
        },
        bindEvents : function(){
            servicio.checkSeleccionarTodos.on('change', function(e){
                servicio.toggleSeleccionarTodos();
            });
            servicio.formSeleccionarTodos.find('#migrar-datasets').on('click', function(e){
                e.preventDefault();
                servicio.preparaMigracion();
            });
            servicio.formSeleccionarTodos.find('#publicar-datasets, #despublicar-datasets').on('click', function(e){
                e.preventDefault();
                servicio.cambiaPublicacionDatasets($(this));
            });
        },
        toggleSeleccionarTodos : function(elem){
            var todosChecked = servicio.checkSeleccionarTodos.is(':checked');

            if(todosChecked)
                servicio.contSeleccionarTodosPaginas.show();
            else{
                servicio.contSeleccionarTodosPaginas.hide();
                servicio.checkSeleccionarTodosPaginas.attr('checked', false);
            }

            servicio.tableDatasetsServicio.find('.check-dataset-servicio').each(function(){
                $(this).attr('checked', todosChecked);
            });
        },
        preparaMigracion : function(){
            if(!servicio.validaDatasetsChecked('<br><div class="alert alert-danger">Debe seleccionar al menos un datasets para migrar.</div>'))
                return false;

            var postData = servicio.formSeleccionarTodos.serialize();
            $.ajax({
                type : 'POST',
                url : servicio.admin_url+'/servicio/preparaMigracion/'+servicio.codigo,
                data : postData
            }).always(function(resultData){
                    servicio.modal.find('.modal-title').html('Migrar Datasets');
                    servicio.modal.find('.modal-body').html(resultData);
                    servicio.modal.modal();
                    servicio.modal.find('.chzn-select').chosen();
                    backend.pluginsInit(servicio.modal);
                });
        },
        cambiaPublicacionDatasets : function(btn){
            if(!servicio.validaDatasetsChecked('<br><div class="alert alert-danger">Debe seleccionar al menos un datasets para hacer la publicación.</div>'))
                return false;

            btn.prop('disabled', true);
            var postData = servicio.formSeleccionarTodos.serialize();
            $.ajax({
                type : 'POST',
                url : servicio.admin_url+'/servicio/cambiaPublicacionDatasets/'+btn.data('publicar'),
                data : postData,
                dataType : 'JSON'
            }).always(function(resultData){
                    servicio.actualizaLabelsPublicacionDatasets(resultData.datasets, btn.data('publicar'));
                    btn.prop('disabled', false);
                });
        },
        actualizaLabelsPublicacionDatasets : function(datasets, publicar){
            var labelPublicado = '<span class="label label-mini label-success"><i class="icon-ok-circle"></i><span>Publicado</span></span>',
                labelDespublicado = '<span class="label label-mini label-warning"><i class="icon-ban-circle"></i><span>No Publicado</span></span>';
            for(var i = 0; i < datasets.length; i++){
                var filaDataset  = $('#fila-datasets-'+datasets[i]);
                if(filaDataset.length)
                    filaDataset.find('.cont-label-publicacion').html(publicar == "1" ? labelPublicado : labelDespublicado);
            }
        },
        validaDatasetsChecked : function(mensaje){
            if(!servicio.tableDatasetsServicio.find('.check-dataset-servicio:checked').length){
                servicio.contMensajesAcciones.html(mensaje).fadeIn().delay(5000).fadeOut();
                return false;
            }
            return true;
        }
    }

    $(function(){
        window.servicio = servicio.init();
    })
})(jQuery);