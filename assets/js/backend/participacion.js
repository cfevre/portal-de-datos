(function($){
	var participacion = {
		init : function(){
			return this;
		},
		updatePublicadoButton : function(id, publicado){
			var datasetRow = $('#participacion-'+id),
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
		window.participacion = participacion.init();
	});
})(jQuery);