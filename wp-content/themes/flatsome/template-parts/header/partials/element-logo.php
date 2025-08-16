<?php
require_once get_stylesheet_directory() . '/company-data.php';
$c = function_exists('get_company_data') ? get_company_data() : [];
$shortName = !empty($c['short_name']) ? $c['short_name'] : get_bloginfo('name');
?>
<a href="<?php echo esc_url(home_url('/')); ?>"
   style="display:inline-block;font-size:20px;line-height:1.15;font-weight:700;text-decoration:none;white-space:normal;max-width:260px;overflow-wrap:anywhere;color:white;">
  <?php echo esc_html($shortName); ?>
</a>
