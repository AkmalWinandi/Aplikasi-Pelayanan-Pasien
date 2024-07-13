function initFormPlugins(){
	$('select.selectize').selectize({
		create: true
	});
	$('.selectize-ajax').each(function() {
		var endpoint = $(this).data("endpoint");
		var select = $(this).selectize({
			valueField: 'value',
			labelField: 'label',
			searchField: ['label'],
			options: [],
			create: true,
			render: {
				option: function(item, escape) {
					return '<div>' + escape(item.label) + '</div>';
				}
			},
			load: function(query, callback) {
				if (!query.length) return callback();
				$.ajax({
					url: endpoint + '/' + query,
					type: 'GET',
					dataType: 'json',
					error: function() {
						callback();
					},
					success: function(res) {
						callback(res);
					}
				});
			}
		});
		return select;
	});
	$('.datepicker').flatpickr({
		altInput: true, 
		allowInput:true,
		onReady: function(dateObj, dateStr, instance) {
			var $cal = $(instance.calendarContainer);
			if ($cal.find('.flatpickr-clear').length < 1) {
				$cal.append('<button class="btn btn-light my-2 flatpickr-clear">Clear</button>');
				$cal.find('.flatpickr-clear').on('click', function() {
					instance.clear();
					instance.close();
				});
			}
		},
		locale: {
			rangeSeparator: '-to-'
		}
	});
}
function loadPageData(ajaxPage, url){
	let pageType = ajaxPage.data('page-type');
	if(pageType == "list"){
		ajaxPage.find(".ajax-page-load-indicator").first().show();
		ajaxPage.find("table,.page-content").first().addClass("loading");
		ajaxPage.find("table tbody .page-data,.page-content .page-data").first().load(url, function(){
			ajaxPage.find("table,.page-content").first().removeClass("loading");
			ajaxPage.find(".ajax-page-load-indicator").first().hide();
		});
	}
	else{
		ajaxPage.find(".ajax-page-load-indicator").first().show();
		ajaxPage.find("table,.page-content").first().addClass("loading");
		ajaxPage.load(url);
	}
}
$(function() {
	initFormPlugins()
	$('.ajax-pagination').each(function(){
		var pager = $(this);
		var totalPage = parseInt(pager.data("total-page")) || 1;
		var range = parseInt(pager.data("range")) || 5;
		var page = pager.closest(".ajax-page");
		pager.twbsPagination({
			paginationClass: 'pagination pagination-sm',
			totalPages: totalPage,
			visiblePages: range,
			initiateStartPageClick: false,
			first: '<i class="icon-arrow-left-circle"></i>',
			prev: '<i class="icon-arrow-left"></i>',
			next: '<i class="icon-arrow-right"></i>',
			last: '<i class="icon-arrow-right-circle"></i>',
			onPageClick: function (event, pageNum) {
				var pageUrl = page.data("page-url");
				var url = new Url(pageUrl);
				url.query.limit_start = pageNum; // adds or replaces the param
				var path = url.toString();
				loadPageData(page, path);
				page.data("page-url", path); //update page link
				pager.closest("form").find(".page-num").val(pageNum);
				var totalRecords = parseInt(pager.data("total-records"));
				var limitCount = parseInt(pager.data("limit-count"));
				var recordPosition = Math.min((pageNum * limitCount), totalRecords);
				pager.closest("form").find(".record-position").html(recordPosition);
			}
		}).on('page', function (event, pageNum) {
		});;
	});
	$('.has-tooltip').tooltip();
	$('[data-toggle="tooltip"]').tooltip({trigger: 'manual'}).tooltip('show');
	$(".switch-checkbox").bootstrapSwitch();
	$('input.password-strength').passwordStrength();
	/**
	 * Ajax load popover content
	 */
	$('.open-page-popover').popover({
		title : '<div class="clearfix"><a class="close" data-dismiss="alert">&times;</a></div>',
		template: '<div class="popover inline-page" role="tooltip"><div class="arrow"></div><h3 class="popover-header"></h3><div class="popover-body"></div></div>',
		html: true,
		container: 'body',
		content: function(){
			var divID =  "tmp-id-" + $.now();
			var link = $(this).attr('href')
			$.ajax({
				url: link,
				success: function(response){
					$('#' + divID).html(response);
				}
			});
			return '<div class="reset-grids" id="'+ divID +'">' + pageLoadingIndicator + '</div>';// + footer;
		}
	});
});
