(function($){
	var backend = {
		init : function(){

			this.admin_url = $('#admin_url').val();
			this.base_url = $('#base_url').val();
			this.modalBackend = $('#modal-backend');
			this.redactorDefaultButtons = ['html', '|', 'formatting', '|', 'bold', 'italic', 'deleted', '|', 'unorderedlist', 'orderedlist', 'outdent', 'indent', '|', 'image', 'video', 'file', 'table', 'link', '|', 'fontcolor', 'backcolor', '|', 'alignleft', 'aligncenter', 'alignright', 'justify', '|','horizontalrule'];
			this.pluginsInit();
			this.initAjaxCommands();
			this.tableSort();
			this.ajaxModal();

			return this;
		},
		pluginsInit : function(context){
			var self = this;
			context = context || $(document);
			if(context.find('.redactor-content').length){
				context.find('.redactor-content').each(function(i, e){
					var elem = $(e),
						buttons = self.redactorDefaultButtons;
					if(elem.data('redactor-buttons')){
						buttons = elem.data('redactor-buttons').split(',');
					}

					elem.redactor({
						imageUpload: '/backend/assets/upload',
						imageGetJson: '/backend/assets/imagesJson',
						buttons : buttons
					});
				});
			}
			context.find('.popover-icon').popover();
			context.find('.uploadify-input').each(function(i, elem){
				var input = $(elem),
					id = input.attr('id'),
					target = $('#'+input.data('target'));
				$('#'+id).fineUploader({
                    request: {
                        endpoint: self.admin_url+'/uploader/upload/'+input.data("folder")
                    },
                    text: {
                        uploadButton: input.data("button-text")
                    }
                })
                .on('complete', function(event, id, filename, responseJSON){
                    if(target.length && responseJSON.success){
                        if(target.data('no-url')){
                            target.val(responseJSON.filename);
                        }else{
                            target.val(self.base_url+'uploads/'+input.data("folder")+'/'+responseJSON.filename);
                        }
                        //Fuerza la llamada al evento "onChange" del elemento
                        target.trigger('change');
                    }
                });
            });
            context.find('.tag-list').tagit({
                tagSource:self.admin_url+'/backend/get_tags',
                newTagInputText:'Nueva Etiqueta'
            });
		},
		initAjaxCommands:function(){
			var self = this;
			$(document).on('click', '[data-ajax-command]', function(e){
				var elem = $(this),
					controller = elem.data('ajax-controller'),
					command = elem.data('ajax-command'),
					params = elem.data('ajax-params')||'',
					formId = elem.data('ajax-form-id')||false,
                    disable = elem.data('disable')||false,
                    messages = $(elem.data('ajax-message-holder')||'');

                if(formId && !messages.length){
                    messages = $('#'+formId).find('.messages');
                    messages.html('');
                }

				if((elem.data('confirm') && confirm(elem.data('confirm'))) || !(elem.data('confirm'))){
					if(controller && command){

                        if(disable)
                            elem.attr('disabled',true);

						sendData = formId?$('#'+formId).serialize():'';
						$.getJSON(self.admin_url+'/'+controller+'/'+command+'/'+params, sendData, function(data){
							if(!data.errors || !data.errors.length){
								if(data.callback)
									eval(data.callback);
							}else{
								if(messages.length){
									var errorHtml = '<div class="alert alert-error">';
									$.each(data.errors, function(i, error){
                                        if(typeof error != "string")
                                            error = error.error
										errorHtml += '<p>'+error+'</p>';
									});
									errorHtml += '</div>';
									messages.html(errorHtml);
								}
							}
                            if(disable){
                                elem.removeAttr('disabled');
                            }
						});
					}
				}
				e.preventDefault();
			});
		},
		/*Habilita la tabla para ordenamiento*/
		tableSort : function(){
			var table = $('.table-sort');
			if(table.length){

				var orderField = table.data('order-field'),
					orderDir = table.data('order-dir'),
					offset = table.data('offset')||0,
                    extra_params = table.data('extra-params')||'',
					base_url = location.pathname;

				table.find('a[data-order-field]').each(function(i, e){
					var elem = $(e),
						_orderDir = elem.data('order-field')==orderField?orderDir:'desc',
						_orderIcon = '<i class="icon-arrow-'+(_orderDir=='desc'?'down':'up')+'"></i>';
					elem.attr('data-order-dir', _orderDir);
					elem.append(_orderIcon);
				});

				table.on('click', 'a[data-order-field]', function(e){
					var elem = $(this),
						_orderField = elem.data('order-field'),
						_orderDir = elem.data('order-dir')=='desc'?'asc':'desc';
					window.location = base_url+'?orderby='+_orderField+'&orderdir='+_orderDir+'&offset='+offset+extra_params;
					e.preventDefault();
				});
			}
		},
		/*Habilita los dialogos modales que cargan contenido mediante ajax*/
		ajaxModal : function(){
			var self = this;
			$(document).on('click', 'a.ajax-modal', function(e){
				var elem = $(this),
					href = elem.attr('href');
				self.modalBackend.find('.modal-body').load(href, function(data){
					self.modalBackend.find('.modal-message').attr('class', '').addClass('modal-message hide');
					self.modalBackend.find('.modal-title').html(elem.data('modal-header'));
					self.modalBackend.modal('show');
					self.pluginsInit(self.modalBackend);
				});
				e.preventDefault();
			});
		}
	};
	$(function(){
		window.backend = backend.init();
	});
})(jQuery);