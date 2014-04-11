
$(document).ready(function() {		
	
	var $tooltip = $('<div class="tooltip">Tooltip</div>');
	$('.bubble-chart').append($tooltip);
	
	var tooltip = function(event) {
	  if (event.type == 'SHOW') {
	  	// show tooltip
	  	$tooltip.css({ 
	  		left: event.mousePos.x + 4, 
	  		top: event.mousePos.y + 4 
	  	});
	  	$tooltip.html(event.node.label+' <b>'+event.node.famount+'</b>');
	  	$tooltip.show();
	  } else {
	  	// hide tooltip
	  	$tooltip.hide();
	  }
	};
	
	function csv2json4bubbletree(data, conf){
	  var lines = data.split("\n");
	  var delimiter = conf.delimiter || ",";
	  var divisors;
	  var colors = ["#D2857D", "#D2A17D", "#7DD2AF", "#7D9FD2", "#A7A7A7", "#FFFFFF"];
	  var colorIndex = 0;
	  var tree = {};
	  var i=0;
	  if(conf.hasHeader){
	  	i=1;
	  }
	  var total=0;
	  var lastIndex = 0;
	  
	  while(i<lines.length){
	  	columns=lines[i].split(delimiter);
	  	if(isNaN(columns[conf.value])){i++;continue;}
	  	var level1 = columns[3];
	  	var level2 = columns[4];
	  	var level3 = columns[5];
	  	if(level1 != ''){
	  	  if(tree[level1] == undefined){
	  	  	tree[level1] = {label: columns[conf.title], children: new Array(), amount: parseInt(columns[conf.value])*1000, color: colors[(colorIndex++)%6]};
	  	  	total += parseInt(columns[conf.value]);
	  	  }
	  	  if(level2 != '' ){
	  	  	if(level3 == ''){
	  	  	  tree[level1]['children'].push({label: columns[conf.title], amount: parseInt(columns[conf.value])*1000, color: tree[level1]['color']});
	  	  	  lastIndex = tree[level1]['children'].length-1;
	  	  	}else{
	  	  	  if(tree[level1]['children'][lastIndex]['children'] == undefined){
	  	  	  	tree[level1]['children'][lastIndex]['children'] = new Array();
	  	  	  }
	  	  	  tree[level1]['children'][lastIndex]['children'].push({label: columns[conf.title], amount: parseInt(columns[conf.value])*1000, color: tree[level1]['color']});//new Array();
	  	  	}
	  	  }
	  	}
	  	i++;
	  }
	  var finalTree = {
	  	label: "Presupuesto total",
	  	amount: total*1000,
	  	children: []
	  };
	  for(var j in tree){
	  	finalTree['children'].push(tree[j]);
	  }
	  return finalTree;
	}
	
	function getData(url){
	  $.ajax({
	  	  url: "csv/"+url,
	  	  type: "GET",
	  	  success: function(data){
	  	  	var d = csv2json4bubbletree(data, {hasHeader: true, delimiter: ";", value: 7, title: 6});
	  	  	console.log(d);
	  	  	new OpenSpending.BubbleTree.Loader({
	  	  		data: d,
	  	  		container: '.bubbletree',
	  	  		bubbleType: 'plain'
	  	  		
	  	  	});
	  	  	
	  	  }
	  });
	}
	
	getData($("#data>option:selected").val());
	
	$("#data").change(function(i, item){$(".bubbletree").empty();getData($("#data>option:selected").val())});
});
