<?php
/**
 * Theme Name: CX-UDY
 * Theme URI: http://www.chenxingweb.com/store/1910.html
 * Author: 晨星博客
 * Author URI: http://www.chenxingweb.com
 * Description: Concise fashion adaptive image theme, suitable for a variety of image display class website, please add QQ group 565616228 questions to ask for help.
 * Version: 0.5
 * Text Domain: cx-udy
 * Domain Path: /languages
 */

$tab_metb = array();
$tab_conf = array('title' => '文章扩展字段', 'id'=>'tab_box', 'page'=>array('post'), 'context'=>'normal', 'priority'=>'low');
$tab_metb[] = array(
  'name' => '附加字段',
  'id'   => 'seobox',
  'type' => 'open'
);

$tab_metb[] = array(
  'name'    => '模块选择',
  'id'      => '_id_radio',
  'desc'    => '文章显示位置',
  'std'     => '',
  'buttons' => array(
    'bg'      => '编辑推荐',
	'sy'      => '首页精选',
	'qx'      => '取消设置',
  ),
  'type'    => 'radio'
);

$tab_metb[] = array(
  'name' => '文本介绍',
  'id'   => '_post_txt',
  'desc' => '填写图集的描述文本！',
  'std'  => '',
  'size' => array(60,3),
  'type' => 'textarea'
);

$tab_metb[] = array(
  'name'    => '自动分页设置',
  'id'      => '_cx_post_auto_page',
  'desc'    => '设置自动分页规则，默认值再主题选项中设置！',
  'std'     => 'off',
  'subtype' => array(
    '0'  => '默认不分页',
    '1'  => '每页1张图片',
    '2' => '每页2张图片',
    '4' => '每页4张图片',
    '6' => '每页6张图片',
    '8' => '每页8张图片',
    '10' => '每页10张图片',
  ),
  'type' => 'select'
);

$tab_metb[] = array(
  'type' => 'close'
);

$tab_meta = apply_filters( 'single_options', $tab_metb);

$tab_meta[] = array(
  'name' => '附件下载',
  'id'   => 'seobox2',
  'type' => 'open'
);

$tab_meta[] = array(
  'name'    => '附件类型',
  'id'      => '_cx_post_down',
  'desc'    => '可设置为直接下载附件或者积分下载附件',
  'std'     => 'off',
  'subtype' => array(
    'off'  => '关闭',
    'jifen'  => '积分下载',
    'zhijie' => '直接下载',
  ),
  'type' => 'select'
);

$tab_meta[] = array(
  'name' => '附件Meta',
  'id'   => '_cx_post_down_meta',
  'desc' => '<b>填写格式：资源名称|资源参数</b><br /> 资源名称与资源参数|隔开。',
  'std'  => '',
  'size' => array(60,3),
  'type' => 'textarea'
);

$tab_meta[] = array(
  'name' => '附件资源',
  'id'   => '_cx_post_down_txt',
  'desc' => '<b>填写格式：资源url|下载密码|积分售价</b><br /> url请添加http://头，如提供百度网盘加密下载可以填写密码，也可以留空。',
  'std'  => '',
  'size' => array(60,3),
  'type' => 'textarea'
);
$tab_meta[] = array(
  'name' => '会员资源',
  'id'   => '_cx_post_down_huiyuan_txt',
  'desc' => '<b>填写格式：资源url|下载密码</b><br /> url请添加http://头，如提供百度网盘加密下载可以填写密码，也可以留空。如果没有会员资源可以留空！',
  'std'  => '',
  'size' => array(60,3),
  'type' => 'textarea'
);

$tab_meta[] = array(
  'type' => 'close'
);
$tab_box = new ashuwp_postmeta_feild($tab_meta, $tab_conf);

$ashu_feild = array();
$taxonomy_cof = array('category');

$ashu_feild[] = array(
  'name' => '封面图片',
  'id'   => '_feng_images',
  'desc' => '适用于分类封面显示。<style>.ashuwp_field_upload{width:300px!important;}</style>',
  'std'  => '',
  'button_text' => 'Upload',
  'type' => 'upload'
);

$ashu_feild[] = array(
  'name'      => '分类自定义title',
  'id'        => '_fl_title',
  'desc'      => '填写分类页面title标题一般在80个字符内',
  'std'       => '',
  'edit_only' => false,
  'size'      => 40,
  "type"      => "text"
);

$ashu_feild[] = array(
  'name'      => '分类自定义keywords',
  'id'        => '_fl_keywords',
  'desc'      => '填写分类页面keywords关键词一般在5个左右',
  'std'       => '',
  'edit_only' => false,
  'size'      => 40,
  "type"      => "text"
);

$ashu_feild[] = array(
  'type' => 'close'
);

$ashu_feild_hook = apply_filters( 'termmeta_options', $ashu_feild);

$ashuwp_termmeta_feild = new ashuwp_termmeta_feild($ashu_feild_hook, $taxonomy_cof);

/**
自定义幻灯片
**/
$slider_boxinfo = array('title' => '填写幻灯片信息', 'id'=>'sliderbox', 'page'=>array('slider_type'), 'context'=>'normal', 'priority'=>'low', 'callback'=>'');
$slider_metas[] = array(
  'name' => '幻灯片链接',
  'desc' => '以<code>http://</code>开头 例：http://www.chenxingweb.com',
  'id' => '_slider_link',
  'size'=> 40,
  'std'=>'',
  'type' => 'text'
);
$slider_metas[] = array(
  'name' => '幻灯片图片',
  'desc' => '上传一张幻灯片显示图像',
  'std'=>'',
  'size'=>60,
  'button_label'=>'Upload',
  'id' => '_slider_pic',
  'type' => 'upload'
);
$ashuwp_slider = new ashuwp_postmeta_feild($slider_metas, $slider_boxinfo);

/**
自定义专题
**/
$zhuanti_boxinfo = array('title' => '填写专题信息', 'id'=>'sliderbox', 'page'=>array('zhuanti_type'), 'context'=>'normal', 'priority'=>'low', 'callback'=>'');
$zhuanti_metas[] = array(
  'name' => '专题链接',
  'desc' => '以<code>http://</code>开头 例：http://www.chenxingweb.com',
  'id' => '_slider_link',
  'size'=> 40,
  'std'=>'',
  'type' => 'text'
);

$zhuanti_metas[] = array(
  'name'    => '关联项目',
  'id'      => '_zt_tags',
  'desc'    => '设置专题关联标签。',
  'std'     => '',
  'subtype' => 'post_tag',
  'type' => 'select'
);

$zhuanti_metas[] = array(
  'name' => '专题封面图片',
  'desc' => '上传一张专题封面显示图像',
  'std'=>'',
  'size'=>60,
  'button_label'=>'Upload',
  'id' => '_slider_pic',
  'type' => 'upload'
);
$zhuanti_slider = new ashuwp_postmeta_feild($zhuanti_metas, $zhuanti_boxinfo);

/**
标签页面自定义字段
**/
$tag_feild = array();
$taxonomy_cof = array('post_tag');

$tag_feild[] = array(
  'name' => '封面图片',
  'id'   => '_feng_images',
  'desc' => '适用于标签封面显示。',
  'std'  => '',
  'button_text' => 'Upload',
  'type' => 'upload'
);

$tag_feild[] = array(
  'name'      => '标签自定义title',
  'id'        => '_fl_title',
  'desc'      => '填写分类页面title标题一般在80个字符内',
  'std'       => '',
  'edit_only' => false,
  'size'      => 40,
  "type"      => "text"
);

$tag_feild[] = array(
  'name'      => '标签自定义keywords',
  'id'        => '_fl_keywords',
  'desc'      => '填写分类页面keywords关键词一般在5个左右',
  'std'       => '',
  'edit_only' => false,
  'size'      => 40,
  "type"      => "text"
);

$tag_feild[] = array(
  'type' => 'close'
);

$ashuwp_tag_feild = new ashuwp_termmeta_feild($tag_feild, $taxonomy_cof);




$child_info = array(
   'full_name' => '主题选项',
  'optionname'=>'general',
  'child'=>false,
  'filename' => 'generalpage'
);

$child_option = array();
$child_option[] = array('desc' => '', 'type' => 'open');

$child_option[] = array(
  'name' => '网站LOGO上传',
  'id'   => '_logo_images',
  'desc' => '用于网站前台logo图片显示',
  'std'  => '',
  'button_text' => 'Upload',
  'type' => 'upload'
);

$child_option[] = array(
  'name'    => '列表布局样式',
  'id'      => '_tags_themes',
  'desc'    => '设置站内列表缩略图尺寸。',
  'std'     => '1001',
  'subtype' => array(
    '1001'  => '4*3缩略图布局',
	'1002'  => '3*5缩略图布局',
  ),
  'type' => 'select'
);

$child_option[] = array(
  'name'    => '缩略图生成',
  'id'      => '_image_size_themes',
  'desc'    => 'WP缩略图占空间，加载快，timthumb缩略图动态裁切省空间加载稍慢。',
  'std'     => 'no',
  'subtype' => array(
    'off'  => 'WP缩略图',
    'yun' =>'云缩略图',
	  'no'  => 'timthumb',
  ),
  'type' => 'select'
);

$child_option[] = array(
  'name'    => '智能吸附导航',
  'id'      => '_cx_nav_slider',
  'desc'    => '启用该功能顶部导航菜单会在页面向上滚动和滚动到底部时自动显示！',
  'std'     => 'off',
  'subtype' => array(
    'off'  => '启用',
    'no' => '关闭',
  ),
  'type' => 'select'
);

$child_option[] = array(
  'name'    => '幻灯片功能',
  'id'      => '_cx_slider',
  'desc'    => '启用该项可在后台侧边显示一个自定义文章类型来【<a href="'.admin_url( 'edit.php?post_type=slider_type').'">发布幻灯片</a>】 ',
  'std'     => 'off',
  'subtype' => array(
    'off'  => '样式一',
    'off2' => '样式二',
    'no' => '隐藏',
  ),
  'type' => 'select'
);

$child_option[] = array(
  'name'    => '分类VS标签顶部样式',
  'id'      => '_cx_catag_demo',
  'desc'    => '选择分类和标签页面顶部展示样式！',
  'std'     => 'off',
  'subtype' => array(
    'off'  => '样式一',
    'no' => '样式二',
  ),
  'type' => 'select'
);

$child_option[] = array(
  'name'    => '首页列表排除分类',
  'id'      => '_index_list_cat',
  'desc'    => '勾选的分类将不在首页显示！',
  'std'  => array('0'),
  'subtype' => 'category',
  'type' => 'checkbox'
);

$child_option[] = array(
  'name' => '分类筛选数量',
  'id'   => '_cx_shaixuan',
  'desc' => '筛选项目最多出现多少个，为空则调用该分类下的全部标签。',
  'std'  => '30',
  'min'  => '10',
  'step' => '1',
  'size' => 40,
  'type' => 'number'
);

$child_option[] = array(
  'name'    => '底部站内统计',
  'id'      => '_cx_tongji',
  'desc'    => '启用该项将在网站底部显示站内数据统计',
  'std'     => 'off',
  'subtype' => array(
    'off'  => '显示',
    'no' => '隐藏',
  ),
  'type' => 'select'
);

$child_option[] = array(
  'name'    => '首页专题模块',
  'id'      => '_cx_zt_index',
  'desc'    => '是否显示首页专题模块在分页导航下面显示。',
  'std'     => 'no',
  'subtype' => array(
    'off'  => '显示',
    'no' => '隐藏',
  ),
  'type' => 'select'
);

$child_option[] = array(
  'name'    => '友情链接模块',
  'id'      => '_cx_linkst_index',
  'desc'    => '是否显示友情链接模块在首页底部位置。',
  'std'     => 'no',
  'subtype' => array(
    'off'  => '显示',
    'no' => '隐藏',
  ),
  'type' => 'select'
);

$child_option[] = array(
  'name' => '版权区域内容',
  'id'   => 'cx_banquan_text',
  'desc' => '显示在网站最底部！',
  'std'  => '该主题由 <a href="http://www.chenxingweb.com">晨星博客</a> 开发制作',
  'size' => array(60,5),
  'type' => 'textarea'
);

$child_option[] = array(
  'type' => 'close',
);

$child_page = new ashuwp_options_feild($child_option, $child_info);

//配置单图模式
$chen_dantuinfo = array(
  'full_name' => '单图模式',
  'full_desc' => '修改该页面选项保存参数之后需要再次刷新，修改别名需要重新保存固定链接才能生效！<br><span style="color: #e20adc;font-weight: 600;">前台栏目地址：</span><code>'.home_url('/').cn_options('_chen_dt_sulg','dantu','picture').'</code>需开启单图分享后才有效！',
  'optionname'=>'dantu',
  'child'=>true, 
  'parent_slug'=>'generalpage',
  'filename' => 'dantupage'
);
$dantu_option = array();
$dantu_option[] = array('desc' => '', 'type' => 'open');
$dantu_option[] = array(
  'name'    => '开启单图分享',
  'id'      => '_chen_dantu',
  'desc'    => '开启此项将在后台添加一个自定义文章类型【<a href="'.admin_url('edit.php?post_type=picture').'">单图分享</a>】！',
  'std'     => 'no',
  'subtype' => array(
    'off'  => '开启',
    'no' => '关闭',
  ),
  'type' => 'select'
);

$dantu_option[] = array(
  'name'    => '单图分享别名',
  'id'      => '_chen_dt_sulg',
  'desc'    => '填写单图分享栏目的url别名 样例：http://域名/别名。修改此项需要重新保存【<a href="'.admin_url('options-permalink.php').'">固定链接</a>】',
  'std'  => 'picture',
  'size' => 40,
  'type' => 'text'
);

$dantu_option[] = array(
  'name'    => 'SEO标题',
  'id'      => '_chen_dt_title',
  'desc'    => '填写单图分享分类栏目标题。',
  'std'  => '高清美女图片分享',
  'size' => 40,
  'type' => 'text'
);

$dantu_option[] = array(
  'name'    => 'SEO关键词',
  'id'      => '_chen_dt_ks',
  'desc'    => '填写单图分享分类栏目关键词，号分割。',
  'std'  => '美女图片,高清图片,图片分享',
  'size' => 40,
  'type' => 'text'
);

$dantu_option[] = array(
  'name'    => 'SEO描述',
  'id'      => '_chen_dt_des',
  'desc'    => '填写单图分享分类栏目描述文本。',
  'std'  => '高清美女图片分享频道',
  'size' => array(60,5),
  'type' => 'textarea'
);

$dantu_option[] = array('desc' => '', 'type' => 'close');
$dantu_page = new ashuwp_options_feild($dantu_option, $chen_dantuinfo);

//配置会员功能
$chen_vipinfo = array(
  'full_name' => '会员设置',
  'optionname'=>'general',
  'child'=>true, 
  'parent_slug'=>'generalpage',
  'filename' => 'vippage'
);
$vip_option = array();
$vip_option[] = array('desc' => '', 'type' => 'open');

//会员设置
$vip_option[] = array(
  'name' => '会员设置',
  'id'   => 'option_tab1',
  'type' => 'open',
);

$vip_option[] = array(
  'name'    => '会员不显示广告',
  'id'      => 'cx_fujia_vip_ad',
  'desc'    => '启用此项如果用户是vip会员那么会去掉所有广告的显示！',
  'std'     => 'no',
  'subtype' => array(
    'off'  => '开启',
    'no' => '关闭',
  ),
  'type' => 'select'
);

$vip_option[] = array(
  'name'    => '允许用户投稿分类ID',
  'id'      => '_tougao_post_user',
  'desc'    => '填写允许用户通过前端投稿的分类ID。',
  'std'  => array('0'),
  'subtype' => 'category',
  'type' => 'checkbox'
);

$vip_option[] = array(
  'name'    => '是否允许投稿者上传图片',
  'id'      => 'Chen_contributor_uploads',
  'desc'    => '启用此项会修改会员等级的权限，',
  'std'     => '2',
  'subtype' => array(
    '1'  => '允许',
    '2' => '不允许',
  ),
  'type' => 'select'
);

$vip_option[] = array('desc' => '', 'type' => 'close');
//会员价格
$vip_option[] = array(
  'name' => '会员价格',
  'id'   => 'option_tab2',
  'type' => 'open',
);
$vip_option[] = array(
  'name' => '普通会员价格',
  'id'   => 'CX_VIP_MONTHLY_PRICE',
  'desc' => '开通月费会员需要的积分数量！',
  'std'  => '100',
  'min'  => '1',
  'step' => '1',
  'size' => 40,
  'type' => 'number'
);

$vip_option[] = array(
  'name' => '白金会员价格',
  'id'   => 'CX_VIP_QUARTERLY_PRICE',
  'desc' => '开通季费会员需要的积分数量！',
  'std'  => '280',
  'min'  => '1',
  'step' => '1',
  'size' => 40,
  'type' => 'number'
);

$vip_option[] = array(
  'name' => '钻石会员价格',
  'id'   => 'CX_VIP_ANNUAL_PRICE',
  'desc' => '开通年费会员需要的积分数量！',
  'std'  => '800',
  'min'  => '1',
  'step' => '1',
  'size' => 40,
  'type' => 'number'
);

$vip_option[] = array('desc' => '', 'type' => 'close');

//会员特权
$vip_option[] = array(
  'name' => '会员特权',
  'id'   => 'option_tab3',
  'type' => 'open',
);
$vip_option[] = array(
  'name' => '普通会员折扣',
  'id'   => 'CX_VIP_ZK_1',
  'desc' => '普通会员可享折扣！',
  'std'  => '0.9',
  'min'  => '0.1',
  'step' => '0.1',
  'size' => 40,
  'type' => 'number'
);

$vip_option[] = array(
  'name' => '白金会员折扣',
  'id'   => 'CX_VIP_ZK_2',
  'desc' => '白金会员可享折扣！',
  'std'  => '0.8',
  'min'  => '0.1',
  'step' => '0.1',
  'size' => 40,
  'type' => 'number'
);

$vip_option[] = array(
  'name' => '钻石会员折扣',
  'id'   => 'CX_VIP_ZK_3',
  'desc' => '钻石会员可享折扣！',
  'std'  => '0.7',
  'min'  => '0.1',
  'step' => '0.1',
  'size' => 40,
  'type' => 'number'
);

$vip_option[] = array(
  'name' => '普通会员以上可阅读分类',
  'id'   => 'CX_VIP_QX_MONTHLY_PRICE',
  'desc' => '需要用户是普通会员以上身份时才可以查看该分类的文章!',
  'std'  => array('0'),
  'subtype' => 'category',
  'type' => 'checkbox'
);

$vip_option[] = array(
  'name' => '白金会员以上可阅读分类',
  'id'   => 'CX_VIP_QX_QUARTERLY_PRICE',
  'desc' => '需要用户是白金会员以上身份时才可以查看该分类的文章！',
  'std'  => array('0'),
  'subtype' => 'category',
  'type' => 'checkbox'
);

$vip_option[] = array(
  'name' => '钻石会员以上可阅读分类',
  'id'   => 'CX_VIP_QX_ANNUAL_PRICE',
  'desc' => '需要用户是钻石会员以上身份时才可以查看该分类的文章！',
  'std'  => array('0'),
  'subtype' => 'category',
  'type' => 'checkbox'
);
$vip_option[] = array(
  'name' => '普通会员下载上限/天',
  'id'   => '_VIP_DOEWN_1',
  'desc' => '填写数字，当用户达到下载上限是当日不可再下载新内容，24小时后自动解除限制！',
  'std'  => '5',
  'min'  => '1',
  'step' => '1',
  'size' => 40,
  'type' => 'number'
);

$vip_option[] = array(
  'name' => '白金会员下载上限/天',
  'id'   => '_VIP_DOEWN_2',
  'desc' => '填写数字，当用户达到下载上限是当日不可再下载新内容，24小时后自动解除限制！',
  'std'  => '10',
  'min'  => '1',
  'step' => '1',
  'size' => 40,
  'type' => 'number'
);

$vip_option[] = array(
  'name' => '钻石会员下载上限/天',
  'id'   => '_VIP_DOEWN_3',
  'desc' => '填写数字，当用户达到下载上限是当日不可再下载新内容，24小时后自动解除限制！',
  'std'  => '15',
  'min'  => '1',
  'step' => '1',
  'size' => 40,
  'type' => 'number'
);
$vip_option[] = array('desc' => '', 'type' => 'close');
//积分奖励
$vip_option[] = array(
  'name' => '积分奖励',
  'id'   => 'option_tab4',
  'type' => 'open',
);
$vip_option[] = array(
  'name' => '签到奖励积分数',
  'id'   => 'CX_DAILY_SIGN_CREDITS',
  'desc' => '每日签到奖励积分数量！',
  'std'  => '10',
  'min'  => '0',
  'step' => '1',
  'size' => 40,
  'type' => 'number'
);

$vip_option[] = array(
  'name' => '评论奖励积分数',
  'id'   => 'CX_COMMENT_CREDIT',
  'desc' => '评论文章奖励积分数量！',
  'std'  => '5',
  'min'  => '1',
  'step' => '1',
  'size' => 40,
  'type' => 'number'
);

$vip_option[] = array(
  'name' => '评论奖励积分次数',
  'id'   => 'CX_COMMENT_NUM',
  'desc' => '评论文章每日奖励积分的次数！',
  'std'  => '3',
  'min'  => '1',
  'step' => '1',
  'size' => 40,
  'type' => 'number'
);

$vip_option[] = array(
  'name' => '注册奖励积分数',
  'id'   => 'CX_ZHUCE_SIGN_CREDITS',
  'desc' => '注册站内会员奖励积分的数量！',
  'std'  => '20',
  'min'  => '1',
  'step' => '1',
  'size' => 40,
  'type' => 'number'
);

$vip_option[] = array(
  'name' => '投稿奖励积分数',
  'id'   => 'CX_TOUGAO_NUTHER_CREDITS',
  'desc' => '投稿一篇文章并审核通过奖励积分数量！',
  'std'  => '10',
  'min'  => '1',
  'step' => '1',
  'size' => 40,
  'type' => 'number'
);
$vip_option[] = array(
  'name' => '每日投稿奖励次数',
  'id'   => 'CX_TOUGAO_NUTHER_CISHU',
  'desc' => '每日投稿奖励最多多少次！',
  'std'  => '3',
  'min'  => '1',
  'step' => '1',
  'size' => 40,
  'type' => 'number'
);


$vip_option[] = array('desc' => '', 'type' => 'close');
$seo_page = new ashuwp_options_feild($vip_option, $chen_vipinfo);

//配置广告功能
$chen_adinfo = array(
  'full_name' => '广告设置',
  'optionname'=>'advert',
  'child'=>true, 
  'parent_slug'=>'generalpage',
  'filename' => 'adpage'
);
$ad_option = array();
$ad_option[] = array('desc' => '', 'type' => 'open');

$ad_option[] = array(
  'name'    => '列表通栏广告',
  'id'      => 'cx_ad_index',
  'desc'    => '显示在首页页码上方！',
  'std'     => 'off',
  'subtype' => array(
    'off'  => '开启',
    'no' => '关闭',
  ),
  'type' => 'select'
);

$ad_option[] = array(
  'name' => '列表通栏广告代码',
  'id'   => 'ad_index',
  'desc' => '显示在列表页码上方！',
  'std'  => '<a href="#"><img src="'.CX_AD_URL.'and_demo_1160.png" width="1160" height="150"></a>',
  'size' => array(60,5),
  'type' => 'textarea'
);

$ad_option[] = array(
  'name' => '列表页广告代码',
  'id'   => 'ad_index_m',
  'desc' => '显示在列表页码上方！<style> .m_ad{color: #2196F3;font-size: 1.5em;}</style> <span class="m_ad">(移动端)</span>',
  'std'  => '<a href="#"><img src="'.CX_AD_URL.'and_demo_m.png" width="100%" height="auto"></a>',
  'size' => array(60,5),
  'type' => 'textarea'
);

$ad_option[] = array(
  'name'    => '文章内容顶部广告',
  'id'      => 'cx_ad_single',
  'desc'    => '显示在文章内容顶部广告代码，支持广告联盟和图片广告！',
  'std'     => 'off',
  'subtype' => array(
    'off'  => '开启',
    'no' => '关闭',
  ),
  'type' => 'select'
);

$ad_option[] = array(
  'name' => '单栏文章页广告',
  'id'   => 'ad_single',
  'desc' => '显示在单栏模式的文章内容上方建议大小：1180*120（满宽显示）！',
  'std'  => '<a href="#"><img src="'.CX_AD_URL.'and_demo_1160.png" width="1160" height="150"></a>',
  'size' => array(60,5),
  'type' => 'textarea'
);

$ad_option[] = array(
  'name' => '带侧栏文章页广告',
  'id'   => 'ad_single_002',
  'desc' => '显示在带侧边栏模式的文章内容上方！',
  'std'  => '<a href="#"><img src="'.CX_AD_URL.'and_demo_860.png" width="860" height="110"></a>',
  'size' => array(60,5),
  'type' => 'textarea'
);

$ad_option[] = array(
  'name' => '文章页广告',
  'id'   => 'ad_single_m',
  'desc' => '显示在移动端内容上方！<span class="m_ad">(移动端)</span>',
  'std'  => '<a href="#"><img src="'.CX_AD_URL.'and_demo_m.png" width="100%" height="auto"></a>',
  'size' => array(60,5),
  'type' => 'textarea'
);

$ad_option[] = array(
  'name'    => '登陆/注册广告',
  'id'      => 'cx_ad_login',
  'desc'    => '显示在登陆/注册/找回密码右侧！',
  'std'     => 'off',
  'subtype' => array(
    'off'  => '开启',
    'no' => '关闭',
  ),
  'type' => 'select'
);

$ad_option[] = array(
  'name' => '登陆广告代码',
  'id'   => 'ad_login',
  'desc' => '显示在登陆/注册/找回密码右侧！',
  'std'  => '<a href="#"><img src="'.CX_AD_URL.'and_demo_420.png" width="420" height="520"></a>',
  'size' => array(60,5),
  'type' => 'textarea'
);

$ad_option[] = array(
  'name'    => '全页面浮动广告',
  'id'      => 'cx_ad_tongyong',
  'desc'    => '可以放置对联广告，右下角弹窗，js代码等！',
  'std'     => 'no',
  'subtype' => array(
    'off'  => '开启',
    'no' => '关闭',
  ),
  'type' => 'select'
);

$ad_option[] = array(
  'name' => '全页面浮动广告代码',
  'id'   => 'ad_tongyong',
  'desc' => '可以放置对联广告，右下角弹窗，js代码等！',
  'std'  => '',
  'size' => array(60,5),
  'type' => 'textarea'
);

$ad_option[] = array(
  'name' => '全页面浮动广告代码',
  'id'   => 'ad_tongyong_m',
  'desc' => '可以放置悬浮广告等！<span class="m_ad">(移动端)</span>',
  'std'  => '',
  'size' => array(60,5),
  'type' => 'textarea'
);

$ad_option[] = array('desc' => '', 'type' => 'close');
$seo_page = new ashuwp_options_feild($ad_option, $chen_adinfo);

//配置SEO功能
$chen_seoinfo = array(
  'full_name' => 'SEO设置',
  'optionname'=>'cxseo',
  'child'=>true, 
  'parent_slug'=>'generalpage',
  'filename' => 'seopage'
);
$seo_option = array();
$seo_option[] = array('desc' => '', 'type' => 'open');
$seo_option[] = array(
  'name' => '网站统计代码',
  'id'   => '_wz_baidu',
  'desc' => '请在网站统计平台获取代码后放置到这里。适合百度统计',
  'size' => array(60,5),
  'type' => 'textarea'
);

$seo_option[] = array(
  'name' => '首页标题title',
  'id'   => '_seo_title',
  'desc' => '一般在80个字符内，显示在首页title标题中',
  'std'  => '例：首页的标题在后台主题选项SEO设置中修改',
  'size' => 40,
  'type' => 'text'
);

$seo_option[] = array(
  'name' => '首页关键词keywords',
  'id'   => '_seo_keywords',
  'desc' => '多个关键词请用英文逗号分隔',
  'std'  => '例：WordPress,WP建站',
  'size' => 40,
  'type' => 'text'
);

$seo_option[] = array(
  'name' => '首页描述description',
  'id'   => '_seo_description',
  'desc' => '输入首页描述文本，一般在200字以内。。。',
  'std'  => '例：感谢使用CX-UDY主题，在使用过程中遇到问题请提交工单或者联系客服QQ提交问题。',
  'size' => array(60,5),
  'type' => 'textarea'
);

$seo_option[] = array(
  'name' => 'ICP备案号',
  'id'   => '_foot_ba',
  'desc' => '',
  'std'  => '例：沪ICP备88888888号',
  'size' => 40,
  'type' => 'text'
);
$seo_option[] = array(
  'name'    => '备案号码链接',
  'id'      => '_foot_ba_url',
  'desc'    => '在办理备案手续时可以在这里快速设置是否加工信部的链接，链接已设置了新窗口打开和nofollow属性',
  'std'     => 'no',
  'subtype' => array(
    'off'  => '显示',
    'no' => '隐藏',
  ),
  'type' => 'select'
);

$seo_option[] = array('desc' => '', 'type' => 'close');
$seo_page = new ashuwp_options_feild($seo_option, $chen_seoinfo);

//配置高级功能
$chen_fujiainfo = array(
  'full_name' => '附加功能',
  'optionname'=>'general',
  'child'=>true, 
  'parent_slug'=>'generalpage',
  'filename' => 'fujiapage'
);
$fujia_option = array();
$fujia_option[] = array('desc' => '', 'type' => 'open');
$fujia_option[] = array(
  'name'    => '站内用相对链接',
  'id'      => 'cx_fujia_xiangdui',
  'desc'    => '相对链接比绝对链接更适合优化 <a href="http://www.chenxingweb.com/xiangduilinks-fenxi-jianyi.html">点击查看如何选择</a>！',
  'std'     => 'no',
  'subtype' => array(
    'off'  => '开启',
    'no' => '关闭',
  ),
  'type' => 'select'
);

$fujia_option[] = array(
  'name'    => '链接后面加斜杠',
  'id'      => 'cx_fujia_xiegang',
  'desc'    => '在分类和标签的链接后面添加斜杠！',
  'std'     => 'no',
  'subtype' => array(
    'off'  => '开启',
    'no' => '关闭',
  ),
  'type' => 'select'
);

$fujia_option[] = array(
  'name'    => 'TAG页添加html后缀',
  'id'      => 'cx_fujia_taghtml',
  'desc'    => '给tag页的链接添加.html后缀！',
  'std'     => 'no',
  'subtype' => array(
    'off'  => '开启',
    'no' => '关闭',
  ),
  'type' => 'select'
);

$fujia_option[] = array(
  'name'    => '分类URL添加.html后缀',
  'id'      => 'cx_fujia_cathtml',
  'desc'    => '给分类URL添加.html后缀,配合分页URL处理效果最佳！',
  'std'     => 'no',
  'subtype' => array(
    'off'  => '开启',
    'no' => '关闭',
  ),
  'type' => 'select'
);

$fujia_option[] = array(
  'name'    => '分页URL处理',
  'id'      => 'cx_fujia_pagehtml',
  'desc'    => '优化首页，分类页，标签页的分页显示格式为page_2.html的形式！',
  'std'     => 'no',
  'subtype' => array(
    'off'  => '开启',
    'no' => '关闭',
  ),
  'type' => 'select'
);

$fujia_option[] = array(
  'name'    => '普通用户禁用鼠标右键',
  'id'      => 'cx_fujia_mouse',
  'desc'    => '开启此项普通用户不可以使用鼠标右键，VIP会员可以正常使用！',
  'std'     => 'off',
  'subtype' => array(
    'off'  => '开启',
    'no' => '关闭',
  ),
  'type' => 'select'
);

$fujia_option[] = array(
  'name'    => '文章列表角标显示',
  'id'      => 'cx_fujia_jiaobiao',
  'desc'    => '关于此项介绍请到http://www.chenxingweb.com 查看！',
  'std'     => 'no',
  'subtype' => array(
    '1'  => '专区角标',
    '2'  => '文章角标',
    'no' => '关闭',
  ),
  'type' => 'select'
);



$fujia_option[] = array(
  'name'    => '文章浏览数量作弊',
  'id'      => 'cx_fujia_views',
  'desc'    => '启用此项在发布文章时会给浏览量定义一个500~2000的随机数！',
  'std'     => 'no',
  'subtype' => array(
    'off'  => '开启',
    'no' => '关闭',
  ),
  'type' => 'select'
);

$fujia_option[] = array(
  'name'    => '文章点赞数量作弊',
  'id'      => 'cx_fujia__ding',
  'desc'    => '启用此项在发布文章时会给点赞数量定义一个5~20的随机数',
  'std'     => 'no',
  'subtype' => array(
    'off'  => '开启',
    'no' => '关闭',
  ),
  'type' => 'select'
);

$fujia_option[] = array('desc' => '', 'type' => 'close');
$seo_page = new ashuwp_options_feild($fujia_option, $chen_fujiainfo);

//配置优化功能
$login_youhuainfo = array(
  'full_name' => '第三方登录',
  'full_desc' => '配置QQ登录和新浪微博登录！',
  'optionname'=>'general',
  'child'=>true, 
  'parent_slug'=>'generalpage',
  'filename' => 'loginpage'
);
$login_option = array();
$login_option[] = array('desc' => '', 'type' => 'open');
$login_option[] = array(
  'name'    => 'QQ登陆开关',
  'id'      => 'cx_login_qq',
  'desc'    => '是否启用QQ登陆功能！使用该功能需要到腾讯开放平台申请接口才能使用！',
  'std'     => 'no',
  'subtype' => array(
    'off'  => '开启',
    'no' => '关闭',
  ),
  'type' => 'select'
);

$login_option[] = array(
  'name' => 'QQ登陆ID',
  'id'   => 'cx_login_qq_id',
  'desc' => 'QQ登陆ID值，该id来源于腾讯开放平台！',
  'std'  => '',
  'size' => 40,
  'type' => 'text'
);

$login_option[] = array(
  'name' => 'QQ登陆KEY',
  'id'   => 'cx_login_qq_key',
  'desc' => 'QQ登陆key值，该id来源于腾讯开放平台！',
  'std'  => '',
  'size' => 40,
  'type' => 'text'
);

$login_option[] = array(
  'name'    => '新浪微博登陆开关',
  'id'      => 'cx_login_weibo',
  'desc'    => '是否启用新浪微博登陆功能！使用该功能需要到新浪开放平台申请接口才能使用！',
  'std'     => 'no',
  'subtype' => array(
    'off'  => '开启',
    'no' => '关闭',
  ),
  'type' => 'select'
);

$login_option[] = array(
  'name' => '新浪微博登陆ID',
  'id'   => 'cx_login_weibo_id',
  'desc' => '新浪微博登陆ID值，该id来源于新浪开放平台！',
  'std'  => '',
  'size' => 40,
  'type' => 'text'
);

$login_option[] = array(
  'name' => '新浪微博登陆KEY',
  'id'   => 'cx_login_weibo_key',
  'desc' => '新浪微博登陆key值，该id来源于新浪开放平台！',
  'std'  => '',
  'size' => 40,
  'type' => 'text'
);

$login_option[] = array('desc' => '', 'type' => 'close');
$seo_page = new ashuwp_options_feild($login_option, $login_youhuainfo);

//配置优化功能
$smtp_youhuainfo = array(
  'full_name' => 'SMTP配置',
  'full_desc' => '配置SMTP邮件发送相关配置项！',
  'optionname'=>'general',
  'child'=>true, 
  'parent_slug'=>'generalpage',
  'filename' => 'smtppage'
);
$smtp_option = array();
$smtp_option[] = array('desc' => '', 'type' => 'open');
$smtp_option[] = array(
  'name'    => 'SMTP发信开关',
  'id'      => 'smtp_switch',
  'desc'    => '使用SMTP替代默认PHP mail()函数发信',
  'std'     => 'no',
  'subtype' => array(
    'off'  => '开启',
    'no' => '关闭',
  ),
  'type' => 'select'
);

$smtp_option[] = array(
  'name' => 'SMTP发信服务器',
  'id'   => 'smtp_host',
  'desc' => 'SMTP发信服务器，例如smtp.163.com',
  'std'  => '',
  'size' => 40,
  'type' => 'text'
);

$smtp_option[] = array(
  'name' => 'MTP发信服务器端口',
  'id'   => 'smtp_port',
  'desc' => 'SMTP发信服务器端口，不开启SSL时一般默认25，开启SSL一般为465',
  'std'  => '465',
  'size' => 40,
  'type' => 'text'
);

$smtp_option[] = array(
  'name'    => 'SMTP服务器SSL',
  'id'      => 'smtp_ssl',
  'desc'    => 'SMTP发信服务器SSL连接，请相应修改端口',
  'std'     => 'off',
  'subtype' => array(
    'off'  => '开启',
    'no' => '关闭',
  ),
  'type' => 'select'
);

$smtp_option[] = array(
  'name' => 'SMTP发信用户名',
  'id'   => 'smtp_user',
  'desc' => 'SMTP发信用户名，一般为完整邮箱号',
  'std'  => get_bloginfo ('admin_email'),
  'size' => 40,
  'type' => 'text'
);

$smtp_option[] = array(
  'name' => 'SMTP帐号密码',
  'id'   => 'smtp_pass',
  'desc' => 'SMTP帐号的密码，密码错误会导致无法发送邮件！请填写前测试下账号是否正确！',
  'std'  => '',
  'size' => 40,
  'type' => 'password'
);

$smtp_option[] = array(
  'name' => '发信人昵称',
  'id'   => 'smtp_name',
  'desc' => 'SMTP发信人昵称，在邮件中显示！',
  'std'  => get_bloginfo('name'),
  'size' => 40,
  'type' => 'text'
);

$smtp_option[] = array(
  'name'    => '用户登录通知',
  'id'      => 'login_mail_msg',
  'desc'    => '如果有用户登录本站，无论成功还是失败都会给站长发送一封通知邮件！',
  'std'     => 'no',
  'subtype' => array(
    'off'  => '开启',
    'no' => '关闭',
  ),
  'type' => 'select'
);

$smtp_option[] = array('desc' => '', 'type' => 'close');
$seo_page = new ashuwp_options_feild($smtp_option, $smtp_youhuainfo);

//配置优化功能
$post_pageinfo = array(
  'full_name' => '自动分页设置',
  'full_desc' => '配置自动分页处理规则！',
  'optionname'=>'general',
  'child'=>true, 
  'parent_slug'=>'generalpage',
  'filename' => 'autopage'
);
$pagpo_option = array();
$pagpo_option[] = array('desc' => '', 'type' => 'open');

$pagpo_option[] = array(
  'name'    => '图片自动分页',
  'id'      => 'cx_fujia_imgpage',
  'desc'    => '图片超过'.CX_AUTO_POST.'张将自动添加分页符！',
  'std'     => 'no',
  'subtype' => array(
    'off'  => '开启',
    'no' => '关闭',
  ),
  'type' => 'select'
);

$pagpo_option[] = array(
  'name'    => '自动分页处理范围',
  'id'      => 'cx_auto_page',
  'desc'    => '设置自动分页的应用范围！',
  'std'     => 'no',
  'subtype' => array(
    'no'  => '仅处理图片文章',
    'off' => '全部处理',
  ),
  'type' => 'select'
);

$pagpo_option[] = array(
  'name'    => '自动分页控制',
  'id'      => 'cx_auto_page_num',
  'desc'    => '设置多少张图片划分为一页！',
  'std'  => '1',
  'subtype' => array(
    '0'  => '默认不分页',
    '1'  => '每页1张图片',
    '2' => '每页2张图片',
    '4'  => '每页4张图片',
    '6' => '每页6张图片',
    '8'  => '每页8张图片',
    '10' => '每页10张图片',
  ),
  'type' => 'select'
);

$pagpo_option[] = array('desc' => '', 'type' => 'close');
$pagpo_page = new ashuwp_options_feild($pagpo_option, $post_pageinfo);


//配置优化功能
$demo_youhuainfo = array(
  'full_name' => '代码自定义',
  'full_desc' => '用户自定义js和css样式文件！',
  'optionname'=>'diy_code',
  'child'=>true, 
  'parent_slug'=>'generalpage',
  'filename' => 'demopage'
);
$demo_option = array();
$demo_option[] = array('desc' => '', 'type' => 'open');

$demo_option[] = array(
  'name' => '自定义css样式',
  'id'   => '_chen_css',
  'desc' => '添加用户自定义css样式代码，无需添加<code>&lt;style&gt;</code>标签！自动加载到头部',
  'std'  => '',
  'size' => array(60,5),
  'type' => 'textarea'
);

$demo_option[] = array(
  'name' => '自定义js脚本',
  'id'   => '_chen_js',
  'desc' => '添加用户自定义js脚本代码，需添加<code>&lt;script&gt;</code>标签！自动加载到底部',
  'std'  => '',
  'size' => array(60,5),
  'type' => 'textarea'
);

$demo_option[] = array('desc' => '', 'type' => 'close');
$seo_page = new ashuwp_options_feild($demo_option, $demo_youhuainfo);

//配置优化功能
$alipay_youhuainfo = array(
  'full_name' => '支付功能',
  'full_desc' => '配置在线支付功能相关参数',
  'optionname'=>'alipay_code',
  'child'=>true, 
  'parent_slug'=>'generalpage',
  'filename' => 'alipaypage'
);
$alipay_option = array();
$alipay_option[] = array('desc' => '', 'type' => 'open');

$alipay_option[] = array(
  'name'    => '在线支付方式',
  'id'      => 'alipay_jiekou',
  'desc'    => '如果有官方接口建议使用官方接口，如果没有可以使用晨星博客的平台进行中转！(免签约平台暂不可用)',
  'std'     => 'alipay',
  'subtype' => array(
    'alipay'  => '官方即时到帐接口',
    'cxpay' => '免签约平台（晨星亲营）',
  ),
  'type' => 'select'
);

$alipay_option[] = array(
  'name'    => '身份PID',
  'id'      => 'alipay_pid',
  'desc'    => '合作者身份编号16位数字组成！',
  'std'     => '',
  'type' => 'text'
);

$alipay_option[] = array(
  'name'    => '校验MD5',
  'id'      => 'alipay_md5',
  'desc'    => '合作者身份MD5校验值32位字符串组成！',
  'std'     => '',
  'type' => 'text'
);

$alipay_option[] = array(
  'name'    => '积分换算比例',
  'id'      => 'alipay_create_int',
  'desc'    => '设置积分换算比例，1元=多少积分！',
  'std'     => '10',
  'type' => 'text'
);

$alipay_option[] = array(
  'name'    => '充值卡获取地址URL',
  'id'      => 'alipay_create_dk_url',
  'desc'    => '设置充值卡的获取页面地址，可以是淘宝店铺、第三方发卡平台以及独立的充值卡购买页面！',
  'std'     => 'http://',
  'type' => 'text'
);



$alipay_option[] = array('desc' => '', 'type' => 'close');
$seo_page = new ashuwp_options_feild($alipay_option, $alipay_youhuainfo);

//主题扩展
$extend_info = array(
  'full_name' => '主题扩展',
  'full_desc' => '
  如果您定制或者使用了该主题的扩展类代码，相关设置项会出现在这里！
  <div class="extend_themes">
  <p>请上传zip格式的主题专用扩展安装包！非WP插件</p>
  <form method="post" enctype="multipart/form-data" class="wp-upload-form" id="extend_themes" action="'.get_stylesheet_directory_uri().'/inc/functions/config/extemes.php">
  <label class="screen-reader-text" for="extendzip">主题压缩文件</label>
  <input type="file" id="extendzip" accept="aplication/zip" name="extendzip">
  <input type="hidden" name="http_referer" value="'.get_option('siteurl').'/wp-admin/admin.php?page=extendpage">
  <input type="submit" name="install-theme-submit" id="install-theme-submit" class="button" value="现在安装" disabled="">
  </form>
  </div>
  ',
  'optionname'=>'extend',
  'child'=>false,
  'icon'=>'dashicons-admin-plugins',
  'filename' => 'extendpage'
);
$extend_option = array();
$extend_option[] = array('type' => 'open');
$extend_option[] = array('name' => '<b style="color: #f00;font-size: 1.5em;margin: 20px 0;height: 150px;line-height: 150px;">您还没有配置任何扩展！</b>','type' => 'close');
$themes_options_hook = apply_filters( 'themes_options', $extend_option);
$extend = new ashuwp_options_feild($themes_options_hook, $extend_info);

//配置优化功能
$extendsinfo = array(
  'full_name' => '<span id="nav_hrefc" data-href="http://chenxingweb.com/extend/">扩展列表</span>',
  'full_desc' => '',
  'optionname'=>'extends',
  'child'=>true, 
  'parent_slug'=>'extendpage',
  'filename' => 'extpage_chenxingweb'
);
$extends = array();
$seo_page = new ashuwp_options_feild($extends, $extendsinfo);
