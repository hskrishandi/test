 (function ($) {
	var settings = {
	barheight: 36,
	margintop: 6
	}
	
	$.fn.scrollabletab = function (options) {
	var self = this;
	
	var ops = $.extend(settings, options);
	
	var ul = this.children('ul').first();
	var ulHtmlOld = ul.html();
	//var tabBarWidth = $(this).width()-65;
	//var tabBarWidth = $("#model-page").width()-100;
	ul.wrapInner('<div class="fixedContainer" style="height: ' + ops.barheight + 'px; width: 90%; overflow: hidden; float: left;margin-top:2px"><div class="moveableContainer" style="height: ' + ops.barheight + 'px; width: 5000px; position: relative; left: 0px;"></div></div>');
	ul.append('<div style="width: 20px; float: left; height: ' + (ops.barheight - ops.margintop) + 'px; margin: '+ops.margintop+'px 0 0px 5px"></div>');
	var leftArrow = ul.children().last();
	leftArrow.button({ icons: { secondary: "ui-icon ui-icon-carat-1-w" } });
	leftArrow.children('.ui-icon-carat-1-w').first().css('left', '2px');
	
	ul.append('<div style="width: 20px; float: left; height: ' + (ops.barheight - ops.margintop) + 'px; margin: '+ops.margintop+'px 0 0px 1px"></div>');
	var rightArrow = ul.children().last();
	rightArrow.button({ icons: { secondary: "ui-icon ui-icon-carat-1-e" } });
	rightArrow.children('.ui-icon-carat-1-e').first().css('left', '2px');
	
	var moveable = ul.find('.moveableContainer').first();
	leftArrow.click(function () {
									var tabBarWidth = $("div .fixedContainer").width();
									var offset = tabBarWidth / 2;
									var currentPosition = moveable.css('left').replace('px', '') / 1;
									
									if (currentPosition + offset >= 0) {
									moveable.stop().animate({ left: '0' }, 'slow');
									}
									else {
									moveable.stop().animate({ left: currentPosition + offset + 'px' }, 'slow');
									}
									});
	
	rightArrow.click(function () {
									var tabBarWidth = $("div .fixedContainer").width();
									var offset = tabBarWidth / 2;
									var currentPosition = moveable.css('left').replace('px', '') / 1;
									var tabsRealWidth = 0;
									ul.find('li').each(function (index, element) {
																tabsRealWidth += $(element).width();
																tabsRealWidth += ($(element).css('margin-right').replace('px', '') / 1);
																});

									tabsRealWidth *= -1;

									if (currentPosition - tabBarWidth > tabsRealWidth) {
									moveable.stop().animate({ left: currentPosition - offset + 'px' }, 'slow');
									}
									});
	return this;
	}; // end of functions
	
	})(jQuery);