<?php
/**
* 首页布局类
*/

class Index_Option{

	/** 创建构造函数 **/
	function __construct(){
		$this->option = get_option('ashu_general');
		add_action( 'index_options', array($this, 'index_hdp'),3);

		//加载首页列表样式
		add_action( 'index_options', array($this, 'index_list_demo'),10);		

		//专题模块挂载
		if(!empty($this->option['_cx_zt_index']) &&
		 $this->option['_cx_zt_index'] == 'off'){
			add_action( 'index_options', array($this,'index_zt'),15);
		}
		//友情链接模块
		if(!empty($this->option['_cx_linkst_index']) &&
		 $this->option['_cx_linkst_index'] == 'off'){
			add_action( 'index_options', array($this,'index_link'),20);
		}

		/** 加载分类相关模块 */
		add_action( 'cat_chen_archive', array($this, 'cat_top'),10,1);
		add_action( 'cat_chen_archive', array($this, 'cat_archive'),15,1);

		/** 加载标签页面模块 */
		add_action( 'tag_chen_archive', array($this, 'tag_top'),10,1);
		add_action( 'tag_chen_archive', array($this, 'cat_archive'),15,1);
		
		/** 文章页相关文章 */
		add_action('post_meta_db', array($this,'cx_xg_post'));
	}

	public function cx_xg_post(){
		cx_xg_post();
	}

	/** 加载分类顶部模块 **/
	public function cat_top($cat){
		if($this->option['_cx_catag_demo'] !='no'){
			/** 获取分类id结束 */
			$cat_id = get_category_link($cat);
			if(!isset($_GET['ctag'])){
				$tag_cla = ' linked';
				$cxtag = null;
				$cxtag_get = null;
			}else{
				$cxtag = cxss_clean($_GET['ctag']);
				$cxtag_get = '&ctag='.$cxtag;
				$tag_cla = null;
			}
			cat_meta_information();?>
		    <div class="fl_title">
		    	<div class="fl01"> <?php single_cat_title(); ?></div>
		    	<?php do_action('cat_fl_title');?>
		    </div>
		    <div class="filter-wrap">
		    	<div class="filter-tag">
					<div class="fl_list"><span> 标签：</span>
					<?php cx_ctag_post($cat, $cat_id ,$tag_cla ,$cxtag);?>
					</div>        
			        <div class="fl_list" style="margin-top:10px;"><span> 排序：</span>
			            <?php cat_get_sort($cxtag_get, $cat_id);?> 
			        </div>      
		    	</div>      
		    </div>
		    </div>
		<?php
		}else{
			$img = (get_term_meta($cat, '_feng_images',true))?get_term_meta($cat, '_feng_images',true):'';
			echo '<div class="cat_demo2_UI" style="background-image:url('.$img.')">';
		    echo '<div class="demo2-large">';
		    echo '<h1>';
		    single_cat_title();
		    echo '</h1><p>';
		    echo strip_tags(category_description());
		    echo '</p>';
		    echo '</div>';
		  	echo '</div>';
		}
		
	}

	public function tag_top($tags_id){
		if($this->option['_cx_catag_demo'] !='no'){
			/** 已获取tag标签ID **/
			$args = array( 'tags' =>$tags_id);
			$tags = cx_get_tags_category($args);
			$cat = $tags[0]->term_id;
			/** 已获取cat分类ID **/
			$cat_id = get_category_link($cat);
			if(!isset($_GET['ctag'])){
				$tag_cla = ' linked';
				$cxtag = null;
				$cxtag_get = null;
			}else{
				$cxtag = $_GET['ctag'];
				$cxtag_get = '&ctag='.$cxtag;
				$tag_cla = null;
			}
			cat_meta_information();?>
			<div class="fl_title" data-id="tag_55944">
			    <div class="fl01"> <?php single_cat_title(); ?></div>
			</div>
			<div class="filter-wrap">
			    <div class="filter-tag">
					<div class="fl_list"><span> 标签：</span>
					<?php cx_ctag_post($cat, $cat_id ,$tag_cla ,$cxtag);?>
					</div>        
			        <div class="fl_list" style="margin-top:10px;"><span> 排序：</span>
			            <?php cat_get_sort($cxtag_get, $cat_id);?> 
			        </div>      
			    </div>      
			</div>
			</div>
		<?php
		}else{
			$img = (get_term_meta($tags_id, '_feng_images',true))?get_term_meta($tags_id, '_feng_images',true):'';
			echo '<div class="cat_demo2_UI" style="background-image:url('.$img.')">';
		    echo '<div class="demo2-large">';
		    echo '<h1>';
		    single_cat_title();
		    echo '</h1><p>';
		    echo strip_tags(category_description());
		    echo '</p>';
		    echo '</div>';
		  	echo '</div>';
		}
		
	}

	/** 加载分类列表 **/
	public function cat_archive(){
		cx__template('archive');
	}

	/** 加载首页列表 **/
	public function index_hdp(){
		cx__template('hdp');
	}

	/** 加载首页列表 **/
	public function index_list_demo(){
		cx__template('archive');
	}

	/** 加载首页专题模块 **/
	public function index_zt(){?>
		<div class="zt_list_index cl">
			<ul class="list_index_ul cl">
				<?php 		 
				$args=array(
					'post_type'=>'zhuanti_type',
					'posts_per_page'=>6,
					'paged'=>1,
					'orderby'=>'rand',
				);
				if ( have_posts() ) :
					query_posts($args);
					while ( have_posts() ) : the_post();
						cx_themes_switch(2002);
					endwhile;
				else:
					echo "您还没有添加专题，设置完再启用我吧！";
				endif;
				wp_reset_query();	
				?>				
			</ul>
		</div>
		<?php
	}

	/** 加载首页友情链接模块 **/
	public function index_link(){?>
		<div class="zt_list_index cl">
			<h3 class="link_tit"><span>友情链接</span></h3>
			<ul class="list_index_ul links cl">
				<?php wp_list_bookmarks('title_li=&categorize=0'); ?>				
			</ul>
		</div>
	<?php
	}
}
$index_opt = new Index_Option();	