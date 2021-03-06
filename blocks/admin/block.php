<?php

function doliconnect_admin_block_render( $attributes, $content ) {

$args = array( 
'blog_id'      => $GLOBALS['blog_id'],
'role'         => 'administrator',
'meta_key' => 'doliboard_'.get_current_blog_id(),
'orderby' => 'meta_value',
'order'        => 'ASC',
);

$user_query = new WP_User_Query( $args );
$html = "<DIV class='row'>";
if ( ! empty( $user_query->results ) ) {
foreach ( $user_query->results as $user ) {
$html .= "<DIV class='";
if( !empty($attributes['col']) && $attributes['col'] == '3' ) {
$html .= "col-12 col-md-6 col-lg-4";
} else { $html .= "col-12 col-md-6 col-lg-6"; }


$order1="doliboard_".get_current_blog_id();
$order=$user->$order1;

$style = !empty($attributes['adminCardStyle']) ? $attributes['adminCardStyle'] : '';

$html .= "'><DIV class='card ".$style." mb-3 shadow-sm'>
<DIV class='card-body'>
<DIV class='row'><DIV class='col-4'>".get_avatar($user->ID, 100)."</DIV><DIV class='col-8 text-justify'><H6>" . esc_html( $user->user_firstname ) . ' ' . esc_html( $user->user_lastname ) . "</H6>".get_option('doliboard_title_'.$order)."<br/>".substr( get_the_author_meta('description',$user->ID) , 0 , 100) . "</DIV></DIV></DIV><DIV class='card-footer'>";
if ($user->facebook) { 
$html .= '<A href="https://www.facebook.com/'.$user->facebook.'" target="_blank"><I class="fab fa-facebook-square fa-2x fa-fw"></I></A> ';}
if ($user->twitter) { 
$html .= '<A href="https://www.twitter.com/'.$user->twitter.'" target="_blank"><I class="fab fa-twitter-square fa-2x fa-fw"></I></A> ';}
if ($user->linkedin) { 
$html .= '<A href="https://www.linkedin.com/'.$user->linkedin.'" target="_blank"><I class="fab fa-linkedin fa-2x fa-fw"></I></A>';}
$html .= "</DIV>
</DIV></DIV>";
}
}else{
$html .= 'No admins found!';
}
$args = array( 
'blog_id'      => $GLOBALS['blog_id'],
'role'         => 'editor',
'meta_key' => 'doliboard_'.get_current_blog_id(),
'orderby' => 'meta_value',
'order'        => 'ASC',
);

$user_query = new WP_User_Query( $args );

if ( ! empty( $user_query->results ) ) {
foreach ( $user_query->results as $user ) {
$html .= "<DIV class='";
if(is_active_sidebar('sidebar-widget-area')){
$html .= "col-12 col-md-6 col-lg-6";
}else{
$html .= "col-12 col-md-6 col-lg-4";
}
$order1="doliboard_".get_current_blog_id();
$order=$user->$order1;
$html .= "'><DIV class='card card ".$style." mb-3 shadow-sm mb-3'>
<DIV class='card-body'>
<DIV class='row'><DIV class='col-4'>".get_avatar($user->ID, 100)."</DIV><DIV class='col-8 text-justify'>".get_option('doliboard_title_'.$order)."<br/>".substr( get_the_author_meta('description',$user->ID) , 0 , 100) . "";
if ($user->facebook) { 
$html .= '<A href="https://www.facebook.com/'.$user->facebook.'" target="_blank"><I class="fab fa-facebook-square fa-2x fa-fw"></I></A> ';}
if ($user->twitter) { 
$html .= '<A href="https://www.twitter.com/'.$user->twitter.'" target="_blank"><I class="fab fa-twitter-square fa-2x fa-fw"></I></A> ';}
if ($user->linkedin) { 
$html .= '<A href="https://www.linkedin.com/'.$user->linkedin.'" target="_blank"><I class="fab fa-linkedin fa-2x fa-fw"></I></A>';}
$html .= "</DIV></DIV></DIV><DIV class='card-footer'><H6>" . esc_html( $user->user_firstname ) . ' ' . esc_html( $user->user_lastname ) . "</H6></DIV>
</DIV></DIV>";
}
}
$html .= "</DIV>";
return $html;
}
function doliconnect_admin_block_init() {
	if ( function_exists( 'register_block_type' ) ) {
		wp_register_script(
			'admin-block',
			plugins_url( 'block.js', __FILE__ ),
			array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-components' ),
      'beta3'
		);
		register_block_type(
			'doliconnect/admin-block',
			array(
				'editor_script'   => 'admin-block',
				'render_callback' => 'doliconnect_admin_block_render',
			)
		);
	}
}
add_action( 'init', 'doliconnect_admin_block_init' );