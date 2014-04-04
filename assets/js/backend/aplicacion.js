(function($){
	var aplicacion = {
		init : function(){
			this.formulario = $('#formAplicacion');
			this.bindEvents();
			return this;
		},
		bindEvents : function(){
			
		},
		updatePublicadoButton : function(id, publicado){
			var datasetRow = $('#aplicacion-'+id),
				publicadoBtn = datasetRow.find('[data-ajax-command="togglePublicado"]'),
				classToRemoveBtn = !publicado?'btn-success':'btn-warning',
				classToRemoveIcon = !publicado?'icon-ok-circle':'icon-ban-circle',
				classToAddBtn = !publicado?'btn-warning':'btn-success',
				classToAddIcon = !publicado?'icon-ban-circle':'icon-ok-circle',
				btnText = !publicado?'No Publicado':'Publicado';
			publicadoBtn
				.removeClass(classToRemoveBtn)
				.addClass(classToAddBtn)
				.find('i')
					.removeClass(classToRemoveIcon)
					.addClass(classToAddIcon);
			publicadoBtn
				.find('span')
					.text(btnText);
		}
	}
	$(function(){
		window.aplicacion = aplicacion.init();
	});
})(jQuery);