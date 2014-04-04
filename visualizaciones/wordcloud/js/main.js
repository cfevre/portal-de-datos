$(document).ready(function(){
	var token = 'zRKOxeKLeNPevW0b';
	var urlServicios = 'http://www.chileatiende.cl/api/servicios';//'http://www.chileatiende.cl/api/servicios';
	var info = new Array();
	var currentId = "";
	function getServicios(){
	  	  	  	$("#waiting").show();
	  $.ajax({
	  	  url:urlServicios,
	  	  dataType: 'jsonp',
	  	  data: {
	  	  	access_token: token
	  	  },
	  	  success: function(data){
	  	  	$("#waiting").hide();
	  	  	$.each(data.servicios.items.servicio, function(i, item){
	  	  		$("#lista").append("<option value='"+item.id+"' class='servicio'>"+item.nombre+"</option>");
	  	  		info[item.id] = {nombre: item.nombre, url: item.url, sigla: item.sigla, mision: item.mision};
	  	  	});
	  	  }
	  });
	}
	
	
	$("#lista").live('change', function(e){
		$("#waiting").show();
		idServicio = $("#lista>option:selected").val();
		$.ajax({
			url: urlServicios+'/'+idServicio+'/fichas',
			dataType: 'jsonp',
			data: {
			  access_token: token
			},
			success: function(data){
				console.log(data);
			  $(".bubble").empty();
			  var words = getWords(data);
			  doGraph(words);
			  $("#waiting").hide();
			},
			error: function(){
			  alert("Ocurri— un error. Intente m‡s tarde.");
			  $("#waiting").hide();
			}
		});
	});
	
	function getWords(doc){
	  var dict = {};
	  $.each(doc.fichas.items, function(i, item){
	  	  var regex = /[\s,\.\(\):;]+/;
	  	  var arr = item.titulo.toLowerCase().split(regex);	  	  
	  	  for(var i=0; i< arr.length; i++){
	  	  	if(!isNaN(arr[i])){continue;}
	  	  	if(stopWords.indexOf(arr[i])<0){
	  	  	  if(dict[arr[i]] == undefined){
	  	  	  	dict[arr[i]] = 1;
	  	  	  }else{
	  	  	  	dict[arr[i]]++;
	  	  	  }
	  	  	}
	  	  }
	  	  arr = item.beneficiarios.toLowerCase().replace(/(<([^>]+)>)/ig,"").split(regex);
	  	  for(var i=0; i< arr.length; i++){
	  	  	if(!isNaN(arr[i])){continue;}
	  	  	if(stopWords.indexOf(arr[i])<0){
	  	  	  if(dict[arr[i]] == undefined){
	  	  	  	dict[arr[i]] = 1;
	  	  	  }else{
	  	  	  	dict[arr[i]]++;
	  	  	  }
	  	  	}
	  	  }
	  	  arr = item.objetivo.toLowerCase().replace(/(<([^>]+)>)/ig,"").split(regex);
	  	  for(var i=0; i< arr.length; i++){
	  	  	if(!isNaN(arr[i])){continue;}
	  	  	if(stopWords.indexOf(arr[i])<0){
	  	  	  if(dict[arr[i]] == undefined){
	  	  	  	dict[arr[i]] = 1;
	  	  	  }else{
	  	  	  	dict[arr[i]]++;
	  	  	  }
	  	  	}
	  	  }
	  });
	  
	  var result = {name: "results", children: new Array()};
	  for(var i in dict){
	  	result.children.push({name: i, size:dict[i]});
	  }
	  return result;
	  
	}
	
	getServicios();
});
