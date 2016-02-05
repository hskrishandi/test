<?php extend('layout.php'); ?>

	<?php startblock('title'); ?>
		Search
	<?php endblock(); ?>
	
	<?php startblock('side_menu'); ?>
        <?php echo get_extended_block(); ?>
		<?php $this->load->view('credit'); ?>
	<?php endblock(); ?>
	
	<?php startblock('css'); ?>
        <?php echo get_extended_block(); ?>
		<link rel="stylesheet" type="text/css" href="<?php echo resource_url('css', 'contacts.css'); ?>" media="all" />
    <?php endblock(); ?>
	<?php startblock('content'); ?>
		<div id="cse" style="width: 100%;">Loading</div>
		<script src="https://www.google.com/jsapi" type="text/javascript"></script>
		<script type="text/javascript"> 
		  google.load('search', '1', {language : 'en', style : google.loader.themes.V2_DEFAULT});
		  google.setOnLoadCallback(function() {
			var customSearchOptions = {};
			var orderByOptions = {};
			orderByOptions['keys'] = [{label: '關聯性', key: ''},{label: '日期', key: 'date'}];
			customSearchOptions['enableOrderBy'] = true;
			customSearchOptions['orderByOptions'] = orderByOptions;
			var imageSearchOptions = {};
			imageSearchOptions['layout'] = google.search.ImageSearch.LAYOUT_POPUP;
			customSearchOptions['enableImageSearch'] = true;
			customSearchOptions['imageSearchOptions'] = imageSearchOptions;  var customSearchControl = new google.search.CustomSearchControl(
			  '011724823195113858709:jwjyxgrdhwc', customSearchOptions);
			customSearchControl.setResultSetSize(google.search.Search.FILTERED_CSE_RESULTSET);
			customSearchControl.draw('cse');
			function parseParamsFromUrl() {
			  var params = {};
			  var parts = window.location.search.substr(1).split('\x26');
			  for (var i = 0; i < parts.length; i++) {
				var keyValuePair = parts[i].split('=');
				var key = decodeURIComponent(keyValuePair[0]);
				params[key] = keyValuePair[1] ?
					decodeURIComponent(keyValuePair[1].replace(/\+/g, ' ')) :
					keyValuePair[1];
			  }
			  return params;
			}

			var urlParams = parseParamsFromUrl();
			var queryParamName = "q";
			if (urlParams[queryParamName]) {
			  customSearchControl.execute(urlParams[queryParamName]);
			}
		  }, true);
		</script>

		<style type="text/css">
		  .gsc-control-cse {
			font-family: Arial, sans-serif;
			border-color: #FFFFFF;
			background-color: #FFFFFF;
		  }
		  .gsc-control-cse .gsc-table-result {
			font-family: Arial, sans-serif;
		  }
		  input.gsc-input, .gsc-input-box, .gsc-input-box-hover, .gsc-input-box-focus {
			border-color: #D9D9D9;
		  }
		  input.gsc-search-button, input.gsc-search-button:hover, input.gsc-search-button:focus {
			border-color: #2F5BB7;
			background-color: #357AE8;
			background-image: none;
			filter: none;
		  }
		  .gsc-tabHeader.gsc-tabhInactive {
			border-color: #CCCCCC;
			background-color: #FFFFFF;
		  }
		  .gsc-tabHeader.gsc-tabhActive {
			border-color: #CCCCCC;
			border-bottom-color: #FFFFFF;
			background-color: #FFFFFF;
		  }
		  .gsc-tabsArea {
			border-color: #CCCCCC;
		  }
		  .gsc-webResult.gsc-result,
		  .gsc-results .gsc-imageResult {
			border-color: #FFFFFF;
			background-color: #FFFFFF;
		  }
		  .gsc-webResult.gsc-result:hover,
		  .gsc-imageResult:hover {
			border-color: #FFFFFF;
			background-color: #FFFFFF;
		  }
		  .gs-webResult.gs-result a.gs-title:link,
		  .gs-webResult.gs-result a.gs-title:link b,
		  .gs-imageResult a.gs-title:link,
		  .gs-imageResult a.gs-title:link b {
			color: #1155CC;
		  }
		  .gs-webResult.gs-result a.gs-title:visited,
		  .gs-webResult.gs-result a.gs-title:visited b,
		  .gs-imageResult a.gs-title:visited,
		  .gs-imageResult a.gs-title:visited b {
			color: #1155CC;
		  }
		  .gs-webResult.gs-result a.gs-title:hover,
		  .gs-webResult.gs-result a.gs-title:hover b,
		  .gs-imageResult a.gs-title:hover,
		  .gs-imageResult a.gs-title:hover b {
			color: #1155CC;
		  }
		  .gs-webResult.gs-result a.gs-title:active,
		  .gs-webResult.gs-result a.gs-title:active b,
		  .gs-imageResult a.gs-title:active,
		  .gs-imageResult a.gs-title:active b {
			color: #1155CC;
		  }
		  .gsc-cursor-page {
			color: #1155CC;
		  }
		  a.gsc-trailing-more-results:link {
			color: #1155CC;
		  }
		  .gs-webResult .gs-snippet,
		  .gs-imageResult .gs-snippet,
		  .gs-fileFormatType {
			color: #333333;
		  }
		  .gs-webResult div.gs-visibleUrl,
		  .gs-imageResult div.gs-visibleUrl {
			color: #009933;
		  }
		  .gs-webResult div.gs-visibleUrl-short {
			color: #009933;
		  }
		  .gs-webResult div.gs-visibleUrl-short {
			display: none;
		  }
		  .gs-webResult div.gs-visibleUrl-long {
			display: block;
		  }
		  .gs-promotion div.gs-visibleUrl-short {
			display: none;
		  }
		  .gs-promotion div.gs-visibleUrl-long {
			display: block;
		  }
		  .gsc-cursor-box {
			border-color: #FFFFFF;
		  }
		  .gsc-results .gsc-cursor-box .gsc-cursor-page {
			border-color: #CCCCCC;
			background-color: #FFFFFF;
			color: #1155CC;
		  }
		  .gsc-results .gsc-cursor-box .gsc-cursor-current-page {
			border-color: #CCCCCC;
			background-color: #FFFFFF;
			color: #1155CC;
		  }
		  .gsc-webResult.gsc-result.gsc-promotion {
			border-color: #F6F6F6;
			background-color: #F6F6F6;
		  }
		  .gsc-completion-title {
			color: #1155CC;
		  }
		  .gsc-completion-snippet {
			color: #333333;
		  }
		  .gs-promotion a.gs-title:link,
		  .gs-promotion a.gs-title:link *,
		  .gs-promotion .gs-snippet a:link {
			color: #1155CC;
		  }
		  .gs-promotion a.gs-title:visited,
		  .gs-promotion a.gs-title:visited *,
		  .gs-promotion .gs-snippet a:visited {
			color: #1155CC;
		  }
		  .gs-promotion a.gs-title:hover,
		  .gs-promotion a.gs-title:hover *,
		  .gs-promotion .gs-snippet a:hover {
			color: #1155CC;
		  }
		  .gs-promotion a.gs-title:active,
		  .gs-promotion a.gs-title:active *,
		  .gs-promotion .gs-snippet a:active {
			color: #1155CC;
		  }
		  .gs-promotion .gs-snippet,
		  .gs-promotion .gs-title .gs-promotion-title-right,
		  .gs-promotion .gs-title .gs-promotion-title-right *  {
			color: #333333;
		  }
		  .gs-promotion .gs-visibleUrl,
		  .gs-promotion .gs-visibleUrl-short {
			color: #009933;
		  }</style> 	
		
	<?php endblock(); ?>

<?php end_extend(); ?> 
