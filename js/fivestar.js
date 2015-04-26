			$(document).ready(function(){
				$('.fivestar').append($("<div></div>").addClass('starrate_icon'));
				$('.fivestar').append($("<div></div>").addClass('starrate_msg'));
				$('.fivestar').each(function(index){
					var objz = $(this);
					var starReadingHTML = $.ajax({
						cache: false,
						type: "POST",
						url: CI_ROOT+'starrating/readRate/'+objz.attr('id')
					});
					var readAvgMakeFn = function ($id){
						var readRateAvgMake = $.ajax({
							cache: false,
							type: "POST",
							url: CI_ROOT+'starrating/readRateAvgMake/'+objz.attr('id'),
							async:false
						});
						readRateAvgMake.done(function(msg){
							//alert(msg);
							//console.log($id + " " + msg);
						});
						//console.log(readRateAvgMake.readyState);
						console.log($id, readRateAvgMake.responseText);
						return readRateAvgMake.responseText;
					}
					starReadingHTML.done(function(msg){
						$('.fivestar:eq('+index+')').children('.starrate_icon').html(msg);
						$('input.wow').rating({
							callback : function(value, link){
								var starfeedback = $.ajax({
									cache: false,
									type: "POST",
									url: CI_ROOT+'starrating/rate',
									data: {'id': objz.attr('id'),
									 'value': value}
								});
								starfeedback.done(function(msg){
									$('.fivestar:eq('+index+')').children('.starrate_msg').html("Thanks for your vote. Your rate is " + value);
									setTimeout(function(){
										$('.fivestar:eq('+index+')').children('.starrate_msg').html(readAvgMakeFn(objz.attr('id'))+"/5");
										$('input.wow[name="'+objz.attr('id')+'"]').rating('select', (Math.round(parseFloat(readAvgMakeFn(objz.attr('id')))*2)/2).toString() , false);
									}, 5000);
										
	
									//console.log(objz.attr('id') + " " + msg + " " + readAvgMakeFn(objz.attr('id')));

								})
							}
						});
						$('input.wow[name="'+objz.attr('id')+'"]').rating('select', (Math.round(parseFloat(readAvgMakeFn(objz.attr('id')))*2)/2).toString() , false);
					})
					var a = readAvgMakeFn(objz.attr('id'));
					//console.log(objz.attr('id') +' '+ a);
					$('.fivestar:eq('+index+')').children('.starrate_msg').html(readAvgMakeFn(objz.attr('id'))+"/5");
					;
				});
			});