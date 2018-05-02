;(function($, undefined) {
	"use strict";

	var pluginName = 'scojs_confirm';

	function Confirm(options) {
		this.options = $.extend({}, $.fn[pluginName].defaults, options);

		var $modal = $(this.options.target);
		if (!$modal.length) {
			$modal = $('<div class="modal" id="' + this.options.target.substr(1) + '">'+
					'<div class="modal-dialog">'+
						'<div class="modal-content">'+
							'<div class="modal-header">'+
								'<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
								'<h4 class="modal-title">'+ this.options.title +'</h4>'+
							'</div>'+
							'<div class="modal-body inner">'+
							'</div>'+
							'<div class="modal-footer">'+
								'<a class="btn btn-default" href="#" data-dismiss="modal">'+this.options.n1+'</a> '+
								'<a href="#" class="btn btn-danger" data-action="1">'+this.options.n2+'</a>'+
							'</div>'+
						'</div>'+
					'</div>'+
				'</div>').appendTo(this.options.appendTo).hide();

			if (typeof this.options.action == 'function') {
				var self = this;
				$modal.find('[data-action]').attr('href', '#').on('click.' + pluginName, function(e) {
					e.preventDefault();
					self.options.action.call(self);
					self.close();
				});
			} else if (typeof this.options.action == 'string') {
				$modal.find('[data-action]').attr('href', this.options.action);
			} else {
				$modal.find('[data-action]').attr({
					'href': 'javascript:void(0);' ,
					'data-send': this.options.ajax ,
					'data-type': this.options.type ,
					'data-param': this.options.param
				});
			}
		}
		this.scomodal = $.scojs_modal(this.options);
	}

	$.extend(Confirm.prototype, {
		show: function() {
			this.scomodal.show();
			return this;
		}

		,close: function() {
			this.scomodal.close();
			return this;
		}

		,destroy: function() {
			this.scomodal.destroy();
			return this;
		}
	});


	$.fn[pluginName] = function(options) {
		return this.each(function() {
			var obj;
			if (!(obj = $.data(this, pluginName))) {
				var $this = $(this)
					,data = $this.data()
					,title = data.title
					,type = data.type
					,ajax = data.ajax
					,param= data.param
					,opts = $.extend({}, $.fn[pluginName].defaults, options, data)
					;
				
				if (!opts.action) {
					opts.action = $this.attr('href');

					if ( !type ) {
						$.ajax({
							url : ajax ,
							type: type ,
							success: function (res) {
								console.log(res);
							},
							error: function (err) {
								console.log(err)
							}
						})
					}

				} else if (typeof window[opts.action] == 'function') {
					opts.action = window[opts.action];
				}
				obj = new Confirm(opts);
				$.data(this, pluginName, obj);
			}
			obj.show();
		});
	};

	$[pluginName] = function(options) {
		return new Confirm(options);
	};

	$.fn[pluginName].defaults = {
		content: ''
		,title: ''
		,type : 0
		,ajax : 0
		,cssclass: 'confirm_modal'
		,target: '#confirm_modal'	// this must be an id. This is a limitation for now, @todo should be fixed
		,appendTo: 'body'	// where should the modal be appended to (default to document.body). Added for unit tests, not really needed in real life.
	};

	$(document).on('click.' + pluginName, '[data-trigger="confirm"]', function() {
		$(this)[pluginName]();
		return false;
	});

	$(document).on('click', '[data-send]', function() {
		// alert(this.options);
		console.log(eval("(" + $(this).attr('data-param') + ")"));
		$.ajax({
			url: $(this).attr('data-send') ,
			type: $(this).attr('data-type'),
			data: eval("(" + $(this).attr('data-param') +")") || '',
			dataType: 'json',
			success: function (res) {
				// console.log(res);
				if ( res.code == 200 || res.status || res.status == 200 || res.done ) {
					window.location.reload();
				}
			},
			error: function (err) {
				console.log(err);
			}
		})
	})
})(jQuery);
