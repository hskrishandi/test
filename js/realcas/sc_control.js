
// $(function () {
// 	$('#layout').svg({});
// 	var svg = $('#layout').svg('get');
// 	svg.load('workspace.svg', {
// 		addTo: false,
// 		changeSize: false,
// 		onLoad: onLoad
// 	});
// });

$(function(){
	onLoad();
});

function onLoad(svg, error) {
	
	moveClick = 0;
	//$("svg").attr("height",($(document).height()-20));
	$("svg").attr("height",(1000));
	$("svg").attr("width",(1000));
	$(".component").bind({
		mouseover:function(event){
			$(this).css("cursor","move");
			showTerm(event);
		},
		click:function(event){
			// if (moveClick == 0)
				drawComponent(event);
			// else endMove(event);
			// moveClick ++ ;
		},
		mouseout:function(event){
			unshowTerm(event);
		}
	});
	$("#line").bind({
		click:function(event){
			drawLine(event);
		}
	});
	$("#output_netlist").bind({
		click:function(event){
			get_netlist(event);
		}
	});
	$("body").bind({
		keydown:function(event){
			// if click delete
			if(event.which == 46){
				delete_component(event);
			}
		}
	});
	$("#delete_line").bind({
		click:function(event){
			$(".workspace_line").remove();
		}
	});
	$("#DC_sim").bind({
		click:function(event){
			input_sim(event);
		}
	}),
	$("#zoomin").bind({
			click:function(event){
				zoomin();
			}
	}),
	$("#zoomout").bind({
			click:function(event){
				zoomout();
			}
	})
}

window.addEventListener("message", function (e) {
    var tnetlist = get_netlist();
    e.source.postMessage(tnetlist, '*');
},false);


function showTerm(event){
	$current = $("#"+event.target.parentNode.id);
	$current.children(".term").css("visibility","visible");
}

function unshowTerm(event){
	$current = $("#"+event.target.parentNode.id);
	$current.children(".term").css("visibility","hidden");
	// $(this).children(".term").css("visibility","hidden");
}

//window.addEventListener("keyup", check, false);
var $current,x0,y0,x1,y1,xx,yy;
var $workspace_tmp;
var workspace_index = 0;
var ground_index = 0;
var source_index = 0;
var resistor_index = 0;
var node_index = 0;
var nmos_index = 0;
var component_name = {};
var component_value = {};
var component_type = {};
var tempwidth;
var tempheight;
var zoom = 1;

function drawComponent(event){
	$current = $("#"+event.target.parentNode.id);
			console.log($current.attr("id"));

	var transform = $current.attr("transform");
	var parts  = /translate\(\s*([^\s,)]+)[ ,]([^\s,)]+)/.exec(transform);
	x0 = parts[1] - event.offsetX;
	y0 = parts[2] - event.offsetY;
	xx = parts[1];
	yy = parts[2];

	var tmp = $current.clone();
	$workspace_tmp = $current.clone();
	tmp.attr({
		"class"	:"",
		"id"	:$current.attr("id")+"tmp"
	});
	$("#toolbar").prepend(tmp);
	$("#"+tmp.attr("id")+" > *").each(function(){
		$(this).attr("stroke","#999999");
	});
	$current.css("visibility","hidden");

	$("#workspace").append($workspace_tmp);

	$("#workspace").bind({
		click:function(){
			//add component

			console.log($current.attr("id"));

			workspace_index++;
		    var parnum = "";
		    var parname ="";
			if ($current.attr("id") == "dc")
			{
			    source_index++;
			    parnum = source_index;
			    parname = "V";
			}
			else if ($current.attr("id") == "gnd")
			{
			    ground_index++;
			    parnum = ground_index;
			    parname = "gnd";
			}
			else if ($current.attr("id") == "resistor")
			{
			    resistor_index++;
			    parnum = resistor_index;
			    parname = "R";
			}
			else if ($current.attr("id") == "node")
			{
			    node_index++;
			    parnum = node_index;
			    parname = "Node";
			}
			else if ($current.attr("id") == "NMOS")
			{
			    nmos_index++;
			    parnum = nmos_index;
			    parname = "M";
			}

			$workspace_tmp.attr({
				"class"			:"workspace_component",
				"id"			:"workspace_" + workspace_index,
				"transform"		:"translate(" + putGrid(x1+x0) + "," + putGrid(y1+y0) + ")",
				"param_name"    : parname + parnum,
				"type"          : $current.attr("id")
			});
			$workspace_tmp.children("text").text(parname + parnum);
			$("#workspace").append($workspace_tmp);
			$("#toolbar").append($current);

			$("#"+$current.attr("id")+"tmp").remove();
			$current.css("visibility","visible");

			$("#workspace").unbind("mousemove");
			$("#workspace").unbind("click");


			$(".workspace_component").bind({
				mousedown:function(event){
					startMove(event);
				},
				mouseup:function(event){
					endMove(event);
				},
				dblclick:function(event){
					changeParam(event);
				}
			});
		},
		mousemove:function(event){
			//move
			x1 = event.offsetX;
			y1 = event.offsetY;
			$workspace_tmp.attr({
				"transform":"translate(" + (x1+x0) + "," + (y1+y0) + ")"
			});
		}
	})
}

function startMove(event){
    $current = $("#" + event.target.parentNode.id);
    if($current.children("rect").attr("width") != "100000")
    {
	tempwidth = $current.children("rect").attr("width");
	tempheight = $current.children("rect").attr("height");
	}
	$current.children("rect").attr("width", "100000");
	$current.children("rect").attr("height", "100000");
	$current.children("rect").attr("x", "-1000");
    $current.children("rect").attr("y", "-1000");
    //var current = event.target.parentNode;
    //current.addEventListener("keyup", check, false);
    $current.change(function(){"keyup",alert("")});
    $current.bind({
        mousemove:function(event){
            moveIt(event);
        },
        mouseleave: function (event) {
            moveIt(event);
        },
        mouseout: function (event) {
            moveIt(event);
        }

	});
	// Get value for transform
	var transform = $current.attr("transform");
	var parts  = /translate\(\s*([^\s,)]+)[ ,]([^\s,)]+)/.exec(transform);
	x0 = parts[1] - event.pageX;
	y0 = parts[2] - event.pageY;
	xx = parts[1];
	yy = parts[2];
	// show the toor bar when drag component
	if($current.attr("class") == "component"){
		var tmp = $current.clone();
		tmp.attr({
			"class"	:"",
			"id"	:$current.attr("id")+"tmp"
		});
		$("#toolbar").prepend(tmp);
		$("#"+tmp.attr("id")+" > *").each(function(){
			$(this).attr("stroke","#999999");
		});
	}
}

function moveIt(event) {

    //var current = event.target.parentNode;
    $current = $("#" + event.target.parentNode.id);
    //var $rect = $current.children("rect")
    x1 = event.pageX;
    y1 = event.pageY;
    var x2 = x1 + x0;
    var y2 = y1 + y0;
    $current.attr({
        "transform":"translate(" + x2 + "," + y2 + ") scale(" + zoom + "," + zoom + ")"
    });

    $("#workspace").bind({
    	mousemove:function(event){
    		//var current = event.target.parentNode;
    // $current = $("#" + event.target.parentNode.id);
    //var $rect = $current.children("rect")
    x1 = event.pageX;
    y1 = event.pageY;
    console.log(event.pageX);
    var x2 = x1 + x0;
    var y2 = y1 + y0;
    $current.attr({
        "transform":"translate(" + x2 + "," + y2 + ") scale(" + zoom + "," + zoom + ")"
    });
    	}
    })

}


function endMove(event){

	$current = $("#"+event.target.parentNode.id);
	// current = event.target.parentNode;
	$current.children("rect").attr({ "width": tempwidth });
	$current.children("rect").attr({ "height": tempheight });
	$current.children("rect").removeAttr("x", null);
	$current.children("rect").removeAttr("y", null);
	var transform = $current.attr("transform");
	var parts  = /translate\(\s*([^\s,)]+)[ ,]([^\s,)]+)/.exec(transform);

	if($current.attr("class") == "component"){
		// the component is at the wprkspace
		if(parts[1] >=100){
		    workspace_index++;
		    var parnum = "";
		    var parname ="";
			if ($current.attr("id") == "dc")
			{
			    source_index++;
			    parnum = source_index;
			    parname = "V";
			}
			else if ($current.attr("id") == "gnd")
			{
			    ground_index++;
			    parnum = ground_index;
			    parname = "gnd";
			}
			else if ($current.attr("id") == "resistor")
			{
			    resistor_index++;
			    parnum = resistor_index;
			    parname = "R";
			}
			else if ($current.attr("id") == "node")
			{
			    node_index++;
			    parnum = node_index;
			    parname = "Node";
			}
			else if ($current.attr("id") == "NMOS")
			{
			    nmos_index++;
			    parnum = nmos_index;
			    parname = "M";
			}
			var zoomlev = (zoom-1)*100;
			var tmp = $current.clone();
				tmp.attr({
					"class"			:"workspace_component",
					"id"			:"workspace_" + workspace_index,
					"transform"		:"translate(" + putGrid(((putGrid(parts[1])+zoomlev+20)/zoom -20)) + "," + putGrid(((putGrid(parts[2])+zoom*60)/zoom-60)) + ")",
					"param_name"    : parname + parnum,
					"type"          : $current.attr("id")
				});
				tmp.children("text").text(parname + parnum);
			$("#workspace").append(tmp);

			$(".workspace_component").bind({

				mousedown:function(event){
					startMove(event);
				},
				mouseup:function(event){
					endMove(event);
				},
				dblclick:function(){
					changeParam(event);
				}

			});
		}
		$current.unbind("mousemove");
		$current.unbind("mouseleave");
		$current.unbind("mouseout");
		$current.attr({
			"transform":"translate(" + xx + "," + yy + ")"
		});
		$("#"+$current.attr("id")+"tmp").remove();
	}
	else if($current.attr("class") == "workspace_component"){
	    $current.unbind("mousemove");
	    $current.unbind("mouseleave");
	    $current.unbind("mouseout");

		$current.attr({
			"transform":"translate(" + putGrid(parts[1]) + "," + putGrid(parts[2]) + ")"
		});
	}

	$(".component,.workspace_component").bind({
		mouseover:function(event){
			showTerm(event);
		},
		mouseout:function(event){
			unshowTerm(event);
		}
	})
}

/*
 * To change the value of the component in the workspace,
 * double ckiclk the the component, and a jQuery UI dialog
 * will appear.
 */

function getInsParamForDialog()
{
	// Collect the instance parameter from database 
	var output_result = [];
	$.ajax({
		url: ROOT + "/modelInstanceParams/" + MODEL_ID,
		type: 'GET',
		success: function(result) { 
			try {
				result = JSON.parse(result);
			} catch(err) { alert(k);}			
			output_result = result.ins_params.instance;
			// console.log(output_result);
		},
		error: function(jqXHR, textStatus, errorThrown) {
			console.log("Error: " + textStatus + "; " + errorThrown);
		}
	});  
	console.log(output_result);	
	return output_result;	
}

function changeParam(event){							
	$current = $("#"+event.target.parentNode.id);
	console.log($current.attr("type").substring(0,4));
	if($current.attr("type").substring(0,4)=="NMOS")
	{	
		var output_result = []
		$.ajax({
			url: ROOT + "/modelInstanceParams/" + MODEL_ID,
			type: 'GET',
			success: function(result) { 
				try {
					result = JSON.parse(result);
				} catch(err) { alert(k);}		

				output_result = result.ins_params.instance;		
				var tmp_dialog = "<div class='model-library' id='param_dialog' style='display:none;'>" 
							+"<select id='sel'>"
				$("#userlib").find(".model-page-direct").each(function(){		
					if ($(this).text() == "eDouG"){
						// temporarily the 'eDouG' is hardcoded. 
						$(this).next().find('.model-cards').each(function(){
							tmp_dialog += "<option>" + $(this).text() + "</option>";		
						})
					}			
				})
				tmp_dialog += "</select><br>" ;

				// display all the instance paramters. 				
				$.each(output_result, function(i, item){	
					tmp_dialog = tmp_dialog +  item["name"] + "[" + item["unit"] +"]" + "<input  maxlength='8' type='text' value=" + item["default"]+ " id='param_value'></input>";									
					tmp_dialog += "<br>" ; 
				});
				
				tmp_dialog += "</div>";			
				$("body").append(tmp_dialog);

				$("#param_dialog")
				.dialog({
					dialogClass: "no-close",
					buttons:{
						"OK":function(){
							// Add all the selections into the component as its attributes. 
							$.each(output_result, function(i,item){
								$current.attr(""+item["name"],item["default"]);
							}); 
							$current.attr("modelcard", document.getElementById("sel").options[document.getElementById("sel").selectedIndex].value);
							$current.children("text").text($("#param_name").val());
							$(this).dialog("close");
							$(this).remove();
						},
						"Cancel":function(){
							$(this).dialog("close");
							$(this).remove();
						}
					}
				})
				.dialog("open");
				$("body").remove(document.getElementById("param_dialog"));
			},
			error: function(jqXHR, textStatus, errorThrown) {
				console.log("Error: " + textStatus + "; " + errorThrown);
			}
		}); 	

	}
	else
	{
		var tmp_dialog = "<div id='param_dialog' style='display:none;'>"
						+ "Type the component value.<br/>name:<input id='param_name' maxlength='8'/><br/>"
						+ "value:<input id='param_value'/></div>"

		$("body").append(tmp_dialog);

		$("#param_value").val($current.attr("param_value"));
		$("#param_name").val($current.attr("param_name"));

		$("#param_dialog")
		.dialog({
			dialogClass: "no-close",
			buttons:{
				"OK":function(){
					$current.attr("param_value",$("#param_value").val());
					$current.attr("param_name", $("#param_name").val());
					$current.children("text").text($("#param_name").val());
					$(this).dialog("close");
					$(this).remove();
				},
				"Cancel":function(){
					$(this).dialog("close");
					$(this).remove();
				}
			}

		})
		.dialog("open");
			$("body").remove(document.getElementById("param_dialog"));
	}
}

var vinput_sim;
//input data for sim
function input_sim(event){
	var tmp_dialog = "<div id='simulation_dialog' style='display:none;'>"
					+ "DC simulation<br/>dc_name:<input id='sname' /><br/>"
					+ "initial value:<input id='sivalue'/><br/>"
					+ "final value:<input id='sevalue'/><br/>"
					+ "stepcase:<input id='stepcase'/></div>"

	$("body").append(tmp_dialog);

	$("#simulation_dialog")
	.dialog({
		dialogClass: "no-close",
		buttons:{
			"OK":function(){
		/*	alert($("#param_name").val());
			alert($("#param_value").val());
			alert($("#param_valu").val());
			alert($("#param_vae").val());*/
			    vinput_sim = "* Analysis Definition" + "\n" + ".DC" + " " + "V" + $("#sname").val() + " " + $("#sivalue").val() + " " + $("#sevalue").val() + " " + $("#stepcase").val() + '\n';
			//get_netlist(this.event);
				$(this).dialog("close");
				$(this).remove();
			},
			"Cancel":function(){
				$(this).dialog("close");
				$(this).remove();
			}
		}

	})
	.dialog("open");


}

function makeSVG(tag, attrs) {
	var elem = document.createElementNS('http://www.w3.org/2000/svg', tag);
	for (var k in attrs)
		elem.setAttribute(k, attrs[k]);
	return elem;
}

/*
 * Because the grid is 20px, so the coordanite should be the
 * multiples of 20px.
 */
function putGrid(x){
	return (Math.round(x/10)*10);
}

window.onresize = function(event){
	$("svg").attr("height",($(document).height()-20));
	$("svg").attr("width",($(document).width()-10));
	//$("#workspace").attr("transform","scale(" + 2 + "," + 2+ ")");
}

// draw line function
function drawLine(event){
	$("#line path").attr("stroke","#999999");
	var clicks = 0;
	var tmp_l, tmp_d, tmp_g, tmp_a;
	var click_guide = makeSVG("circle",{
		"id"			:"click_guide",
		"r"				:"5",
		"fill"			:"#999999",
		"stroke"		:"#3b4449",
		"stroke-width"	:"2"
	});
	$("#workspace").append(click_guide);

	$("#workspace").bind({
		click:function(event){
			/*
			 * If it is the first time, then create the line with SVG path.
			 * Otherwise, there is already a starting point, then draw the path.
			 * Because it is needed to add sensitive area to the line,
			 * we need to seperate the polylines into different lines.
			 * So every time of click, there will add a path to the workspace.
			 */
			if(clicks){
				$(tmp_l).attr("d",tmp_d + "L" + putGrid(event.offsetX) + " " + putGrid(event.offsetY));
				var matches = $(tmp_l).attr("d").match(/(\d+)/g);
				// vertical
				if(matches[0] == matches[2]){
					tmp_a = makeSVG("rect",{
						"fill"			:"#ffffff",
						"width"			:"10",
						"height"		:""+(Math.abs(parseInt(matches[1])-parseInt(matches[3]))),
						"style"			:"opacity:0",
						"transform"		:"translate(" + (parseInt(matches[0])-5) + ","
										+ Math.min(parseInt(matches[1]),parseInt(matches[3])) + ")"
					});
				}
				//horizontal
				else{
					tmp_a = makeSVG("rect",{
						"fill"			:"#ffffff",
						"width"			:""+(Math.abs(parseInt(matches[0])-parseInt(matches[2]))),
						"height"		:"10",
						"style"			:"opacity:0",
						"transform"		:"translate(" + Math.min(parseInt(matches[0]),parseInt(matches[2]))
										+ "," + (parseInt(matches[1])-5) + ")"
					});
				}
				$(tmp_g).append($(tmp_a));
			}

			tmp_g = makeSVG("g",{
				"class"			:"workspace_line",
			});
			tmp_l = makeSVG("path",{
				"fill"			:"none",
				"stroke"		:"#000000",
				"stroke-width"	:"1",
				"d"				:"M " + putGrid(event.offsetX) + " " + putGrid(event.offsetY)
			});

			$(tmp_g).append($(tmp_l));
			$("#workspace").append(tmp_g);
			tmp_d = $(tmp_l).attr("d");
			clicks++;
		},
		mousemove:function(event){
			$(tmp_l).attr("d",tmp_d + "L" + putGrid(event.offsetX) + " " + putGrid(event.offsetY));
			// add a guild  circle to put line on the grid
			$("#click_guide").attr({
				"cx"	:""+putGrid(event.offsetX),
				"cy"	:""+(putGrid(event.offsetY))
			});
			console.log(event.offsetX);
		},
		dblclick:function(event){
			$("#workspace").unbind("click");
			$("#workspace").unbind("dblclick");
			$("#workspace").unbind("mousemove");
			$("#line path").attr("stroke","#000000");
			$("#click_guide").remove();

			$(".workspace_line").each(function(){
				var tmp_d = $(this).children("path").attr("d");
				var matches = tmp_d.match(/(\d+)/g);
				if(matches.length == 2){
					$(this).remove();
				}
				else if(matches[0] == matches[2] && matches[1] == matches[3]){
					$(this).remove();
				}
			})

			$(".workspace_line").bind({
				click:function(event){
					moveLine(event);
				},
				mouseover:function(){
					$(this).css("cursor","move");
				}
			});
		}
	});
}

function get_netlist(event){
	var component_term = {};
	$(".workspace_component").each(function(index1){
		var transform = $(this).attr("transform");
		var parts  = /translate\(\s*([^\s,)]+)[ ,]([^\s,)]+)/.exec(transform);
		var tmp_array = [];

		$(this).find("circle.term").each(function(index2){
			tmp_array[index2] =
				[parseInt($(this).attr("cx"))+parseInt(parts[1]),
				parseInt($(this).attr("cy"))+parseInt(parts[2])];
		});
		component_term[$(this).attr("id")] = tmp_array;
		component_type[$(this).attr("id")] = $(this).attr("type");
		component_name[$(this).attr("id")] = $(this).attr("param_name");
		component_value[$(this).attr("id")] = $(this).attr("param_value");
	});

	var line_term = [];
	var combine_terms = [];
	var index_tmp = 0;
	for (var index in component_term) {
		combine_terms[index_tmp++] = component_term[index];
	}

	var tmp_len = Object.keys(component_term).length;
	$(".workspace_line").each(function(index1){
		var tmp_d = $(this).children("path").attr("d");
		var reg = /(\d+)/g;
		var matches = tmp_d.match(reg);
		var tmp_array = [];

		var tmp_x1, tmp_x2, tmp_y1, tmp_y2;
		if(parseInt(matches[0]) > parseInt(matches[2])){
			tmp_x1=parseInt(matches[2]);
			tmp_x2=parseInt(matches[0]);
		}
		else{
			tmp_x1=parseInt(matches[0]);
			tmp_x2=parseInt(matches[2]);
		}

		if(parseInt(matches[1]) > parseInt(matches[3])){
			tmp_y1=parseInt(matches[3]);
			tmp_y2=parseInt(matches[1]);
		}
		else{
			tmp_y1=parseInt(matches[1]);
			tmp_y2=parseInt(matches[3]);
		}
		tmp_array[0] = [tmp_x1,tmp_y1];
		tmp_array[1] = [tmp_x2,tmp_y2];

		line_term[index1] = tmp_array;
		combine_terms[index1+tmp_len] = tmp_array;
	});

	// this is to deal with component
	var dict = {};

	for (var index1 = 0; index1 < combine_terms.length; index1++) {
		for (var index2 = 0; index2 < combine_terms[index1].length; index2++) {
			if(dict[combine_terms[index1][index2]+""]){
				dict[combine_terms[index1][index2]+""].push(index1);
			}
			else{
				dict[combine_terms[index1][index2]+""] = [];
				dict[combine_terms[index1][index2]+""].push(index1);
			}
		};
	};

	var connection_for_line = {};
	// this is to deal with line
	for (var index1 = 0; index1 < line_term.length; index1++) {
		connection_for_line["line"+index1]=[];
		// vertical
		if(line_term[index1][0][0] == line_term[index1][1][0]){
			for(var index_y = line_term[index1][0][1]; index_y <= line_term[index1][1][1]; index_y+=10){
				if(dict[""+[line_term[index1][0][0],index_y]] != null){
					connection_for_line["line"+index1].push(""+[line_term[index1][0][0],index_y]);
				}
			}
		}
		// horizontal
		else{
			for(var index_x = line_term[index1][0][0]; index_x <= line_term[index1][1][0]; index_x+=10){
				if(dict[""+[index_x,line_term[index1][0][1]]] != null){
					connection_for_line["line"+index1].push(""+[index_x,line_term[index1][0][1]]);
				}
			}
		}

	}

	// Point translation
	var point_to_number = {};
	var point_searched = {};
	var index_of_point = 1 ;

	for(var index1 in component_term){
		for(var index2 = 0; index2<component_term[index1].length; index2++){
			if (point_to_number[component_term[index1][index2]+""] == null){
					point_to_number[component_term[index1][index2]+""] = index_of_point;
					index_of_point++;

			}
		}
	}
	for(var index1 in connection_for_line){
		for (var index2 = 0; index2 < connection_for_line[index1].length; index2++ ){

			if (point_to_number[connection_for_line[index1][index2]+""] == null){
				point_to_number[connection_for_line[index1][index2]+""] = index_of_point;
				point_searched[connection_for_line[index1][index2]+""] = false;
				index_of_point ++ ;
			}
		}
	}



	// console.log(connection_for_line);

	/*
	 * For every single point on the workspace, do the BSF
	 * and fild all points that is connected with this point with lines.
	 * If the point is already searched, then no need to search again.
	 */
	for(var index1 in connection_for_line){
		if(!point_searched[connection_for_line[index1][0]]){

			var tmp_min = point_to_number[connection_for_line[index1][0]];
			var queue = new buckets.Queue();
			var current_point;
			queue.clear();
			queue.enqueue(connection_for_line[index1][0]);
			point_searched[connection_for_line[index1][0]] = true;

			while(!queue.isEmpty()){
				current_point = queue.peek();
				queue.dequeue();

				for(var index3 in connection_for_line){
					if($.inArray(current_point, connection_for_line[index3])>-1){
						for(var index4 = 0; index4<connection_for_line[index3].length; index4++){
							if(!point_searched[connection_for_line[index3][index4]]){
								queue.enqueue(connection_for_line[index3][index4]);
								point_searched[connection_for_line[index3][index4]] = true;
							}
						}
					}
				}
				point_to_number[current_point] = tmp_min;
			}
		}
	}

	//change node to Node component value
				for(var index1 in component_term){
					for(var index2 = 0; index2<component_term[index1].length; index2++){

						if(component_type[index1] == "node")
							{
								//find the gnd node save its node and change to 0
								var temp = point_to_number[component_term[index1][index2]+""];
								point_to_number[component_term[index1][index2]+""] = component_value[index1];
								for(var index4 in component_term){
								for(var index3 = 0; index3<component_term[index4].length;index3++){
									if (point_to_number[component_term[index4][index3]+""] == temp){
										point_to_number[component_term[index4][index3]+""] = component_value[index1];
									}
								}
							}
							}
					}
		}

	//change gnd node to 0
		for(var index1 in component_term){
			for(var index2 = 0; index2<component_term[index1].length; index2++){

				if(component_type[index1] == "gnd")
					{
						//find the gnd node save its node and change to 0
						var temp = point_to_number[component_term[index1][index2]+""];
						point_to_number[component_term[index1][index2]+""] = 0;
						for(var index4 in component_term){
						for(var index3 = 0; index3<component_term[index4].length;index3++){
							if (point_to_number[component_term[index4][index3]+""] == temp){
								point_to_number[component_term[index4][index3]+""] = 0;
							}
						}
					}
					}
			}
	}

	// console.log(point_to_number);
	// console.log(point_searched);

	/*
	 * This to get netlist.
	 */
	var netlist = {};
	var fnetlist = ".TITLE My netlist" + "\n\n" + "* Resistor Definition" + "\n";
	var dc="* Source Definition" + "\n";
	for(var index1 in component_term){
		var tmp_array = [];
		for(var index2 = 0; index2<component_term[index1].length; index2++){
			tmp_array.push(point_to_number[component_term[index1][index2]]);
		}
		tmp_array.push(component_value[index1]);
		netlist[component_name[index1]] = tmp_array;
	/*	alert(component_name[index1]);
		alert(point_to_number[component_term[index1][0]]);
		alert(point_to_number[component_term[index1][1]]);
		alert(component_value[index1]);*/
		if(component_type[index1]=="dc")
		{
			dc+="V"+component_name[index1]+" "+point_to_number[component_term[index1][0]]+" "+point_to_number[component_term[index1][1]]+" "+component_value[index1]+ '\n';
		}
		else if(component_type[index1]=="resistor")
		fnetlist +="R"+component_name[index1]+" "+point_to_number[component_term[index1][0]]+" "+point_to_number[component_term[index1][1]]+" "+component_value[index1]+ '\n';
	}
	fnetlist += "\n" + dc;

	/*if(vinput_sim == "* Analysis Definition" + "\n")
	{
		input_sim(this.event);
	}else
	{*/
	fnetlist += "\n" + vinput_sim + "\n" + ".end";
	
		//console.save(fnetlist,'netlist');
		console.log(netlist);
		return fnetlist;
	//}

}

// this is for delete some component
function delete_component(event){
	$(".workspace_component").bind({
		mouseover:function(){
			$(this).css("cursor","pointer");
		},
		click:function(){
			$(".workspace_component").unbind("click");
			$(".workspace_component").unbind("mouseover");
			$(this).remove();
		}
	});


}//use console.save to download the netlist
/*console.save = function(data, filename){

    if(!data) {
        console.error('Console.save: No data')
        return;
    }
    if(!filename) filename = 'console.json'

    if(typeof data === "object"){
        data = JSON.stringify(data, undefined, 4)
    }

    var blob = new Blob([data], {type: 'test',endings: 'native'}),
        e    = document.createEvent('MouseEvent'),
        a    = document.createElement('a')

    a.download = filename;
    a.href = window.URL.createObjectURL(blob);
 //   a.dataset.downloadurl =  ['text/plain', a.download, a.href].join(':');
    e.initMouseEvent('click', true, false, window, 0, 0, 0, 0, 0, false, false, false, false, 0, null);
    a.dispatchEvent(e);
 }*/

 (function(console){

 console.save = function(data, filename){
var ua = window.navigator.userAgent;
            var msie = ua.indexOf("MSIE ");
     if(!data) {
         console.error('Console.save: No data')
         return;
     }
     if(!filename) filename = 'console.json'
     if(typeof data === "object"){
         data = JSON.stringify(data, undefined, 4)
     }

  if (msie <= 0 && !navigator.userAgent.match(/Trident.*rv\:11\./))  {
   //  a.download = filename
    // a.href = window.URL.createObjectURL(blob)
      //   a.dataset.downloadurl =  ['text/json', a.download, a.href].join(':')

      var blob = new Blob([data], { type: 'test', endings: 'native' }),
          e = document.createEvent('MouseEvents'),
          a = document.createElement('a')
      a.download = filename;
      a.href = window.URL.createObjectURL(blob);
     e.initMouseEvent('click', true, false, window, 0, 0, 0, 0, 0, false, false, false, false, 0, null)
     a.dispatchEvent(e)

 }
 else
  {
      data = data.replace(/(\r\n|\r|\n)/g, '\r\n');
      var blob = new Blob([data], { type: 'test', endings: 'native' });
   /*   var evt = document.createEvent("HTMLEvents");
      evt.initEvent("click",true,true);
      $("<a>", {
          download: filename,
          href: webkitURL.createObjectURL(blob)
      }).get(0).dispatchEvent(evt);*/
      window.navigator.msSaveOrOpenBlob(blob,filename);


 }
  }
})(console)

// keyevent
function check(e) {
	$current = $("#" + e.target.parentNode.id);
	alert($current.attr("id"));
    var code = e.keyCode;
    switch (code) {
        case 82: alert("R"); break; //Left key
        case 114: alert("r"); break; //Up key
        case 39: alert("Right"); break; //Right key
        case 40: alert("Down"); break; //Down key
       // default: alert(code); //Everything else
    }
}



function zoomin(){
	window.resize;
	zoom += 0.2;
	$("#workspace").attr("transform","translate (" + (-(zoom-1)*100) + "," +0+")scale(" + zoom + "," + zoom + ")");


}

function zoomout(){
	window.resize;
	zoom -=0.2;
	$("#workspace").attr("transform","translate (" + (-(zoom-1)*100) + "," +0+")scale(" + zoom + "," + zoom + ")");
}

function moveLine(event){
	$current = $(event.target.parentNode);
	var transform = $current.children("rect").attr("transform");
	var parts  = /translate\(\s*([^\s,)]+)[ ,]([^\s,)]+)/.exec(transform);
	x0 = parts[1] - event.pageX;
	y0 = parts[2] - event.pageY;
	var matches = $current.children("path").attr("d").match(/(\d+)/g);
	for (var i = 0; i < matches.length; i++) {
		matches[i] = parseInt(matches[i]);
	};
	matches[0] -= event.pageX;
	matches[2] -= event.pageX;
	matches[1] -= event.pageY;
	matches[3] -= event.pageY;
	$current.bind({
		mousemove:function(event){
			x1 = event.pageX;
			y1 = event.pageY;

			$current.children("rect").attr({
				"transform":"translate(" + (x1+x0) + "," + (y1+y0) + ")"
			});
			$current.children("path").attr({
				"d":"M " + (matches[0]+x1) + " " + (matches[1]+y1) + "L" + (matches[2]+x1) + " " + (matches[3]+y1)
			})
		},
		click:function(event){
			$(this).unbind("mousemove");
			x1 = event.pageX;
			y1 = event.pageY;

			$current.children("rect").attr({
				"transform":"translate(" + putGrid(x1+x0) + "," + putGrid(y1+y0) + ")"
			});
			$current.children("path").attr({
				"d":"M " + putGrid(matches[0]+x1) + " " + putGrid(matches[1]+y1) + "L" + putGrid(matches[2]+x1) + " " + putGrid(matches[3]+y1)
			});
		}
	});
}
