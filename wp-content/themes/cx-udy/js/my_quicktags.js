QTags.addButton( 'abc', 'abc', '<!--abc-->', "" );//标记
QTags.addButton( 'zyy', '引用',  "<blockquote>", "</blockquote>\n" );//添加引用
QTags.addButton( 'hr', '横线', "<hr />\n" );//添加横线
QTags.addButton( 'h2', 'H2标签', "<h2>", "</h2>\n" ); //添加标题2
QTags.addButton( 'h3', 'H3标签', "<h3>", "</h3>\n" ); //添加标题3
QTags.addButton( 'video', 'HTML5视频', "[cx_video]", "[/cx_video]" );
QTags.addButton( 'embed', 'Flash视频', "[cx_embed]", "[/cx_embed]" );
QTags.addButton( 'nextpage', '分页按钮', '<!--nextpage-->', "" );
QTags.addButton( 'vip', 'VIP资源分割', '<!--vip-->', "" );
//这儿共有四对引号，分别是按钮的ID、显示名、点一下输入内容、再点一下关闭内容（此为空则一次输入全部内容），\n表示换行。�值越大要求的等级越高,短代码不可跨分页使用-->\n</p>\n[vip-hide type='1']此处填写需要隐藏的内容[/vip-hide]", "" );
QTags.addButton( 'demo', '演示VS下载按钮', "<p style='display: none;'>\n<!-- 短代码属性介绍：demo_url:填写演示网页的URL、demo_name:填写演示按钮的名称、down_off:值为1时显示下载按钮，值为0时不显示下载按钮、down_name:下载按钮名称-->\n</p>\n[cx-demo demo_url='演示URL' demo_name='效果演示' down_off='1' down_name='下载资源']介绍文本[/cx-demo]", "" );
//这儿共有四对引号，分别是按钮的ID、显示名、点一下输入内容、再点一下关闭内容（此为空则一次输入全部内容），\n表示换行。
