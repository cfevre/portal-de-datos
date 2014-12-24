(function($){
    var datosGob = {
        init : function(){
            this.site_url = $('#site_url').val();

            this.slider = $('#myCarousel');//Slider del home

            this.initPlugins();
            this.bindEvents();
            this.initSubscription();
            return this;
        },
        initPlugins : function(){
            var self = this,
                chartDescargas = $('#chartDescargas');

            if(chartDescargas.length){
                self.initHighchartsDescargas(chartDescargas.data('datasetid'));
            }

            if($('[data-auto-submit]').length){
                this.initAutoSubmit();
            }

            if($('.ajax-form').length){
                this.initAjaxForm();
            }

            if($('#modalParticipacion').length){
                modalParticipacion.init();
            }

            if($('#ficha').length){
                this.recursosJunar = recursosJunar.init();
                this.updateHitsDataset();
            }

            /*Rating*/
            $('.rating-star').rating({
                split:2,
                required:true,
                callback: function(rating, elem){
                    var datasetid = $(elem).parents('.cont-rating').data('datasetid');
                    self.rateDataset(datasetid, (rating/2), $(elem));
                }
            });

            $('.popover-icon').popover();

            if($('.cont-listado-entidades').length){
                this.listadoEntidades = listadoEntidades.init();
            }

            if($('.btn-muestra-formulario-denuncia').length){
                this.formularioDenucia = formularioDenucia.init();
            }

            /*Aplicaciones*/
            if($('.cont-aplicaciones').length){
                this.masonryAplicaciones();
            }

            colorTags.init();
            flipBox.init();
            konamicode.init();
        },
        bindEvents:function(){
            var self = this;
            if(this.slider.length){
                this.slider.on('slid', function(e){
                    self.cambiaSlide();
                });
                this.slider.on('click', 'li.marker', function(e){
                    var item = $(this).data('item');
                    self.slider.carousel(item);
                    e.preventDefault();
                });
            }
        },
        initSubscription:function(){
            $(document).on('click', "#save-subscription", function(e){
                e.preventDefault();

                var expr = /^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$/;

                var id = $(this).attr('data-id');
                var email = $('#email-subscription').val().trim();
                if (expr.test($('#email-subscription').val().trim())) {
                    $(this).parent().hide();
                    $('#email-noValido').hide();

                    var data = {
                        email : email
                    }

                    $.getJSON('participa/ingresoSuscripcion/'+id,data)
                    .then(function(res){
                        $('#email-subscription, #body-suscripcion').hide();
                        $('#msg-subscription').html(res.message);
                        setTimeout(function(){
                            $('#modalParticipacion').modal('hide');
                        },2500);
                    });
                }
                else {
                    $('#email-noValido').addClass('alert alert-error');
                    $('#email-noValido').html('La dirección de correo no es valida');
                }
            });
        },
        cambiaSlide:function(){
            var self = this,
                activeSlide = this.slider.find('div.item.active');
            self.cambiaSlideMark(activeSlide.data('item'));
        },
        cambiaSlideMark : function(item){
            var self = this,
                markers = this.slider.find('li.marker');
            markers.filter('.active').removeClass('active');
            markers.filter('[data-item="'+item+'"]').addClass('active');
        },
        initHighchartsDescargas : function(datasetId){
            Highcharts.setOptions({
                lang: {
                    months: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                    weekdays: ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado']
                }
            });
            var options={
                chart: {
                    renderTo: 'chartDescargas',
                    defaultSeriesType: 'line'
                },
                title: {
                    text: null
                },
                credits: {
                    enabled: false
                },
                legend: {
                    enabled: false
                },
                xAxis: {
                    type: 'datetime'
                },
                yAxis: {
                    title: {
                        text: 'Nº de Descargas'
                    },
                    min: 0
                },
                series: [{
                    name: 'Nº de Descargas',
                    data: []
                }]
            };

            $.getJSON(this.site_url+"datasets/ajax_get_descargas_stats/"+datasetId,function(response){

                    if (response.length>1){
                        for(var i in response){
                            var fecha=response[i].fecha.date.split(' ')[0].split('-');
                            options.series[0].data.push([Date.UTC(fecha[0],fecha[1]-1,fecha[2]),parseInt(response[i].ndescargas, 10)]);
                        }
                    } else{
                        options.labels={
                            items: [{
                                html: "No hay suficientes datos",
                                style:{
                                    left: '80px',
                                    top: '80px'
                                }
                            }]
                        };
                    }

                    var chart = new Highcharts.Chart(options);
                    chart.render();
            });
        },

        initAutoSubmit:function(){
            var autoSubmitInputs = $('[data-auto-submit]');
            autoSubmitInputs.each(function(i, elem){
                var input = $(elem),
                    _event = input.data('auto-submit'),
                    _target = input.data('submit-form');
                input.on(_event, function(){
                    $('#'+_target).submit();
                });
            });
        },

        rateDataset : function(datasetid, rating, elem){
            var url = datosGob.site_url+'evaluaciones/evaluar/'+datasetid;
            $.getJSON(url, {'rating':rating}, function(data){
                elem.parents('.cont-rating').find('.rating-star').rating('disable');
            });
        },

        initAjaxForm : function(){
            var $forms = $('.ajax-form');
            $forms.on('submit', function(e){
                var $form = $(this),
                    method = $form.attr('method'),
                    action = $form.attr('action'),
                    formData = $form.serialize(),
                    $formMessages = $('.form-messages'),
                    $button = $form.find('button[type="submit"]').attr('disabled','disabled');
                $.ajax({
                    url:action,
                    type:method,
                    dataType:'json',
                    data:formData
                }).done(function(data, status){
                    $formMessages.html('');
                    var $alert = $('<div>').addClass('alert fade');
                    $alert.append('<button type="button" class="close" data-dismiss="alert">×</button>');
                    if(data.errors){
                        $alert.addClass('alert-error').append('<p><h4>'+data.message+'</h4></p>');
                        for(var i = 0; i < data.errors.length; i++){
                            $alert.append('<p>'+data.errors[i]+'</p>');
                        }
                        $button.attr('disabled', false);
                    }else{
                        $form.fadeOut(200, function(){
                            $alert.addClass('alert-success').append('<h4>'+data.message+'</h4>');
                        });
                    }
                    $formMessages.append($alert);
                    $alert.addClass('in');
                    var scroll_to = 0;
                    scroll_to = $(".participa").offset().top; 
                            
                    if($(window).scrollTop() != scroll_to) {
                        $('html, body').animate({scrollTop: scroll_to}, 1000);
                    }
                });
                e.preventDefault();
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
                        $.getJSON('/'+controller+'/'+command+'/'+params, sendData, function(data){
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
        updateHitsDataset : function(){
            var maestroId = $('#maestroId').val();
            $.getJSON(datosGob.site_url+'datasets/ajax_add_hit/'+maestroId);
        },
        masonryAplicaciones : function(){
            $('.cont-aplicaciones').masonry({
                itemSelector : '.item-aplicacion',
                columnWidth : 45,
                isAnimated: true
            });
        }

    };

    var recursosJunar = {
        init : function(){
            this.contFicha = $('#ficha');
            this.urlEmbedJuar = 'http://recursos.datos.gob.cl/visualizations/embed/';
            this.urlRecursosJunar = this.contFicha.find('#urlRecursosJunar').val();
            this.urlVisualizacionesJunar = this.contFicha.find('#urlVisualizacionesJunar').val();
            this.contRecursosJunar = this.contFicha.find('.cont-recursos-junar');
            this.tablaRecursosJunar = this.contFicha.find('#tabla-recursos-junar');
            this.loaderRecursos = this.contFicha.find('.loader-recursos');
            this.contEmbed = $('.cont-widget-junar');

            this.loadRecursos();
            return this;
        },
        loadRecursos : function(){
            var self = this;
            $.ajax({
                url : self.urlRecursosJunar,
                dataType : 'jsonp',
                success : function(data){
                    self.renderRecursos(data);
                    if(data.length)
                        recursosJunar.loadCharts(data);
                }
            });
        },
        renderRecursos : function(data){
            var self = this,
                tbody = '';
            if(data.length){
                for(var i in data){
                    tbody += '<tr>'
                        + '<td><a href="'+data[i].link+'" target="_blank">'+data[i].title+'</a></td>'
                        + '<td>'+(data[i].description?data[i].description:'')+'</td>'
                        + '<td>'+(data[i].tags.length?data[i].tags.join(','):'')+'</td>'
                        + '</tr>';
                }
                self.tablaRecursosJunar.find('tbody').html(tbody);
                this.loaderRecursos.hide();
                self.tablaRecursosJunar.show();
            }else{
                self.contRecursosJunar.hide();
            }
        },
        renderEmbedRecurso : function (recurso) {
            var urlEmbed = recursosJunar.urlEmbedJuar+recurso.id,
                frame = '<iframe title="'+recurso.title+'" width="100%" height="380" src="'+urlEmbed+'?end_point=&height=300&width=355" frameborder="0" style="border:1px solid #E2E0E0;padding:0;margin:0;"></iframe>';
            recursosJunar.contEmbed.find('.widget-content').html(frame);
            recursosJunar.contEmbed.removeClass('hidden');
        },
        loadCharts : function(data){
            var datastreamId = [];
            for(var i = 0; i < data.length; i++)
                datastreamId.push(data[i].id);

            $.ajax({
                url : recursosJunar.urlVisualizacionesJunar+'&q='+datastreamId.join(' '),
                dataType : 'jsonp',
                success : function(data){
                    if(data.length){
                        recursosJunar.renderEmbedRecurso(data[0]);
                    }
                }
            });
            datastreamId.join(' ')
        }
    };

    var flipBox = {
        init : function(){
            this.contBoxes = $('#widget-catalogos-top');
            if(this.contBoxes.length){
                this.bindEvents();
            }
        },
        bindEvents : function(){
            this.contBoxes.on('click', '.dataset-container', function(e){
                var elem = $(this);
                if(e.target.nodeName != 'A'){
                    elem.toggleClass('flip');
                }
            });
        }
    };
    var modalParticipacion = {
        init : function(){
            this.participaciones = $('.participacion');
            this.modal = $('#modalParticipacion');
            this.bindEvents();
        },
        bindEvents : function(){
            var self = this;
            this.participaciones.on('click', 'a.modal-trigger', function(e){
                var elem = $(this);
                self.modal.load(elem.attr('href'), function(data){
                    self.modal.modal('show');
                });
                e.preventDefault();
            });
            this.modal.on('hidden', function(){
                $(this).find('.modal-body').html('');
            });
        }
    };
    /*Colorea los tags según la cantida de datasets asociados*/
    var colorTags = {
        init : function(){
            this.tags = $('.cont-widget-tags a.label');
            this.categorias = $('.cont-widget-categorias a.label');
            this.maxCountTags = this.getMaxCount(this.tags);
            this.maxCountCategorias = this.getMaxCount(this.categorias);
            this.addColor(this.tags, this.maxCountTags);
            this.addColor(this.categorias, this.maxCountCategorias);
        },
        getMaxCount : function(collection){
            var max = 0;
            //Get max
            collection.each(function(i, elem){
                var tag = $(elem);
                max = parseInt(tag.data('count'), 10)>max?parseInt(tag.data('count'), 10):max;
            });
            return max;
        },
        addColor : function(collection, max){
            var self = this;
            collection.each(function(i, elem){
                var tag = $(elem),
                    count = parseInt(tag.data('count'), 10);
                tag.css('background-color','rgba('+parseInt(15+(101-((count/max)*101)), 10)+','+parseInt(92+(37-((count/max)*37)), 10)+',133,'+(0.5+(count*0.5)/max)+')');
            });
        }
    };
    var listadoEntidades = {
        init : function(){
            listadoEntidades.contListadoEntidades = $('.cont-listado-entidades');

            listadoEntidades.contListadoEntidades.masonry({
                itemSelector : '.cont-entidad-dataset',
                columnWidth : 385,
                isAnimated: true
            });
            listadoEntidades.bindEvents();
            return listadoEntidades;
        },
        bindEvents : function(){
            listadoEntidades.contListadoEntidades.on('click', '.ver-mas-servicios', function(e){
                var contEntidad = $(this).parents('.cont-entidad-dataset');

                contEntidad.toggleClass('expanded');

                listadoEntidades.contListadoEntidades.masonry('reload');

                e.preventDefault();
            });
        }
    };
    var formularioDenucia = {
        init : function(){
            formularioDenucia.contenedor = $('.cont-formulario-denuncia');
            formularioDenucia.wrapper = formularioDenucia.contenedor.find('.wrapper-formulario-denuncia');
            formularioDenucia.form = formularioDenucia.contenedor.find('#formulario-denuncia');
            formularioDenucia.gracias = formularioDenucia.contenedor.find('.mensaje-gracias');
            formularioDenucia.btnMuestraFormulario = $('.btn-muestra-formulario-denuncia');

            formularioDenucia.bindEvents();

            return formularioDenucia;
        },
        bindEvents : function(){
            formularioDenucia.btnMuestraFormulario.on('click', function(e){
                formularioDenucia.contenedor.slideToggle();
            });
            formularioDenucia.form.on('submit', function(e){
                var action = formularioDenucia.form.attr('action'),
                    method = formularioDenucia.form.attr('method'),
                    formData = formularioDenucia.form.serialize();

                $.ajax({
                    url:action,
                    type:method,
                    dataType:'json',
                    data:formData
                }).done(function(data, status){
                    if(data.errors.length){
                        var mensajes = '<div class="alert alert-danger">';
                        for(var i=0; i<data.errors.length; i++){
                            mensajes += '<p>'+data.errors[i]+'</p>';
                        }
                        mensajes += '</div>';
                        formularioDenucia.form.find('.mensajes').html(mensajes);
                    }else{
                        formularioDenucia.wrapper.fadeOut(200, function(){
                            formularioDenucia.gracias.fadeIn();
                        });
                    }
                });
                e.preventDefault();
                return false;
            });
        }
    };
    var konamicode = {
        init : function(){
            this.konami_keys = [38, 38, 40, 40, 37, 39, 37, 39, 66, 65];
            this.konami_index = 0;
            this.bindEvents();
        },
        bindEvents : function(){
            var self = this;
            $(document).keydown(function(e){
            if(e.keyCode === self.konami_keys[self.konami_index++]){
            if(self.konami_index === self.konami_keys.length){
            $(document).unbind('keydown', arguments.callee);
            $.getScript('//hi.kickassapp.com/kickass.js');
            }
            }else{
              self.konami_index = 0;
            }
            });
        }
    };
    $(function(){
        window.datosGob = datosGob.init();
    });
})(jQuery);

/*Hacer movible el menu*/
$("document").ready(function($){
    
    var nav = $('#movible');
    var box = $('#box-solid');
    
    $(window).scroll(function () {
        if ($(this).scrollTop() > 138) {
            nav.addClass("f-nav");
            box.addClass("box-solid");
        } else {
            nav.removeClass("f-nav");
            box.removeClass("box-solid");
        }
    });
});

$('#myTab a').click(function (e) {
  e.preventDefault();
  $(this).tab('show');
});

$(function () {
    $('.tabs a:last').tab('show')
});