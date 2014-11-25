(function($){
	var participacion = {
		init : function(){
			this.bindEvents();
            return this;
		},
		bindEvents : function(){
                $('#servicio_codigo').chosen();
                $('#categoria').chosen();
                $('#region').chosen();
        },
		classBtn : {
			'0' : 'btn-danger',
			'1' : 'btn-success',
			'2' : 'btn-warning'
		},
		btnText : {
			'0' : 'No Procesado',
			'1' : 'Procesado',
			'2' : 'En Proceso'
		},
		classIcon : {
			'0' : 'icon-off',
			'1' : 'icon-ok-circle',
			'2' : 'icon-time'
		},
		updatePublicadoButton : function(id, publicado, estadoAnterior){
			$('#Procesado').modal('hide');
			$('#EnProceso').modal('hide');
			$('#NoProcesado').modal('hide');
			var datasetRow = $('#participacion-'+id),
				publicadoBtn = datasetRow.find('.btn-group button'),
				classToRemoveBtn = this.classBtn[estadoAnterior],
				classToRemoveIcon = this.classIcon[estadoAnterior],
				classToAddBtn = this.classBtn[publicado],
				classToAddIcon = this.classIcon[publicado],
				btnText = this.btnText[publicado];
			publicadoBtn
				.removeClass(classToRemoveBtn)
				.addClass(classToAddBtn)
				.find('i')
					.removeClass(classToRemoveIcon)
					.addClass(classToAddIcon);
			publicadoBtn
				.find('.proceso')
					.text(btnText);
		}
	}
	$(function(){
		window.participacion = participacion.init();
	});
})(jQuery);

function eliminarSolicitud(id, url) {
	    var r = confirm("¿Estás seguro de eliminar la solicitud #"+id+'?')
	    if (r == true) {
	    	window.location = url;
	    	}
}

