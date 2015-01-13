(function($){
	var participacion = {
		init : function(){
			this.bindEvents();
			this.validateField();
            return this;
		},
		bindEvents : function(){
                $('#servicio_codigo').chosen();
                $('#categoria').chosen({max_selected_options: 5});
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
		validateField : function(){
			$("#enlace").keydown(function(){
        		var url = $("#enlace").val();

        		var str = 'http://datos.gob.cl';
    			var n = str.indexOf(url);

        		if (url) {
        			$(".status").show();
        			if (n==0) {
        				$(".status").css("color", "green");
        				$("#guardar").removeClass('disabled');
        				$("#guardar").removeAttr('disabled', 'disabled');
        			}else{
        				$(".status").css("color", "red");
        				$("#guardar").addClass('disabled');
        				$("#guardar").attr('disabled', 'disabled');
        			};	
        		}else{
        			$(".status").hide();
        		};	

    			$(".status").html('Escribir una dirección que corresponda a : datos.gob.cl');
			});

			$("#enlace_modal").keydown(function(){
        		var url = $("#enlace_modal").val();

        		var str = 'http://datos.gob.cl';
    			var n = str.indexOf(url);

        		if (url) {
        			$(".status_modal").show();
        			if (n==0) {
        				$(".status_modal").css("color", "green");
        				$("#guardar_modal").removeClass('disabled');
        				$("#guardar_modal").removeAttr('disabled', 'disabled');
        			}else{
        				$(".status_modal").css("color", "red");
        				$("#guardar_modal").addClass('disabled');
        				$("#guardar_modal").attr('disabled', 'disabled');
        			};	
        		}else{
        			$(".status_modal").hide();
        		};	

    			$(".status_modal").html('Escribir una dirección que corresponda a : datos.gob.cl');
			});
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