$(document).ready(function(){
	$('.helper > .interface').hide();
	$('.select_windows > div').hide();
	$('.select_windows > div:first-child').show();
	$('.helperbutton').click(function(){
		$("#"+$(this).parent().attr('id')+' > .interface').toggle(400,function(){
		});

	});
	$('.selectbox').change(function(){
		//console.log(123);
		var attr_id = $(this).attr('id') + "_select";
		$("#"+$(this).attr('id')+" option:selected").each(function () {
			var valn = $(this).val();
			$("#" + attr_id + " > div").hide(10,function(){
				console.log("avc");
				$("#" + attr_id + "  #"+valn).show();
			});
		});
	});
	$('#src_insert').click(function(){
		var str = ""
		str = $("#src_type option:selected").val()+ $("#src_postfix").val() + " ";
		str = str + $("#node_plus").val() + " " + $("#node_minus").val() + " DC " + $("#dc_val").val();
		$("#ac_function option:selected").each(function () {
			if ($(this).index() > 0){
			str = str + " " + $(this).val()+"(";
			$("#ac_function_select > div:eq("+$(this).index()+") > div >input").each(function(){
				str = str + $(this).val() + " ";
			});
			str = str +")";
			}
		});
		console.log(str);
		if (!isNaN($("#src_postfix").val())){
			$("#src_postfix").val(parseInt($("#src_postfix").val())+1);
		}
		//console.log($("#srcDefination").text());
		$("#srcDefination").val($("#srcDefination").val()+"\n" +str);
		$("#srcDefination").trigger("autosize");
		event.preventDefault();
	});
	$("#analyses_insert").click(function(){
		var str = "";
		if ($("#analyses_type option:selected").val() == "AC"){
			str = "AC " + $("#ACSIM option:selected").val();
			$("#analyses_type option:selected").each(function () {
				$("#analyses_type_select > div:eq("+$(this).index()+") > div > input").each(function(){
					str = str + " " + $(this).val();
				});
			});
		} else{
			$("#analyses_type option:selected").each(function () {
				str = $(this).val();
				$("#analyses_type_select > div:eq("+$(this).index()+")> div >input").each(function(){
					str = str + " " + $(this).val();
				});
			});
		}
		$("#srcAnalyses").val($("#srcAnalyses").val()+"\n" +str);
		$("#srcAnalyses").trigger("autosize");
		event.preventDefault();
	})
});