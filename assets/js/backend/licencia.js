(function($){
	var licencia = {
		init : function(){
			this.admin_url = $('#admin_url').val();
			this.formulario = $('#formLicencia');
			this.tablaDatasets = $('#tabla-licencias');
			this.bindEvents();
			return this;
		},
		bindEvents : function(){
			var self = this;
			this.tablaDatasets.on('click', '.delete-licencia', function(e){
				var licenciaName = $(this).data('name')
					licenciaId = $(this).data('id');
				if(confirm('¿Está seguro que desea eliminar el licencia ['+licenciaName+']?')){
					window.location = self.admin_url+'/licencia/delete/'+licenciaId;
				}
				e.preventDefault();
			});	
		}
	}
	$(function(){
		window.licencia = licencia.init();
	});
})(jQuery);