<?php

/**
 * Widget class for kiip moment display
 * supported in wide sidebars for now
 * shortcode takes priority over this widget
 *
 * @since 3.1.3
 */

class kiip_Widget extends WP_Widget {

	// Set up the widget name and description.
	public

	function __construct() {
		$kiip_plugin_lang = kiip_for_wordpress::TEXTDOMAIN;
		$widget_options = array( 'classname' => 'kiip_moment_widget', 'description' => __( 'Displays a container kiip moment (Native Reward) in a widget. Takes priority over shortcodes.', $kiip_plugin_lang ) );
		parent::__construct( 'kiip_moment_widget', __( 'Kiip Moment Widget', $kiip_plugin_lang ), $widget_options );
	}

	// Create the widget output.
	public

	function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance[ 'title' ] );
		$blog_title = get_bloginfo( 'name' );
		$tagline = get_bloginfo( 'description' );
		echo $args[ 'before_widget' ] . $args[ 'before_title' ] . $title . $args[ 'after_title' ];
		// add html to widget contents
		?>
		<?php echo '<span id=\'kiip-moment-container\' class=\'kiip-moment-container-widget\'></span>'; ?>
		<?php
		echo $args[ 'after_widget' ];
	}

	// Create the admin area widget settings form.
	public

	function form( $instance ) {
		$title = !empty( $instance[ 'title' ] ) ? $instance[ 'title' ] : '';
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">
				<?php _e('Title', $kiip_plugin_lang)?>:</label>
			<input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $title ); ?>"/>
		</p>
		<?php
	}

	// Apply settings to the widget instance.
	public

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance[ 'title' ] = strip_tags( $new_instance[ 'title' ] );
		return $instance;
	}
}


/**
 * Set up scripts and styles for the widget
 *
 * @since 3.1.3
 *
 */

function kiip_setup_enque_actions() {
	$plugin_data = kiip_for_wordpress::init();
	wp_enqueue_script( 'kiip-for-wp-public', kiip_the_url() . 'public/js/kiip-for-wordpress-public-contained.js', array( 'jquery' ), kiip_for_wordpress::VERSION );
	wp_localize_script( 'kiip-for-wp-public', 'php_vars', $plugin_data->kiip_options_array() );
}

/**
 * checking pages, posts, posts page etc for our shortcode outside any classes
 *
 * @since 3.1.3
 *
 */

function kiip_check_for_shortcode() {
	global $wp_query;
	$posts = $wp_query->posts;
	$pattern = get_shortcode_regex();
	foreach ( $posts as $post ) {


		if (isset( $post->post_content )) {
		if ( preg_match_all( '/' . $pattern . '/s', $post->post_content, $matches ) &&
			array_key_exists( 2, $matches ) &&
			in_array( 'kiip_ad_shortcode', $matches[ 2 ] ) ) {
			break;
		} else {
			add_action( 'wp_enqueue_scripts', 'kiip_setup_enque_actions' );
		}
	 }
	}
}

// check for our shortcode outside any classes. wp.
add_action( 'wp', 'kiip_check_for_shortcode' );


// Register the widget.
function kiip_moment_register_widget() {
	register_widget( 'kiip_Widget' );
}

// inititiate the widget
add_action( 'widgets_init', 'kiip_moment_register_widget' );
