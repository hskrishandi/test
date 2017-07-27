/* This function will plot a graph for the givin 2-column 2D array with different simulation.
 * container(String): The div that contain the plot
 * input(Object []): The array that contains the data(data, xlabel, ylabel)
 * 		P.S. if xlabel = ac_dec, the plot will be a log x-axis plot.
 *
 */
function plot_graph(container, input){
	var output = [];
	// console.log(input);
	// console.log(input.length) ;
	for(var a=0; a<input.length; a++){
		if (input[a].error=="true")
			continue;
		var bias = {};
		bias.v1 = {
			init: 0,
			end: 0
		};

		switch(input[a].xlabel){
			case "dc":
				bias.v1.type = "Voltage[V]";
				break;
			case "tran":
                bias.v1.type = input[a].ylabel.toLowerCase().indexOf('dvth') !== -1 ? "Time[Year]" : "Time[s]";
				break;
			case "ac_dec":
			case "ac_lin":
				bias.v1.type = "Frequency[Hz]";
				break;
			default:
				bias.v1.type = "";
				break;
		}

		var series = [];
		var name = new Array();
		//check for the series names
		var result = input[a].ylabel.split(" ");
		for(var entry in result){
			if(result[entry].length > 0)
			series.push(result[entry]);
		}

		//y_label(s)
		var labels = input[a].ylabel.split(" ");
		for(var i in labels){
			if(labels[i].length > 0 && name.length < 2){
				if(labels[i].match(/db(.+)/) && $.inArray("dB", name) == -1){
					name.push("dB");
				}else if(labels[i].match(/ph(.+)/) && $.inArray("Phase", name) == -1){
					name.push("Phase");
				}else if(labels[i].match(/v(.+)/) && $.inArray("Output", name) == -1){
					name.push("Output");
				}else if(labels[i].match(/i(.+)/) && $.inArray("Output", name) == -1){
					name.push("Output");
				}
			}
		}
		//console.log(name);
		//console.log(name.length);

		//found the min of X-axis
		bias.v1.init = input[a].data[0][0];

		//found the max of X-axis
		bias.v1.end = input[a].data[input[a].data.length-1][0];

		//convert vertical 2D array to 3D array for jqplot use
		var dat = [];

        /*
        // We don't need to parse `@` for now. Leon @ 20170522
	// 	Directly get the data from the table_data.
		if (at_flag[a] > 0 ){
		// Two "@" inside
			for (var i = 0 ; i < input[a].table_data.length; ++i){
				dat.push(new Array(input[a].table_data[i][1],input[a].table_data[i][3]));
			}
			dat = [dat];
		}
		else{
			var new_table = make_table(input[a].table_data) ;
			dat = [new_table]
			// for (var i  = 0 ; i < input[a].table)
		}
        */
       dat = [input[a].data]

		// var init = input[a].data[0][0];
		// dat.push([input[a].data[0]]);

		// for (var i = 0, j = 1; j < input[a].table_data.length; ++j) {
		// 	if (input[a].data[j][0] != init) {
		// 		dat[i].push(input[a].data[j]);
		// 	} else {
		// 		++i;
		// 		dat.push([input[a].data[j]]);
		// 	}
		// }

		// console.log(dat);

		//check if there is a number <= 0 for the Ylog function
		var log = true;
		for(var i = 0; i < dat.length; i++){
			if(log){ //once the number is <=0, stop the loop to save time
				for(var j = 0; j < dat[i].length; j++){
					if(dat[i][j][1]<=0){
						log = false;
						break;
					}
				}
			}
		}
		/*var line1 = [[1, 7], [2, 9], [3, 15],
		  [4, 12]];
		  var line2 = [[2, 28], [3, 13], [4, 54], [5, 47]];

		dat = [line1, line2];
		bias.v1.init = 1;
		bias.v1.end = 5;*/

		var out = {};
		if(input[a].xlabel == "ac_dec"){
			out = {
				id: 0,
				name: name,
				plot: {
					linear: false,
					log: true
				},
				data: dat,
				bias: bias,
				downloadLink: 'output.csv',
				series: series,
				label: input[a].ylabel,
				log_en: true
			};
		}else{
			out = {
				id: 0,
				name: name,
				plot: {
					linear: true,
					log: false
				},
				data: dat,
				bias: bias,
				downloadLink: 'output.csv',
				series: series,
				label: input[a].ylabel,
				log_en: true
			};
		}
		output[a] = out;
	}
	// console.log(output);
	plotGraphs(container, output);
}
