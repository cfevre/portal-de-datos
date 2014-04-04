(function($){
	var page = {
		init : function(){

			return this;
		},
		updateRestrictedButton : function(id, restricted){
			var pageRow = $('#page-'+id),
				restrictedBtn = pageRow.find('[data-ajax-command="toggleRestricted"]'),
				classToRemoveBtn = restricted?'btn-success':'btn-warning',
				classToRemoveIcon = restricted?'icon-ok-circle':'icon-ban-circle',
				classToAddBtn = restricted?'btn-warning':'btn-success',
				classToAddIcon = restricted?'icon-ban-circle':'icon-ok-circle',
				btnText = restricted?'Restringido':'Público';
			restrictedBtn
				.removeClass(classToRemoveBtn)
				.addClass(classToAddBtn)
				.find('i')
					.removeClass(classToRemoveIcon)
					.addClass(classToAddIcon);
			restrictedBtn
				.find('span')
					.text(btnText);
		}
	};
	$(function(){
		window.page = page.init();
	});
})(jQuery);