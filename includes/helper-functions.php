<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly



// Getting Page List
function WDF_page_list_selection(){
	$pagelist = get_posts(array(
		'post_type' => 'elementor_library',
		'showposts' => 999,
	));
	$posts = array();
	
	if ( ! empty( $pagelist ) && ! is_wp_error( $pagelist ) ){
	foreach ( $pagelist as $post ) {
		$options[ $post->ID ] = $post->post_title;
	} 
	return $options;
	}
}


// Getting Post List
function WDF_post_list_selection(){
	$pagelist = get_posts(array(
		'post_type' => 'post',
		'showposts' => 999,
	));
	$posts = array();
	
	if ( ! empty( $pagelist ) && ! is_wp_error( $pagelist ) ){
	foreach ( $pagelist as $post ) {
		$options[ $post->ID ] = $post->post_title;
	} 
	return $options;
	}
}


// Getting Contact Form & Llists
if ( function_exists( 'wpcf7' ) ) {
function WDF_contact_form_selection(){
	$contactlist = get_posts(array(
		'post_type' => 'wpcf7_contact_form',
		'showposts' => 999,
	));
	$posts = array();
	
	if ( ! empty( $contactlist ) && ! is_wp_error( $contactlist ) ){
		
	$i = 0;
	foreach ( $contactlist as $post ) {	
	   if($i == 0) {
			$options[ 0 ] = esc_html__( 'Choose a Contact form', 'web-disrupt-funnelmentals' );
	   }	
		$options[ $post->ID ] = $post->post_title;
		 $i++;
	} 
	return $options;
	}
}
}

//Query Post Types
function web_disrupt_funnelmentals_post_type_control(){
	//https://wordpress.stackexchange.com/questions/85165/get-all-custom-post-types-excepted-some
	
	$WDF_cpts = get_post_types( array( 'public'   => true, 'show_in_nav_menus' => true ) );
	$WDF_exclude_cpts = array( 'elementor_library', 'attachment', 'product' );
	
	
	foreach ( $WDF_exclude_cpts as $exclude_cpt ) {
		unset($WDF_cpts[$exclude_cpt]);
	}
	

	$post_types = array_merge($WDF_cpts);
	return $post_types;
}


function web_disrupt_funnelmentals_excerpt($limit) {
  $excerpt = explode(' ', get_the_excerpt(), $limit);
  if (count($excerpt)>=$limit) {
    array_pop($excerpt);
    $excerpt = implode(" ",$excerpt).'...';
  } else {
    $excerpt = implode(" ",$excerpt);
  }	
  $excerpt = preg_replace('`[[^]]*]`','',$excerpt);
  return $excerpt;
}


//Query Authors List
function web_disrupt_funnelmentals_post_type_author(){
	$user_query = new \WP_User_Query(
		[
			'who' => 'authors',
			'has_published_posts' => true,
			'fields' => [
				'ID',
				'display_name',
			],
		]
	);

	$authors = [];

	foreach ( $user_query->get_results() as $result ) {
		$authors[ $result->ID ] = $result->display_name;
	}

	return $authors;
}

//Query Categories List
function web_disrupt_funnelmentals_post_type_categories(){
	//https://developer.wordpress.org/reference/functions/get_terms/
	$terms = get_terms( array( 
		'taxonomy' => 'category',
		'hide_empty' => true,
	));
	
	if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
	foreach ( $terms as $term ) {
		$options[ $term->term_id ] = $term->name;
	}
	}
	
	return $options;
}



//Query Tags List
function web_disrupt_funnelmentals_post_type_tags(){

	$terms = get_terms( array( 
		'taxonomy' => 'post_tag',
		'hide_empty' => true,
	));
	
	if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
	foreach ( $terms as $term ) {
		$options[ $term->term_id ] = $term->name;
	}
	return $options;
	
	}
	
	
}

//Query Post Formats
function web_disrupt_funnelmentals_post_type_format(){

	$terms = get_terms( array( 
		'taxonomy' => 'post_format',
		'hide_empty' => true,
	));
	
	if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
	foreach ( $terms as $term ) {
		$options[ $term->term_id ] = $term->name;
	}
	}
	
	return $options;
	
}


if ( function_exists( 'WC' ) ) {
//Query Product Categories List by Slug
function web_disrupt_funnelmentals_post_type_product_categories(){
	//https://developer.wordpress.org/reference/functions/get_terms/
	$terms = get_terms( array(
		'taxonomy' => 'product_cat',
		'hide_empty' => true,
	));
	
	if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
	foreach ( $terms as $term ) {
		$options[ $term->slug ] = $term->name;
	}
	return $options;
	}
	
	
}

//
function web_disrupt_funnelmentals_get_product_by_id(){
	//https://developer.wordpress.org/reference/functions/get_terms/
	$postlist = get_posts(array(
		'post_type' => 'product',
		'showposts' => 999,
	));
	$posts = array();
	
	if ( ! empty( $postlist ) && ! is_wp_error( $postlist ) ){
	foreach ( $postlist as $post ) {
		$options[ $post->ID ] = $post->post_title;
	}
	return $options;
	
	}
}


//Query Product Categories List by ID
function web_disrupt_funnelmentals_post_type_product_categories_by_id(){
	//https://developer.wordpress.org/reference/functions/get_terms/
	$terms = get_terms( array(
		'taxonomy' => 'product_cat',
		'hide_empty' => true,
	));
	
	if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
	foreach ( $terms as $term ) {
		$options[ $term->term_id ] = $term->name;
	}
	return $options;
	}
	
	
}

} // Closing If Function WC Exists


//Query Categories List
function web_disrupt_funnelmentals_post_type_portfolio_categories(){
	//https://developer.wordpress.org/reference/functions/get_terms/
	$terms = get_terms( array(
		'taxonomy' => 'portfolio_category',
		'hide_empty' => true,
	));
	
	if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
	foreach ( $terms as $term ) {
		$options[ $term->term_id ] = $term->name;
	}
	}
	
	return $options;
}



//Query Categories List
function web_disrupt_funnelmentals_post_type_portfolio_tags(){
	//https://developer.wordpress.org/reference/functions/get_terms/
	
	$terms = get_terms( array(
		'taxonomy' => 'portfolio_tag',
		'hide_empty' => true,
	));
	
	if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
	foreach ( $terms as $term ) {
		$options[ $term->term_id ] = $term->name;
	}
	}
	
	return $options;
}


//Query Categories List
function web_disrupt_funnelmentals_post_type_portfolio_dash_categories(){
	//https://developer.wordpress.org/reference/functions/get_terms/
	$terms = get_terms( array(
		'taxonomy' => 'portfolio-category',
		'hide_empty' => true,
	));
	
	if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
	foreach ( $terms as $term ) {
		$options[ $term->term_id ] = $term->name;
	}
	}
	
	return $options;
}



//Query Categories List
function web_disrupt_funnelmentals_post_type_portfolio_dash_tags(){
	//https://developer.wordpress.org/reference/functions/get_terms/
	
	$terms = get_terms( array(
		'taxonomy' => 'portfolio-tag',
		'hide_empty' => true,
	));
	
	if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
	foreach ( $terms as $term ) {
		$options[ $term->term_id ] = $term->name;
	}
	}
	
	return $options;
}
