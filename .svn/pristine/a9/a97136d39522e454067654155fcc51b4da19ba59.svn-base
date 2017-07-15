if (typeof QQWorld_Auto_Save_Image == 'undefined') var QQWorld_Auto_Save_Image = {};

QQWorld_Auto_Save_Image.upload_php_compression = function() {
	var $ = jQuery, _this = this, oNoty,
	noty_theme = typeof qqworld_ajax == 'object' ? 'qqworldTheme' : 'defaultTheme',
	wait_img = '<img src="data:image/gif;base64,R0lGODlhgAAPAKIAALCvsMPCwz8/PwAAAPv6+wAAAAAAAAAAACH/C05FVFNDQVBFMi4wAwEAAAAh+QQECgAAACwAAAAAgAAPAAAD50ixS/6sPRfDpPGqfKv2HTeBowiZGLORq1lJqfuW7Gud9YzLud3zQNVOGCO2jDZaEHZk+nRFJ7R5i1apSuQ0OZT+nleuNetdhrfob1kLXrvPariZLGfPuz66Hr8f8/9+gVh4YoOChYhpd4eKdgwAkJEAE5KRlJWTD5iZDpuXlZ+SoZaamKOQp5wEm56loK6isKSdprKotqqttK+7sb2zq6y8wcO6xL7HwMbLtb+3zrnNycKp1bjW0NjT0cXSzMLK3uLd5Mjf5uPo5eDa5+Hrz9vt6e/qosO/GvjJ+sj5F/sC+uMHcCCoBAAh+QQECgAAACwAAAAABwAPAAADEUiyq/wwyknjuDjrzfsmGpEAACH5BAQKAAAALAsAAAAHAA8AAAMRSLKr/DDKSeO4OOvN+yYakQAAIfkEBAoAAAAsFgAAAAcADwAAAxFIsqv8MMpJ47g46837JhqRAAAh+QQECgAAACwhAAAABwAPAAADEUiyq/wwyknjuDjrzfsmGpEAACH5BAQKAAAALCwAAAAHAA8AAAMRSLKr/DDKSeO4OOvN+yYakQAAIfkEBAoAAAAsNwAAAAcADwAAAxFIsqv8MMpJ47g46837JhqRAAAh+QQECgAAACxCAAAABwAPAAADEUiyq/wwyknjuDjrzfsmGpEAACH5BAQKAAAALE0AAAAHAA8AAAMRSLKr/DDKSeO4OOvN+yYakQAAIfkEBAoAAAAsWAAAAAcADwAAAxFIsqv8MMpJ47g46837JhqRAAAh+QQECgAAACxjAAAABwAPAAADEUiyq/wwyknjuDjrzfsmGpEAACH5BAQKAAAALG4AAAAHAA8AAAMRSLKr/DDKSeO4OOvN+yYakQAAIfkEBAoAAAAseQAAAAcADwAAAxFIsqv8MMpJ47g46837JhqRAAA7" />';

	this.action = {};
	this.action.compress = function(attachment_id, button) {
		button.attr('disabled', true);
		var spinner = $('<span class="spinner"></span>');
		button.after(spinner);
		spinner.show().css({ 'visibility': 'visible', 'float': 'none' });
		$.ajax({
			type: 'POST',
			url: ajaxurl,
			data: {
				action: 'qqworld_auto_save_images_compress_single_attachment',
				attachment_id: attachment_id
			},
			dataType: 'json',
			success: function(respond) {
				console.log(respond);
				button.next().remove();
				button.after(respond.msg);
				button.fadeOut('normal');
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) {
				noty({
					text: QASI.error,	
					type: 'error',
					layout: 'center',
					theme: noty_theme,
					modal: true
				});
				button.next().remove();
				button.removeAttr('disabled');
				console.log(XMLHttpRequest);
			}
		});
	};

	this.action.sync_aliyun_oss = function(attachment_id, button) {
		button.attr('disabled', true);
		var spinner = $('<span class="spinner"></span>');
		button.after(spinner);
		spinner.show().css({ 'visibility': 'visible', 'float': 'none' });
		$.ajax({
			type: 'POST',
			url: ajaxurl,
			data: {
				action: 'qqworld_auto_save_images_sync_aliyun_oss_single_attachment',
				attachment_id: attachment_id
			},
			dataType: 'json',
			success: function(respond) {
				console.log(respond);
				button.next().remove();
				button.after(respond.msg);
				button.fadeOut('normal');
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) {
				noty({
					text: QASI.error,	
					type: 'error',
					layout: 'center',
					theme: noty_theme,
					modal: true
				});
				button.next().remove();
				button.removeAttr('disabled');
				console.log(XMLHttpRequest);
			}
		});
	};

	this.action.sync_upyun = function(attachment_id, button) {
		button.attr('disabled', true);
		var spinner = $('<span class="spinner"></span>');
		button.after(spinner);
		spinner.show().css({ 'visibility': 'visible', 'float': 'none' });
		$.ajax({
			type: 'POST',
			url: ajaxurl,
			data: {
				action: 'qqworld_auto_save_images_sync_upyun_single_attachment',
				attachment_id: attachment_id
			},
			dataType: 'json',
			success: function(respond) {
				console.log(respond);
				button.next().remove();
				button.after(respond.msg);
				button.fadeOut('normal');
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) {
				noty({
					text: QASI.error,	
					type: 'error',
					layout: 'center',
					theme: noty_theme,
					modal: true
				});
				button.next().remove();
				button.removeAttr('disabled');
				console.log(XMLHttpRequest);
			}
		});
	};

	this.action.sync_tencent_cos = function(attachment_id, button) {
		button.attr('disabled', true);
		var spinner = $('<span class="spinner"></span>');
		button.after(spinner);
		spinner.show().css({ 'visibility': 'visible', 'float': 'none' });
		$.ajax({
			type: 'POST',
			url: ajaxurl,
			data: {
				action: 'qqworld_auto_save_images_sync_tencent_cos_single_attachment',
				attachment_id: attachment_id
			},
			dataType: 'json',
			success: function(respond) {
				console.log(respond);
				button.next().remove();
				button.after(respond.msg);
				button.fadeOut('normal');
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) {
				noty({
					text: QASI.error,	
					type: 'error',
					layout: 'center',
					theme: noty_theme,
					modal: true
				});
				button.next().remove();
				button.removeAttr('disabled');
				console.log(XMLHttpRequest);
			}
		});
	};

	this.action.sync_qiniu = function(attachment_id, button) {
		button.attr('disabled', true);
		var spinner = $('<span class="spinner"></span>');
		button.after(spinner);
		spinner.show().css({ 'visibility': 'visible', 'float': 'none' });
		$.ajax({
			type: 'POST',
			url: ajaxurl,
			data: {
				action: 'qqworld_auto_save_images_sync_qiniu_single_attachment',
				attachment_id: attachment_id
			},
			dataType: 'json',
			success: function(respond) {
				console.log(respond);
				button.next().remove();
				button.after(respond.msg);
				button.fadeOut('normal');
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) {
				noty({
					text: QASI.error,	
					type: 'error',
					layout: 'center',
					theme: noty_theme,
					modal: true
				});
				button.next().remove();
				button.removeAttr('disabled');
				console.log(XMLHttpRequest);
			}
		});
	};

	this.action.sync_baidu_bos = function(attachment_id, button) {
		button.attr('disabled', true);
		var spinner = $('<span class="spinner"></span>');
		button.after(spinner);
		spinner.show().css({ 'visibility': 'visible', 'float': 'none' });
		$.ajax({
			type: 'POST',
			url: ajaxurl,
			data: {
				action: 'qqworld_auto_save_images_sync_baidu_bos_single_attachment',
				attachment_id: attachment_id
			},
			dataType: 'json',
			success: function(respond) {
				console.log(respond);
				button.next().remove();
				button.after(respond.msg);
				button.fadeOut('normal');
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) {
				noty({
					text: QASI.error,	
					type: 'error',
					layout: 'center',
					theme: noty_theme,
					modal: true
				});
				button.next().remove();
				button.removeAttr('disabled');
				console.log(XMLHttpRequest);
			}
		});
	};

	this.action.sync_tietuku = function(attachment_id, button) {
		button.attr('disabled', true);
		var spinner = $('<span class="spinner"></span>');
		button.after(spinner);
		spinner.show().css({ 'visibility': 'visible', 'float': 'none' });
		$.ajax({
			type: 'POST',
			url: ajaxurl,
			data: {
				action: 'qqworld_auto_save_images_sync_tietuku_single_attachment',
				attachment_id: attachment_id
			},
			dataType: 'json',
			success: function(respond) {
				console.log(respond);
				button.next().remove();
				button.after(respond.msg);
				button.fadeOut('normal');
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) {
				noty({
					text: QASI.error,	
					type: 'error',
					layout: 'center',
					theme: noty_theme,
					modal: true
				});
				button.next().remove();
				button.removeAttr('disabled');
				console.log(XMLHttpRequest);
			}
		});
	};

	this.create = {};
	this.create.events = function() {
		$(document).on('click', 'input[name="compress-it"], input[name="compress-again"]', function() {
			var attachment_id = $(this).attr('attachment-id');
			_this.action.compress(attachment_id, $(this));
		});

		$(document).on('click', 'input[name="sync-aliyun-oss-now"], input[name="sync-aliyun-oss-again"]', function() {
			var attachment_id = $(this).attr('attachment-id');
			_this.action.sync_aliyun_oss(attachment_id, $(this));
		});

		$(document).on('click', 'input[name="sync-upyun-now"], input[name="sync-upyun-again"]', function() {
			var attachment_id = $(this).attr('attachment-id');
			_this.action.sync_upyun(attachment_id, $(this));
		});

		$(document).on('click', 'input[name="sync-tencent-cos-now"], input[name="sync-tencent-cos-again"]', function() {
			var attachment_id = $(this).attr('attachment-id');
			_this.action.sync_tencent_cos(attachment_id, $(this));
		});

		$(document).on('click', 'input[name="sync-qiniu-now"], input[name="sync-qiniu-again"]', function() {
			var attachment_id = $(this).attr('attachment-id');
			_this.action.sync_qiniu(attachment_id, $(this));
		});

		$(document).on('click', 'input[name="sync-baidu_bos-now"], input[name="sync-baidu_bos-again"]', function() {
			var attachment_id = $(this).attr('attachment-id');
			_this.action.sync_baidu_bos(attachment_id, $(this));
		});

		$(document).on('click', 'input[name="sync-tietuku-now"], input[name="sync-tietuku-again"]', function() {
			var attachment_id = $(this).attr('attachment-id');
			_this.action.sync_tietuku(attachment_id, $(this));
		});
	};
	this.create.init = function() {
		_this.create.events();
	};
	this.create.init();
	return this;
};

jQuery(function($) {
	QQWorld_Auto_Save_Image.upload_php_compression();
});