(function($){
	var noticia = {
		init : function(){
			this.formulario = $('#formNoticia');
			this.bindEvents();
			return this;
		},
		bindEvents : function(){
			this.formulario.on('change', '#foto', function(e){
				var elem = $(this);
				if(elem.data('preview-container')){
					var prevContainer = $('#'+elem.data('preview-container')),
						img = $('<img>');
					img.attr({
						src : backend.base_url+"assets/timthumb/timthumb.php?zc=1&w=400&src=uploads/noticias/"+elem.val(),
						alt : "Preview noticia"
					});
					prevContainer.html(img);
				}
				e.preventDefault();
			});
		},
		updatePublicadoButton : function(id, publicado){
			var datasetRow = $('#noticia-'+id),
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
		window.noticia = noticia.init();
	});
})(jQuery);