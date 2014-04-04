(function($){
    
    var reportes = {
        init : function(){
            this.admin_url = $('#admin_url').val();
            this.formTipoReporte = $('#formTipoReporte');
            this.tablaTipoReportes = $('#tabla-tipos-reporte');
            this.formReporte = $('#form-reporte');
            this.tablaReportes = $('#tabla-reportes');
            this.bindEvents();
            this.onLoadEvents();
            return this;
        },
        bindEvents : function(){
            var self = this;
            reportes.tablaTipoReportes.on('click', '.delete-tipo-reporte', function(e){
                var tituloTipoReporte = $(this).data('name'),
                    tipoReporteId = $(this).data('id');
                if(confirm('¿Está seguro que desea eliminar el tipo de reporte ['+tituloTipoReporte+']?')){
                    window.location = self.admin_url+'/tiporeporte/delete/'+tipoReporteId;
                }
                e.preventDefault();
            });
            reportes.tablaReportes.on('click', '.delete-reporte', function(e){
                var tituloReporte = $(this).data('name'),
                    reporteId = $(this).data('id');

                if(confirm('¿Está seguro que desea eliminar el tipo de reporte ['+tituloReporte+']?')){
                    window.location = self.admin_url+'/reporte/delete/'+reporteId;
                }
                e.preventDefault();
            });
            if (reportes.formReporte.length && (!reportes.formReporte.find('#reporte_id').val() || reportes.formReporte.find('#aux-estado').val()==1)) {
                reportes.formReporte.on('change', '#tipo_reporte_id', function(e){
                    var tipo_reporte_id = $(this).val();
                    $.getJSON(reportes.admin_url+'/reporte/get_comentario_predefinido/'+tipo_reporte_id, function(data){
                        reportes.formReporte.find('#comentarios').setCode(data.comentarios);
                    });
                });
                if(reportes.formReporte.find('#aux-estado').val() != 1)
                    reportes.formReporte.find('#tipo_reporte_id').trigger('change');
            }
        },
        onLoadEvents : function(){
            if($('select#codigo_servicio').length){
                $('#codigo_servicio').chosen();
            }
        }
    };

    $(function(){
       window.reportes = reportes.init();
    });

})(jQuery);