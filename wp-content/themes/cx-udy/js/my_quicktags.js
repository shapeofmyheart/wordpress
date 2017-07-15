QTags.addButton( 'abc', 'abc', '<!--abc-->', "" );//标记
QTags.addButton( 'zyy', '引用',  "<blockquote>", "</blockquote>\n" );//添加引用
QTags.addButton( 'hr', '横线', "<hr />\n" );//添加横线
QTags.addButton( 'h2', 'H2标签', "<h2>", "</h2>\n" ); //添加标题2
QTags.addButton( 'h3', 'H3标签', "<h3>", "</h3>\n" ); //添加标题3
QTags.addButton( 'video', 'HTML5视频', "[cx_video]", "[/cx_video]" );
QTags.addButton( 'embed', 'Flash视频', "[cx_embed]", "[/cx_embed]" );
QTags.addButton( 'nextpage', '分页按钮', '<!--nextpage-->', "" );
QTags.addButton( 'vip', 'VIP资源分割', '<!--vip-->', "" );
//这儿共有四对引号，分别是按钮的ID、显示名、点一下输入内容、再点一下关闭内容（此为空则一次输入全部内容），\n表示换行。