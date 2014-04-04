(function($){
	var dataset = {
		init : function(){
			this.admin_url = $('#admin_url').val();
			this.formFiltros = $('.form-filtros');
			this.formDataset = $('#formDataset');
			this.filtroEntidades = this.formFiltros.find('#codigo_entidad');
			this.filtroServicios = this.formFiltros.find('#codigo_servicio');
			this.tablaDatasets = $('#tabla-datasets');

			if(this.filtroEntidades.val() !== '')
				this.changeServicios(this.filtroEntidades.val());

			this.bindEvents();
			this.initPlugins();
			return this;
		},
		initPlugins : function(){
			var self = this;
			if(this.formDataset.length){
				this.formDataset.find('.tag-list').tagit({
					tagSource:self.admin_url+'/backend/get_tags',
					newTagInputText:'Nueva Etiqueta'
				});
				this.formDataset.find('.sectores-list').tagit({
					tagSource:self.admin_url+'/backend/get_sectores',
					inputName:'sectores',
					newTagInputText:'Nueva Cobertura Geográfica',
                    acceptNewTags:false
				});
			}
            if($('.form-filtros').length){
                $("#codigo_servicio").chosen();
            }
            if($('#formDataset').length){
                $("#servicio_codigo").chosen();
            }
		},
		bindEvents : function(){
			var self = this;
			if(this.formFiltros.length){
				this.formFiltros.on('change', '#codigo_entidad', function(e){
					var elem = $(this),
						codigo_entidad = elem.val();
					self.changeServicios.call(self, codigo_entidad);
				});
			}
			this.tablaDatasets.on('click', '.delete-dataset', function(e){
				var datasetName = $(this).data('name'),
					datasetId = $(this).data('id');
				if(confirm('¿Está seguro que desea eliminar el dataset ['+datasetName+']?')){
					window.location = self.admin_url+'/dataset/delete/'+datasetId;
				}
				e.preventDefault();
			});
		},
		changeServicios : function(codigo_entidad){
			if(!codigo_entidad)
				return false;
			var self = this,
				selected = '';
				prevServicio = this.filtroServicios.val();
			$.getJSON('/backend/backend/get_servicios_entidad/'+codigo_entidad, function(servicios){
				self.filtroServicios.html('<option value="">- Seleccione -</option>');
				$.each(servicios, function(i, servicio){
					selected = prevServicio == servicio.codigo ? 'selected="selected"' : '';
					self.filtroServicios.append('<option '+selected+' value="'+servicio.codigo+'">'+servicio.nombre+'</option>');
				});
                $("#codigo_servicio").trigger("liszt:updated");
			});
		},
		updatePublicadoButton : function(id, publicado){
			var datasetRow = $('#dataset-'+id),
				publicadoBtn = datasetRow.find('[data-ajax-command="togglePublicado"]'),
				classToRemoveBtn = !publicado?'btn-success':'btn-warning',
				classToRemoveIcon = !publicado?'icon-ok-circle':'icon-ban-circle',
				classToAddBtn = !publicado?'btn-warning':'btn-success',
				classToAddIcon = !publicado?'icon-ban-circle':'icon-ok-circle',
				btnText = !publicado?'Publicar':'Despublicar';
			publicadoBtn
				.removeClass(classToRemoveBtn)
				.addClass(classToAddBtn)
				.find('i')
					.removeClass(classToRemoveIcon)
					.addClass(classToAddIcon);
			publicadoBtn
				.find('span')
					.text(btnText);
		},
		callbackGrabaItem : function(data, tipo, item){
			var modal = $('#modal-backend'),
				messageContainer = $('#message-'+tipo);
			if(!data.error){
				var tablaItem = $('#tabla-'+tipo+'s tbody');
				//Busca si el recurso ya existe en la tabla.
				var trItem = tipo=='recurso'?dataset.createTrRecurso(item):dataset.createTrDocumento(item);
				if(tablaItem.find('#'+tipo+'-'+item.id).length){
					tablaItem.find('#'+tipo+'-'+item.id).replaceWith(trItem);
				}else{
					tablaItem.append(trItem);
				}
				messageContainer
					.html('<div class="alert alert-success">El '+tipo+' ['+item.id+'] ha sido grabado.</div>')
					.fadeIn(200).delay(5000).fadeOut(200);
				modal.modal('hide');
			}else{

			}
		},
		createTrRecurso : function(recurso){
			var tr = '<tr id="recurso-'+recurso.id+'">';
			tr += '<td>'+recurso.url+'</td>';
			tr += '<td>'+recurso.descripcion+'</td>';
			tr += '<td>'+recurso.mime+'</td>';
			tr += '<td>'+recurso.size+'</td>';
			tr += '<td>';
			tr += '<a href="'+dataset.admin_url+'/recurso/edit/'+recurso.id+'" class="btn btn-small btn-success ajax-modal" data-modal-header="Editar Recurso ['+recurso.id+']"><i class="icon-edit"></i> Editar</a>';
			tr += '<button data-ajax-command="delete" data-ajax-controller="recurso" data-ajax-params="'+recurso.id+'" data-confirm="¿Está seguro que desea eliminar el recurso ['+recurso.id+']?" class="btn btn-small btn-danger"><i class="icon-remove"></i> Eliminar</button>';
			tr += '</td>';
			tr += '</tr>';
			return $(tr);
		},
		createTrDocumento : function(documento){
			var tr = '<tr id="documento-'+documento.id+'">';
			tr += '<td>'+documento.url+'</td>';
			tr += '<td>'+documento.titulo+'</td>';
			tr += '<td>'+documento.descripcion+'</td>';
			tr += '<td>'+documento.mime+'</td>';
			tr += '<td>'+documento.size+'</td>';
			tr += '<td>';
			tr += '<a href="'+dataset.admin_url+'/documento/edit/'+documento.id+'" class="btn btn-small btn-success ajax-modal" data-modal-header="Editar Documento ['+documento.id+']"><i class="icon-edit"></i> Editar</a>';
			tr += '&nbsp;<button data-ajax-command="delete" data-ajax-controller="documento" data-ajax-params="'+documento.id+'" data-confirm="¿Está seguro que desea eliminar el documento ['+documento.id+']?" class="btn btn-small btn-danger"><i class="icon-remove"></i> Eliminar</button>';
			tr += '</td>';
			tr += '</tr>';
			return $(tr);
		},
		removeItem : function(tipo, idItem){
			var messageContainer = $('#message-'+tipo);
			$('#tabla-'+tipo+'s tbody').find('#'+tipo+'-'+idItem).remove();
			messageContainer
					.html('<div class="alert alert-success">El '+tipo+' ['+idItem+'] ha sido eliminado.</div>')
					.fadeIn(200).delay(5000).fadeOut(200);
		},
        callbackEnviaJunar : function (recurso_id) {
            var trRecurso = $('#recurso-'+recurso_id),
                btnCerrar = '<div class="span2"><button class="btn btn-success" data-dismiss="modal">Cerrar</button></div>',
                mensaje = '<div class="row-fluid"><div class="span10"><div class="alert alert-success">El recurso ['+recurso_id+'] fue enviado a Junar </div></div>'+btnCerrar+'</div>';

            trRecurso.find('.icon-upload').removeClass('icon-upload').addClass('icon-refresh');
            backend.modalBackend.find('.modal-footer').html(mensaje);
        }
	};
	$(function(){
		window.dataset = dataset.init();
	});
})(jQuery);