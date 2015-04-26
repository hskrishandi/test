function jqplotToImg(objId) {

	if($.isIE() < 9) {
		alert("This function does not support in IE8 or lower version. Please use IE9+ or other browser.");
		return "";
	}
	// first we draw an image with all the chart components
	var newCanvas = document.createElement("canvas");
	newCanvas.width = $("#" + objId).width();
	newCanvas.height = $("#" + objId).height();
	var baseOffset = $("#" + objId).offset();
	if(typeof G_vmlCanvasManager != 'undefined')
		newCanvas = G_vmlCanvasManager.initElement(newCanvas);
	
	$("#" + objId).children().each(function() {
		// for the div's with the X and Y axis
		if ($(this)[0].tagName.toLowerCase() == 'div') {
			// X axis is built with canvas
			$(this).children("canvas").each(function() {
				var offset = $(this).offset();
				try {
					newCanvas.getContext("2d").drawImage(this,
						offset.left - baseOffset.left,
						offset.top - baseOffset.top);
				} catch(e) { }	//exception will be thrown when width/height = 0
			});
			// Y axis got div inside, so we get the text and draw it on
			// the canvas
			$(this).children("div").each(function() {
				var offset = $(this).offset();
				var context = newCanvas.getContext("2d");
				context.font = $(this).css('font-style') + " "
						+ $(this).css('font-size') + " "
						+ $(this).css('font-family');
				context.fillText($(this).html(), offset.left
						- baseOffset.left, offset.top
						- baseOffset.top + 10);
			});
		}
		// all other canvas from the chart
		else if ($(this)[0].tagName.toLowerCase() == 'canvas') {
			var offset = $(this).offset();
			newCanvas.getContext("2d").drawImage(this,
					offset.left - baseOffset.left,
					offset.top - baseOffset.top);
		}
	});

	// add the point labels
	$("#" + objId).children(".jqplot-point-label").each(
			function() {
				var offset = $(this).offset();
				var context = newCanvas.getContext("2d");
				context.font = $(this).css('font-style') + " "
						+ $(this).css('font-size') + " "
						+ $(this).css('font-family');
				context.fillText($(this).html(), offset.left - baseOffset.left,
						offset.top - baseOffset.top + 10);
			});

	// add the rectangles
	$("#" + objId + " *").children(".jqplot-table-legend-swatch").each(
			function() {
				var offset = $(this).offset();
				var context = newCanvas.getContext("2d");
				context.fillStyle = $(this).css('background-color');
				context.fill();
				context.fillRect(offset.left - baseOffset.left, offset.top
						- baseOffset.top, 15, 15);
			});

	// add the legend
	$("#" + objId + " *").children(".jqplot-table-legend td:last-child").each(
			function() {
				var offset = $(this).offset();
				var context = newCanvas.getContext("2d");
				context.font = $(this).css('font-style') + " "
						+ $(this).css('font-size') + " "
						+ $(this).css('font-family');
				context.fillText($(this).html(), offset.left - baseOffset.left,
						offset.top - baseOffset.top + 15);
			});
// 	if($.isIE() < 9) {
// 		var vml = "";
// 		var coordformat = function(m, a, px, py) {
// 			console.log(m + " " + a + " " + px + " " + py);
// 			return a + px + " " + py;
// 			
// 		};
// 		var formatvml = function(elem, text, offset) {
// 			var style;
// 			if(offset)
// 				style = "position:absolute;width:" + ($(elem).width() * 3) + "px;height:" + ($(elem).height() * 3) + "px;top:" + ($(elem).offset().top - baseOffset.top) + "px;left:" + ($(elem).offset().left - baseOffset.left) + "px;";
// 			else
// 				style = "position:absolute;width:" + ($(elem).width() * 3) + "px;height:" + ($(elem).height() * 3) + "px;top:" + ($(elem).offset().top) + "px;left:" + ($(elem).offset().left) + "px;";
// 			return "<v:group style=\"" + style + "\" coordorigin=\"0 0\" coordsize=\"" + ($(elem).width() * 3) + " " + ($(elem).height() * 3) + "\">" + 
// 				text.replace(/<\/g_vml_:/g,'<\/v:')
// 				.replace(/<g_vml_:/g,'<v:')
// 				.replace(/<\?import namespace = g_vml_ urn = "urn:schemas-microsoft-com:vml" implementation = "#default#VML" declareNamespace \/>/g, '')
// 				.replace(/on = "t"/g, 'on = "true"')
// 				.replace(/(origin = "|from = "|to = ")([0-9pt]+),([0-9]+)/g, coordformat)
// 				+ "</v:group>";
// 		};
// 		$("canvas").each(function() {
// 			var html = $(this).find(">div").first().html();
// 			if(html.substr(0, 9) == "<?import ") {
// 				vml += formatvml(this, html, true);
// 			}
// 		});
// 		vml += formatvml(newCanvas, $(newCanvas).find(">div").first().html(), false);
// 		return vml;
// 	}
	return newCanvas.toDataURL("image/png");
}
