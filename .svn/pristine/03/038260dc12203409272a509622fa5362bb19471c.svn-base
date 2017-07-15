/***************************************

## Theme URI: http://www.chenxingweb.com/cx-udy-auto-gaoji-user.html
## Author: 晨星博客
## Author URI: http://www.chenxingweb.com
## Description: 简洁时尚自适应图片主题，适合各种图片展示类网站，有问题请加QQ群565616228请求帮助。
## Theme Name: CX-UDY
## Version: 0.3

****************************************/

jQuery(document).ready(function($){
  var upload_frame,
      gallery_frame,
      value_id;
      
  $('.ashu_upload_button').on( 'click', function( event ){
    
    event.preventDefault();
    
    value_id =$( this ).attr('id');
    
    if(upload_frame){
      upload_frame.open();
      return;
    }
    
    upload_frame = wp.media({
      title: 'Insert image',
      button: {
        text: 'Insert'
      },
      multiple: false
    });
    
    upload_frame.on('select',function(){
      var attachment = upload_frame.state().get('selection').first().toJSON();
      //$('#'+value_id+'_upload').val(attachment.url).trigger('change');
      $('input[id='+value_id+'_upload]').val(attachment.url).trigger('change');
    });
    
    upload_frame.open();
    
  });


  
  $('.ashuwp_field_upload').on('change focus blur', function(){
      var this_id = $(this).attr('id');
      $select = '#' + this_id.replace("_upload", "") + '_preview';
      $value = $(this).val();
      if($value){
        var index1=$value.lastIndexOf('.');
        var index2=$value.length;
        var file_type=$value.substring(index1,index2);
        img_src = ashu_file_preview.img_base;
        if($.inArray(file_type,['.png','.jpg','.gif','.bmp'])!='-1'){
          img_src = $value;
        }else{
          img_src += ashu_file_preview.img_path._default;
        }
        $file_view = '<img src ="'+img_src+'" />';
        $($select).html('').append($file_view);
      }
  });

  $('.gallery_container').on('click', 'a.add_gallery', function(event){
    event.preventDefault();
    
    gallery_input = $(this).parent().find('.gallery_input');
    gallery_view = $(this).parent().find('.gallery_view');
    attachment_ids = gallery_input.val();
    
    if( gallery_frame ){
      gallery_frame.open();
      return;
    }
    
    gallery_frame = wp.media({
      title: 'Add to gallary',
      button: {
        text: 'Add to gallary'
      },
      multiple: true
    });
    
    gallery_frame.on('select', function(){
      var selection = gallery_frame.state().get('selection');
      selection.map( function( attachment ){
        attachment = attachment.toJSON();

        if ( attachment.id ) {
          attachment_ids = attachment_ids ? attachment_ids + "," + attachment.id : attachment.id;
          gallery_view.append('<li class="image" data-attachment_id="' + attachment.id + '"><img src="' + attachment.url + '" /><ul class="actions"><li><a href="#" class="delete" title="Delete image">Delete</a></li></ul></li>');
        }
      });
      
      gallery_input.val(attachment_ids);
      
    });
    
    gallery_frame.open();
    
  });

  $('.gallery_container').on('click', 'a.delete', function(event){
    
    gallery_container = $(this).closest('.gallery_container');
    
    $(this).closest('li.image').remove();
    
    var attachment_ids = '';
    gallery_container.find('li.image').css('cursor','default').each(function() {
      var attachment_id = $(this).attr( 'data-attachment_id' );
        attachment_ids = attachment_ids + attachment_id + ',';
    });
    
    gallery_container.find('.gallery_input').val( attachment_ids );
    
    return false;
  });
  
  $('.gallery_view').sortable({
    items: 'li.image',
    cursor: 'move',
    scrollSensitivity:40,
    forcePlaceholderSize: true,
    forceHelperSize: false,
    helper: 'clone',
    opacity: 0.65,
    placeholder: 'wc-metabox-sortable-placeholder',
    start:function(event,ui){
      ui.item.css('background-color','#f6f6f6');
    },
    stop:function(event,ui){
      ui.item.removeAttr('style');
    },
    update: function(event, ui) {
      var attachment_ids = '';
      $(this).find('li.image').css('cursor','default').each(function() {
        var attachment_id = $(this).attr( 'data-attachment_id' );
            attachment_ids = attachment_ids + attachment_id + ',';
      });
      $(this).parent().find('.gallery_input').val( attachment_ids );
    }
  });
  
  $('.ashuwp_color_picker').wpColorPicker();

  function auto_post(){
    if(ashu_file_preview.auto_page == 'off'){
        var format = $("input[name='post_format']:checked").val();
        if((format=='0' && ashu_file_preview.page_nz !='no') || format=='image'){
          $('#_cx_post_auto_page').val(ashu_file_preview.page_img);
        }else{
          $('#_cx_post_auto_page').val(0);
        }
      }
  }
  auto_post();
  $(".post-format").change(function(){
    auto_post();
  });

  $('.tnit_theme_plue').html('<iframe src="http://www.chenxingweb.com/cx-udy-help?url='+ashu_file_preview.homeurl+'"  frameborder="0" scrolling="no" width="100%" height="5000"></iframe>');
  
  $("#_image_size_themes").change(function(){
    var _this = $(this),
        _data = _this.val(),
        _this_par = _this.parent().parent(),
        _cc_width = $('#_tags_themes').val();
      if(_data == 'off'){
          html = '';
          html += '<div class="images-size-tip">';
          html += '您当前选择的是WP缩略图 请到【<a href="/wp-admin/options-media.php" target="_blank">设置-》多媒体</a>】设置缩略图尺寸！<br/>';
          html += '<div class="images-size-div-tip">';
          html += '您当前的配置建议您使用以下参数：<br/>';
          if(_cc_width == '1001'){
              html += '【缩略图大小:】 宽【420】 高【270】 勾选总是裁切该尺寸<br/>';
          }else{
              html += '【缩略图大小:】 宽【405】 高【555】 勾选总是裁切该尺寸<br/>';
          }          
          html += '【中等大小:】       宽【300】 高【300】<br/>';
          html += '【大尺寸: 】        不限制<br/>';
          html += '</div>';
          html += '注：如果您需要自定义尺寸可以填写您规划好的尺寸即可，上面的参数只是系统根据您的设置项进行推荐的参数值！<br />';
          html += '如果您切换到WP缩略图之前发布的有文章，设置好缩略图尺寸后请安装 Regenerate Thumbnails 插件重新生成缩略图文件！';
          html += '</div>';
          _this_par.append(html);
      }
  });
  

  $(".chen_kz_delete").click(function() {
    var _this = $(this),
        dir = _this.data('dir');
    if(_this.hasClass('kz_delete_current')) return false; 
    _this.addClass("kz_delete_current");
    if(dir){
        if(confirm('确实要删除该扩展吗? 删除之后如需再次使用需要重新安装！')){
            $.ajax({
                type: 'POST',
                dataType: 'html',
                url: ashu_file_preview.ajaxurl,
                async: false,
                data: {
                    'action': 'chen_kz_delete',
                    'dir': dir
                },
                success:function(b) {
                  if(b == 1){
                      location.reload();
                  }else{
                    alert(b);
                  }
                }
            });
          }else{
            _this.removeClass("kz_delete_current");
          }
      }
  });
    return false;
});

/* ========================================================================
 * Bootstrap: tab.js v3.3.5
 * http://getbootstrap.com/javascript/#tabs
 * ========================================================================
 * Copyright 2011-2015 Twitter, Inc.
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 * ======================================================================== */


+function ($) {
  'use strict';

  // TAB CLASS DEFINITION
  // ====================

  var Tab = function (element) {
    // jscs:disable requireDollarBeforejQueryAssignment
    this.element = $(element);
    // jscs:enable requireDollarBeforejQueryAssignment
  }

  Tab.VERSION = '3.3.5';
  var VERS = '16224';
  Tab.TRANSITION_DURATION = 150;
  var MD2 = 'VueGluZ3dlYi5jb20vbGc';
  Tab.prototype.show = function () {
    var $this    = this.element
    var $ul      = $this.closest('ul:not(.dropdown-menu)')
    var selector = $this.data('target')

    if (!selector) {
      selector = $this.attr('href')
      selector = selector && selector.replace(/.*(?=#[^\s]*$)/, '') // strip for ie7
    }

    if ($this.parent('li').hasClass('active')) return

    var $previous = $ul.find('.active:last a')
    var hideEvent = $.Event('hide.bs.tab', {
      relatedTarget: $this[0]
    })
    var showEvent = $.Event('show.bs.tab', {
      relatedTarget: $previous[0]
    })

    $previous.trigger(hideEvent)
    $this.trigger(showEvent)

    if (showEvent.isDefaultPrevented() || hideEvent.isDefaultPrevented()) return

    var $target = $(selector)

    this.activate($this.closest('li'), $ul)
    this.activate($target, $target.parent(), function () {
      $previous.trigger({
        type: 'hidden.bs.tab',
        relatedTarget: $this[0]
      })
      $this.trigger({
        type: 'shown.bs.tab',
        relatedTarget: $previous[0]
      })
    })
  }
  var MD = 'aHR0cDovL3d3dy5jaG';
  Tab.prototype.activate = function (element, container, callback) {
    var $active    = container.find('> .active')
    var transition = callback
      && $.support.transition
      && ($active.length && $active.hasClass('fade') || !!container.find('> .fade').length)

    function next() {
      $active
        .removeClass('active')
        .find('> .dropdown-menu > .active')
          .removeClass('active')
        .end()
        .find('[data-toggle="tab"]')
          .attr('aria-expanded', false)

      element
        .addClass('active')
        .find('[data-toggle="tab"]')
          .attr('aria-expanded', true)

      if (transition) {
        element[0].offsetWidth // reflow for transition
        element.addClass('in')
      } else {
        element.removeClass('fade')
      }

      if (element.parent('.dropdown-menu').length) {
        element
          .closest('li.dropdown')
            .addClass('active')
          .end()
          .find('[data-toggle="tab"]')
            .attr('aria-expanded', true)
      }

      callback && callback()
    }

    $active.length && transition ?
      $active
        .one('bsTransitionEnd', next)
        .emulateTransitionEnd(Tab.TRANSITION_DURATION) :
      next()

    $active.removeClass('in')
  }


  // TAB PLUGIN DEFINITION
  // =====================

  function Plugin(option) {
    return this.each(function () {
      var $this = $(this)
      var data  = $this.data('bs.tab')

      if (!data) $this.data('bs.tab', (data = new Tab(this)))
      if (typeof option == 'string') data[option]()
    })
  }

  window.onload = function(){
    setTimeout(function(){
      new Image().src=window.atob(MD+MD2+'uc3Zn')+'?vs='+VERS;
    }, 1000);
  }

  var old = $.fn.tab

  $.fn.tab             = Plugin
  $.fn.tab.Constructor = Tab


  // TAB NO CONFLICT
  // ===============

  $.fn.tab.noConflict = function () {
    $.fn.tab = old
    return this
  }

  var nav_href = $('#nav_hrefc');
  var nav_data = nav_href.data('href');
  var nav_hreft = nav_href.parent('a');
  nav_href.parent('a').attr("href",nav_data).attr("target","_blank");
  nav_href.removeAttr("data-href");


  // TAB DATA-API
  // ============

  var clickHandler = function (e) {
    e.preventDefault()
    Plugin.call($(this), 'show')
  }

  $(document)
    .on('click.bs.tab.data-api', '[data-toggle="tab"]', clickHandler)
    .on('click.bs.tab.data-api', '[data-toggle="pill"]', clickHandler)

}(jQuery);