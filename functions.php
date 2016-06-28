<?php
/**
 * _s functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package blackpirates
 */


require_once( get_template_directory() . '/inc/constants.php' );
$options = blackpirates_initoptions();
require_once( get_template_directory() . '/inc/helper-functions.php' );
require_once( get_template_directory() . '/inc/theme-options.php' );    

if ( ! function_exists( 'blackpirates_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function blackpirates_setup() {
    global $options;
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on _s, use a find and replace
	 * to change 'blackpirates' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'blackpirates', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', 'blackpirates' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See https://developer.wordpress.org/themes/functionality/post-formats/
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'blackpirates_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
        
        // Remove comments on pages
       	remove_post_type_support( 'page', 'comments' );
        if (isset($options['login_errors']) && ($options['login_errors'] = true)) {
	    /** Abschalten von Fehlermeldungen auf der Loginseite */      
           add_filter('login_errors', create_function('$a', "return null;"));
        }   

	/* Remove something out of the head */
	remove_action( 'wp_head', 'feed_links_extra', 3 ); // Display the links to the extra feeds such as category feeds
	remove_action( 'wp_head', 'feed_links', 2 ); // Display the links to the general feeds: Post and Comment Feed	
	remove_action( 'wp_head', 'post_comments_feed_link ', 2 ); // Display the links to the general feeds: Post and Comment Feed
	remove_action( 'wp_head', 'rsd_link' ); // Display the link to the Really Simple Discovery service endpoint, EditURI link
	remove_action( 'wp_head', 'wlwmanifest_link' ); // Display the link to the Windows Live Writer manifest file.
	remove_action( 'wp_head', 'index_rel_link' ); // index link
	remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 ); // prev link
	remove_action( 'wp_head', 'adjacent_posts_rel_link', 10, 0 ); // Display relational links for the posts adjacent to the current post.

        //  remove_action('wp_head', 'wp_generator');
        //  remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0);

}

endif; // blackpirates_setup
add_action( 'after_setup_theme', 'blackpirates_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function blackpirates_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'blackpirates_content_width', 640 );
}
add_action( 'after_setup_theme', 'blackpirates_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function blackpirates_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'blackpirates' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'blackpirates_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function blackpirates_scripts() {
    global $options;
	wp_enqueue_style( 'blackpirates-style', get_stylesheet_uri() );
	wp_enqueue_script( 'modernizr', get_template_directory_uri() . '/js/modernizr.custom.min.js', array(), $options['js-version'], false );
	wp_enqueue_script( 'blackpirates-classie', get_template_directory_uri() . '/js/classie.min.js', array(), $options['js-version'], true );
	wp_enqueue_script( 'blackpirates-bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery'), $options['js-version'], true );
	wp_enqueue_script( 'blackpirates-mlpushmenu', get_template_directory_uri() . '/js/mlpushmenu.min.js', array('modernizr','blackpirates-classie'), $options['js-version'], true );
	wp_enqueue_script( 'blackpirates-theme', get_template_directory_uri() . '/js/theme.min.js', array('modernizr', 'blackpirates-mlpushmenu'), $options['js-version'], true );

//	wp_enqueue_script( 'blackpirates-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'blackpirates_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';



/**
 *  Theme dependend functions
 */

/**
 * Load menu and navigation settings
 */
require get_template_directory() . '/inc/menu.php';
 
/*
 * Init options
 */

function blackpirates_initoptions() {
   global $defaultoptions;
    
    $oldoptions = get_option('blackpirates_theme_options');
    if (isset($oldoptions) && (is_array($oldoptions))) {
        $newoptions = array_merge($defaultoptions,$oldoptions);	  
    } else {
        $newoptions = $defaultoptions;
    }    
    return $newoptions;
}

/* Refuse spam-comments on media */
function filter_media_comment_status( $open, $post_id ) {
	$post = get_post( $post_id );
	if( $post->post_type == 'attachment' ) {
		return false;
	}
	return $open;
}
add_filter( 'comments_open', 'filter_media_comment_status', 10 , 2 );
