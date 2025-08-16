<?php
// Add custom Theme Functions here
//Copy từng phần và bỏ vào file functions.php của theme:
//xoa mã bưu điện thanh toán
add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );
function custom_override_checkout_fields( $fields ) {
	unset($fields['billing']['billing_postcode']);
	unset($fields['billing']['billing_country']);
	unset($fields['billing']['billing_address_2']);
	unset($fields['billing']['billing_company']);


	return $fields;
}
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart');
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
class Auto_Save_Images{

	function __construct(){     

		add_filter( 'content_save_pre',array($this,'post_save_images') ); 
	}

	function post_save_images( $content ){
		if( ($_POST['save'] || $_POST['publish'] )){
			set_time_limit(240);
			global $post;
			$post_id=$post->ID;
			$preg=preg_match_all('/<img.*?src="(.*?)"/',stripslashes($content),$matches);
			if($preg){
				foreach($matches[1] as $image_url){
					if(empty($image_url)) continue;
					$pos=strpos($image_url,$_SERVER['HTTP_HOST']);
					if($pos===false){
						$res=$this->save_images($image_url,$post_id);
						$replace=$res['url'];
						$content=str_replace($image_url,$replace,$content);
					}
				}
			}
		}
		remove_filter( 'content_save_pre', array( $this, 'post_save_images' ) );
		return $content;
	}

	function save_images($image_url,$post_id){
		$file=file_get_contents($image_url);
		$post = get_post($post_id);
		$posttitle = $post->post_title;
		$postname = sanitize_title($posttitle);
		$im_name = "$postname-$post_id.jpg";
		$res=wp_upload_bits($im_name,'',$file);
		$this->insert_attachment($res['file'],$post_id);
		return $res;
	}

	function insert_attachment($file,$id){
		$dirs=wp_upload_dir();
		$filetype=wp_check_filetype($file);
		$attachment=array(
			'guid'=>$dirs['baseurl'].'/'._wp_relative_upload_path($file),
			'post_mime_type'=>$filetype['type'],
			'post_title'=>preg_replace('/\.[^.]+$/','',basename($file)),
			'post_content'=>'',
			'post_status'=>'inherit'
		);
		$attach_id=wp_insert_attachment($attachment,$file,$id);
		$attach_data=wp_generate_attachment_metadata($attach_id,$file);
		wp_update_attachment_metadata($attach_id,$attach_data);
		return $attach_id;
	}
}
new Auto_Save_Images();
function register_my_menu() {
	register_nav_menu('product-menu',__( 'Menu Danh mục' ));
}
add_action( 'init', 'register_my_menu' );
function Gia_giam() {
	global $product;
	if( $product->is_on_sale() ) {
		return $product->get_sale_price();
	}

}
function Gia_goc() {
	global $product;
	if( $product->is_on_sale() ) {
		return $product->get_regular_price();
	}

}
add_action( 'init', 'jk_remove_wc_breadcrumbs' );
function jk_remove_wc_breadcrumbs() {
	remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
}
// Enqueue Scripts and Styles.
add_action( 'wp_enqueue_scripts', 'flatsome_enqueue_scripts_styles' );
function flatsome_enqueue_scripts_styles() {
	wp_enqueue_style( 'dashicons' );
	wp_enqueue_style( 'flatsome-ionicons', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css' );
}

// Add our custom product cat rewrite rules
function devvn_product_category_rewrite_rules($flash = false) {
	$terms = get_terms( array(
		'taxonomy' => 'product_cat',
		'post_type' => 'product',
		'hide_empty' => false,
	));
	if($terms && !is_wp_error($terms)){
		$siteurl = esc_url(home_url('/'));
		foreach ($terms as $term){
			$term_slug = $term->slug;
			$baseterm = str_replace($siteurl,'',get_term_link($term->term_id,'product_cat'));
			add_rewrite_rule($baseterm.'?$','index.php?product_cat='.$term_slug,'top');
			add_rewrite_rule($baseterm.'page/([0-9]{1,})/?$', 'index.php?product_cat='.$term_slug.'&paged=$matches[1]','top');
			add_rewrite_rule($baseterm.'(?:feed/)?(feed|rdf|rss|rss2|atom)/?$', 'index.php?product_cat='.$term_slug.'&feed=$matches[1]','top');
		}
	}
	if ($flash == true)
		flush_rewrite_rules(false);
}
add_action('init', 'devvn_product_category_rewrite_rules');
function the_dramatist_custom_login_css() {
    echo '<style type="text/css">.login h1:after{content:"Thi\1EBF t k\1EBF  website nhanh ch\00F3 ng, chuy\00EA n nghi\1EC7 p";font-size:16px;font-weight:normal;text-align:center}body #login{width:calc(100% - 30px);width:-webkit-calc(100% - 30px);width:-moz-calc(100% - 30px);width:-ms-calc(100% - 30px);width:-o-calc(100% - 30px);max-width:420px;background:#fff;padding:29px 24px 16px 24px!important;box-shadow:0 0 2rem 0 rgba(136,152,170,.15);border-radius:.375rem}body #login form{width:100%;margin:0 auto;box-shadow:none!important;border:0!important;padding:0!important}body #login .message{width:100%;margin-left:auto;margin-right:auto;box-shadow:none!important;color:#155724;background-color:#d4edda;border:1px solid #c3e6cb!important;border-radius:3px}body.login{display:flex;flex-direction:column;justify-content:center;align-items:center}body.login *{box-sizing:border-box}.login #backtoblog,.login #nav{padding:0!important}.login form .input,.login form input[type=checkbox],.login input[type=text]{background:#fff!important;font-size:16px;padding:0 12px;border:1px solid #DCE1E7;box-shadow:none!important}.login form .input:focus,.login form input[type=checkbox]:focus,.login input[type=text]:focus{border-color:#4DA6E8}.login #wp-submit{box-shadow: none !important;padding:2px 20px;background:#4DA6E8;background:linear-gradient(to right,#00d4fd,#338aff);background-image:linear-gradient(135deg,#03cffd 10%,#0396FF 100%);background-size:200% auto;border:0;outline:none!important}.login #wp-submit:hover{background-size:125% auto}.login #backtoblog a:hover,.login #nav a:hover{color:#4DA6E8}.login h1{margin-bottom:15px}.login h1 a{background-image:url('.str_replace("http://","",get_home_url()).'/logo.png)!important;width:150px!important;height:41px!important;background-size:150px 41px!important;margin-bottom:10px!important}</style>';
}
add_action('login_head', 'the_dramatist_custom_login_css');
// Thay doi duong dan logo admin
function wpc_url_login(){
return get_home_url(); // duong dan vao website cua ban
}
add_filter('login_headerurl', 'wpc_url_login');
//Tùy chỉnh admin footer
function custom_admin_footer() { 
 echo 'Thiết kế bởi <a href="https://bizhostvn.com/" target="blank">Bizhostvn.com</a>';}
 add_filter('admin_footer_text', 'custom_admin_footer');
//Xóa logo wordpress
add_action( 'admin_bar_menu', 'remove_wp_logo', 999 );

function remove_wp_logo( $wp_admin_bar ) {
    $wp_admin_bar->remove_node( 'wp-logo' );
}
// hide update notifications
function remove_core_updates(){
global $wp_version;return(object) array('last_checked'=> time(),'version_checked'=> $wp_version,);
}
add_filter('pre_site_transient_update_core','remove_core_updates'); //hide updates for WordPress itself
add_filter('pre_site_transient_update_plugins','remove_core_updates'); //hide updates for all plugins
add_filter('pre_site_transient_update_themes','remove_core_updates'); //hide updates for all themes


/* ==== Company data from REST API (header title, <title>, login logo) ==== */
if ( ! function_exists('child_get_company_data') ) {
  function child_get_company_data() {
    // dùng lại helper nếu bạn đặt company-data.php trong child theme
    $helper = get_stylesheet_directory() . '/company-data.php';
    if ( file_exists($helper) ) require_once $helper;

    if ( function_exists('get_company_data') ) {
      return get_company_data();
    }
    return array();
  }
}

/* 1) Thay Site Title toàn site bằng tên công ty từ API */
add_filter('pre_option_blogname', function($value){
  $c = child_get_company_data();
  return !empty($c['short_name']) ? $c['short_name'] : $value;
});

/* 2) Thay thẻ <title> (document title) phần "site" bằng tên công ty */
add_filter('document_title_parts', function($parts){
  $c = child_get_company_data();
  if ( !empty($c['short_name']) ) $parts['site'] = $c['short_name'];
  return $parts;
});

/* 3) (Tùy chọn) Đổi logo trang login theo logo API – nếu không muốn thì comment block này */
add_action('login_head', function () {
  $c = child_get_company_data();
  if ( empty($c['logo_url']) ) return;

  $logo = trim($c['logo_url']);
  if ($logo && strpos($logo, 'http') !== 0) {
    $logo = 'https://tool-deploy.bmappp.com' . $logo;
  }
  echo '<style>.login h1 a{background-image:url('.esc_url($logo).')!important;background-size:contain!important;width:220px!important;height:60px!important;}</style>';
});

add_action('wp_head', function () {
  if (!function_exists('child_get_company_data')) return;
  $c = child_get_company_data();
  if (empty($c['logo_url'])) return;

  $url = trim($c['logo_url']);
  if ($url && strpos($url, 'http') !== 0) {
    $url = 'https://tool-deploy.bmappp.com' . $url; // nối domain nếu đường dẫn tương đối
  }

  // In favicon (ưu tiên SVG nếu backend trả SVG)
  $type = (str_ends_with(strtolower($url), '.svg')) ? 'image/svg+xml' : 'image/png';
  echo "\n<link rel=\"icon\" href=\"".esc_url($url)."\" type=\"".$type."\">\n";
  echo "<link rel=\"apple-touch-icon\" href=\"".esc_url($url)."\">\n";
}, 1);

// ==== Shortcodes lấy dữ liệu Company từ API ====
if ( ! function_exists('get_company_data') ) {
  require_once get_stylesheet_directory() . '/company-data.php'; // đã tạo trước đó
}
function _company(){ return function_exists('get_company_data') ? (get_company_data() ?: []) : []; }
add_shortcode('name',      fn() => esc_html((_company()['name'] ?? '')));
add_shortcode('company_name',      fn() => esc_html((_company()['name_vn'] ?? '')));
add_shortcode('short_name',      fn() => esc_html((_company()['short_name'] ?? '')));
add_shortcode('company_license',   fn() => esc_html((_company()['license_no'] ?? '')));
add_shortcode('company_hotline',   fn() => esc_html((_company()['hotline'] ?? '')));
add_shortcode('company_email',     fn() => esc_html((_company()['email'] ?? '')));
add_shortcode('company_address',   fn() => nl2br(esc_html((_company()['address'] ?? ''))));
add_shortcode('company_desc',      fn() => esc_html((_company()['description'] ?? '')));
add_shortcode('website',      fn() => esc_html((_company()['domain'] ?? '')));

// Map: cho phép in <iframe>
add_shortcode('company_map', function () {
  $map = _company()['google_map_embed'] ?? '';
  return $map ? $map : '';
});