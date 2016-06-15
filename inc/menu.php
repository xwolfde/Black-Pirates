<?php

/* 
 * Functions for menus and navigation
 */


/* 
 * Create breadcrumb
 */
 
 
function blackpirates_breadcrumb($lasttitle = '') {
  global $options;
  
  $delimiter	= '';
  $home		= $options['breadcrumb_root']; // __( 'Startseite', 'blackpirates' ); // text for the 'Home' link
  $before	= '<li class="active">'; // tag before the current crumb
  $beforetree	= '<li>'; // tag before the current crumb
  $after	= '</li>'; // tag after the current crumb
  $pretitletextstart   = '<span>';
  $pretitletextend     = '</span>';
  $show_on_startpage = $options['breadcrumb_show_onstartpage']; // If true, on startpage, show a breadcrumb
  
  
  if (($show_on_startpage != true) && (is_home() || is_front_page())) {
      return;
  }
  
  if ($options['breadcrumb_withtitle']) {
	echo '<h3 class="breadcrumb_sitetitle" role="presentation">'.get_bloginfo( 'title' ).'</h3>';
	echo "\n";
    }
  echo '<nav aria-labelledby="bc-title" class="breadcrumb">'; 
  echo '<h4 class="screen-reader-text" id="bc-title">'.__('You are here:','blackpirates').'</h4>';
  echo "<ol>";
  if ( !is_home() && !is_front_page() || is_paged() ) { 
    
    global $post;
    
    $homeLink = home_url('/');
    echo $beforetree;
    echo '<a href="' . $homeLink . '">' . $home . '</a>';
    echo $after;
    
    if ( is_category() ) {
	global $wp_query;
	$cat_obj = $wp_query->get_queried_object();
	$thisCat = $cat_obj->term_id;
	$thisCat = get_category($thisCat);
	$parentCat = get_category($thisCat->parent);
	if ($thisCat->parent != 0) 
	    echo(get_category_parents($parentCat, TRUE, $delimiter ));
	echo $before . single_cat_title('', false) .  $after;
 
    } elseif ( is_day() ) {
	echo $beforetree. '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a>' .$after;
	echo $beforetree.'<a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a>' .$after;
	echo $before . get_the_time('d') . $after; 
    } elseif ( is_month() ) {
	echo $beforetree.'<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a>' . $after;
	echo $before . get_the_time('F') . $after;
    } elseif ( is_year() ) {
	echo $before . get_the_time('Y') . $after; 
    } elseif ( is_single() && !is_attachment() ) {
	 
	if ( get_post_type() != 'post' ) {
	    $post_type = get_post_type_object(get_post_type());
	    $slug = $post_type->rewrite;
	    echo $beforetree. '<a href="' . $homeLink . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a>' .$after;
	    echo $before . get_the_title() . $after; 
	} else {
	    
            $cat = get_the_category(); 
            if ($options['breadcrumb_uselastcat']) {
                $last = array_pop($cat);
            } else {
                $last = $cat[0];
            }
            $catid = $last->cat_ID;
        //    echo $beforehtml. 
         //   echo get_category_parents($catid, TRUE,  $delimiter );
            echo $before . get_the_title() . $after;

	} 
    } elseif ( !is_single() && !is_page() && !is_search() && get_post_type() != 'post' && !is_404() ) {
	$post_type = get_post_type_object(get_post_type());
	echo $before . $post_type->labels->singular_name . $after;
    } elseif ( is_attachment() ) {
	$parent = get_post($post->post_parent);
	echo $beforetree. '<a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a>'. $after;
	echo $before . get_the_title() . $after;
    } elseif ( is_page() && !$post->post_parent ) {
	echo $before . get_the_title() . $after;
 
    } elseif ( is_page() && $post->post_parent ) {
	$parent_id  = $post->post_parent;
	$breadcrumbs = array();
	while ($parent_id) {
	    $page = get_page($parent_id);
	    $breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
	    $parent_id  = $page->post_parent;
	}
	$breadcrumbs = array_reverse($breadcrumbs);
	foreach ($breadcrumbs as $crumb) echo $beforetree. $crumb . $after;
	echo $before . get_the_title() . $after; 
    } elseif ( is_search() ) {
	if (isset($lasttitle) && (strlen(trim($lasttitle))>1)) {
	    echo $before . $lasttitle. $after; 
	} else {
	    echo $before .$pretitletextstart. __( 'Search for', 'blackpirates' ).$pretitletextend.' "' . get_search_query() . '"' . $after; 
	}
    } elseif ( is_tag() ) {
	echo $before .$pretitletextstart. __( 'Tag', 'blackpirates' ).$pretitletextend. ' "' . single_tag_title('', false) . '"' . $after; 
    } elseif ( is_author() ) {
	global $author;
	$userdata = get_userdata($author);
	echo $before .$pretitletextstart. __( 'Entries by', 'blackpirates' ).$pretitletextend.' '.$userdata->display_name . $after;
    } elseif ( is_404() ) {
	echo $before . '404' . $after;
    }

  } elseif (is_front_page())  {
	echo $before . $home . $after;
  } elseif (is_home()) {
	echo $before . get_the_title(get_option('page_for_posts')) . $after;
  }
  echo "</ol>";
   echo '</nav>'; 
   
}




class Walker_Main_Menu extends Walker_Nav_Menu {
	private $currentID;

       
     public function start_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
        $output .= "\n".$indent."<ul>\n";
    }

    public function end_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
        $output .= "\n".$indent."</ul>\n";
    }
   

public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
   $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

   $classes = empty( $item->classes ) ? array() : (array) $item->classes;
   $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
   $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

   // $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args, $depth );
   // id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

   $atts = array();
   $atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
   $atts['target'] = ! empty( $item->target )     ? $item->target     : '';
   $atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
   $atts['href']   = ! empty( $item->url )        ? $item->url        : '';

   $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

   $attributes = '';
   foreach ( $atts as $attr => $value ) {
      if ( ! empty( $value ) ) {
         $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
         $attributes .= ' ' . $attr . '="' . $value . '"';
      }
   }
   
   $item_output = $args->before;
   $item_output .= '<a'. $attributes .'>';
   $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
   $item_output .= '</a>';
   $item_output .= $args->after;

   if ($item->has_children) {          
        $output .= $indent .'<li class="icon icon-arrow-left">'."\n";
        $subrahmen = '';
        $subrahmen .= $indent .$item_output."\n";
        $subrahmen .= $indent ."\t".'<div class="mp-level"> <!-- mp-level '.$item->ID.' -->'."\n";
        $subrahmen .= $indent."\t\t" .'<h2 class="icon icon-display">';
        $subrahmen .= apply_filters( 'the_title', $item->title, $item->ID );
        $subrahmen .= '</h2>'."\n";
        $subrahmen .= $indent."\t\t" .'<a class="mp-back" href="#">'.__('Back','blackpirates').'</a>';
        $output .= apply_filters( 'walker_nav_menu_start_el', $subrahmen, $item, $depth, $args );     
   } else {
        $output .= $indent . '<li' . $class_names .'>'."\n";
        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );     
   } 
}

    public function end_el( &$output, $item, $depth = 0, $args = array() ) {
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
        
        if ($item->has_children) {
            $output .=  $indent ."\t".'</div> <!-- /mp-level '.$item->ID.' -->'."\n";
        }
        $output .=  $indent ."</li>\n";
    }
   
    public function display_element( $element, &$children_elements, $max_depth, $depth = 0, $args, &$output ) {
     
        // remove normal bulk classes from element
        $element->classes = array(); 
           
        // if element is current or is an ancestor of the current element, add 'active' class to the list item
        $element->classes[] = ( $element->current || $element->current_item_ancestor ) ? 'active' : '';

        // if it is a root element and the menu is not flat, add 'has-dropdown' class 
        // from https://core.trac.wordpress.org/browser/trunk/src/wp-includes/class-wp-walker.php#L140
        $element->has_children = ! empty( $children_elements[ $element->ID ] );
        $element->classes[] = ( $element->has_children && 1 !== $max_depth ) ? 'has-dropdown' : '';

        // call parent method
        parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
    }
   
}


/**
 * Add a property to a menu item
 *
 * @param object $item The menu item object.
 */
function custom_nav_menu_item( $item ) {
   $item->icon = get_post_meta( $item->ID, '_menu_item_icon', true );
   return $item;
}
add_filter( 'wp_setup_nav_menu_item', 'custom_nav_menu_item' );

/**
 * Save menu item custom fields' values
 * 
 * @link https://codex.wordpress.org/Function_Reference/sanitize_html_class
 */
function custom_update_nav_menu_item( $menu_id, $menu_item_db_id, $menu_item_args ){
   if ( is_array( $_POST['menu-item-icon'] ) ) {
      $menu_item_args['menu-item-icon'] = $_POST['menu-item-icon'][$menu_item_db_id];
      update_post_meta( $menu_item_db_id, '_menu_item_icon', sanitize_html_class( $menu_item_args['menu-item-icon'] ) );
   }
}
add_action( 'wp_update_nav_menu_item', 'custom_update_nav_menu_item', 10, 3 );

add_filter( 'wp_edit_nav_menu_walker', function( $class ){ 
    return 'Custom_Walker_Nav_Menu_Edit'; 
} );




	/**
	 * Create HTML list of nav menu input items.
	 *
	 * @package WordPress
	 * @since 3.0.0
	 * @uses Walker_Nav_Menu
	 */
	class Custom_Walker_Nav_Menu_Edit extends Walker_Nav_Menu {
	        /**
	         * Starts the list before the elements are added.
	         *
	         * @see Walker_Nav_Menu::start_lvl()
	         *
	         * @since 3.0.0
	         *
	         * @param string $output Passed by reference.
	         * @param int    $depth  Depth of menu item. Used for padding.
	         * @param array  $args   Not used.
	         */
	        public function start_lvl( &$output, $depth = 0, $args = array() ) {}
	
	        /**
	         * Ends the list of after the elements are added.
	         *
	         * @see Walker_Nav_Menu::end_lvl()
	         *
	         * @since 3.0.0
	         *
	         * @param string $output Passed by reference.
	         * @param int    $depth  Depth of menu item. Used for padding.
	         * @param array  $args   Not used.
	         */
	        public function end_lvl( &$output, $depth = 0, $args = array() ) {}
	
	        /**
	         * Start the element output.
	         *
	         * @see Walker_Nav_Menu::start_el()
	         * @since 3.0.0
	         *
	         * @param string $output Passed by reference. Used to append additional content.
	         * @param object $item   Menu item data object.
	         * @param int    $depth  Depth of menu item. Used for padding.
	         * @param array  $args   Not used.
	         * @param int    $id     Not used.
	         */
	        public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
	                global $_wp_nav_menu_max_depth;
	                $_wp_nav_menu_max_depth = $depth > $_wp_nav_menu_max_depth ? $depth : $_wp_nav_menu_max_depth;
	
	                ob_start();
	                $item_id = esc_attr( $item->ID );
	                $removed_args = array(
	                        'action',
	                        'customlink-tab',
	                        'edit-menu-item',
	                        'menu-item',
	                        'page-tab',
	                        '_wpnonce',
	                );
	
	                $original_title = '';
	                if ( 'taxonomy' == $item->type ) {
                        $original_title = get_term_field( 'name', $item->object_id, $item->object, 'raw' );
	                        if ( is_wp_error( $original_title ) )
	                                $original_title = false;
	                } elseif ( 'post_type' == $item->type ) {
	                        $original_object = get_post( $item->object_id );
	                        $original_title = get_the_title( $original_object->ID );
	                }
	
	                $classes = array(
	                        'menu-item menu-item-depth-' . $depth,
	                        'menu-item-' . esc_attr( $item->object ),
	                        'menu-item-edit-' . ( ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? 'active' : 'inactive'),
	                );
	
	                $title = $item->title;
	
	                if ( ! empty( $item->_invalid ) ) {
	                        $classes[] = 'menu-item-invalid';
	                        /* translators: %s: title of menu item which is invalid */
	                        $title = sprintf( __( '%s (Invalid)' ), $item->title );
	                } elseif ( isset( $item->post_status ) && 'draft' == $item->post_status ) {
	                        $classes[] = 'pending';
	                        /* translators: %s: title of menu item in draft status */
	                        $title = sprintf( __('%s (Pending)'), $item->title );
	                }
	
	                $title = ( ! isset( $item->label ) || '' == $item->label ) ? $title : $item->label;
	
	                $submenu_text = '';
	                if ( 0 == $depth )
	                        $submenu_text = 'style="display: none;"';
	
                ?>
                <li id="menu-item-<?php echo $item_id; ?>" class="<?php echo implode(' ', $classes ); ?>">
	                        <dl class="menu-item-bar">
	                                <dt class="menu-item-handle">
	                                        <span class="item-title"><span class="menu-item-title"><?php echo esc_html( $title ); ?></span> <span class="is-submenu" <?php echo $submenu_text; ?>><?php _e( 'sub item' ); ?></span></span>
	                                        <span class="item-controls">
	                                                <span class="item-type"><?php echo esc_html( $item->type_label ); ?></span>
	                                                <span class="item-order hide-if-js">
	                                                        <a href="<?php
	                                                                echo wp_nonce_url(
	                                                                        add_query_arg(
	                                                                                array(
	                                                                                        'action' => 'move-up-menu-item',
	                                                                                        'menu-item' => $item_id,
	                                                                                ),
	                                                                                remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
	                                                                        ),
	                                                                        'move-menu_item'
	                                                                );
	                                                        ?>" class="item-move-up"><abbr title="<?php esc_attr_e('Move up'); ?>">&#8593;</abbr></a>
	                                                        |
	                                                        <a href="<?php
	                                                                echo wp_nonce_url(
	                                                                        add_query_arg(
	                                                                                array(
	                                                                                        'action' => 'move-down-menu-item',
	                                                                                        'menu-item' => $item_id,
	                                                                                ),
	                                                                                remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
	                                                                        ),
	                                                                        'move-menu_item'
	                                                                );
	                                                        ?>" class="item-move-down"><abbr title="<?php esc_attr_e('Move down'); ?>">&#8595;</abbr></a>
	                                                </span>
	                                                <a class="item-edit" id="edit-<?php echo $item_id; ?>" title="<?php esc_attr_e('Edit Menu Item'); ?>" href="<?php
	                                                        echo ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? admin_url( 'nav-menus.php' ) : add_query_arg( 'edit-menu-item', $item_id, remove_query_arg( $removed_args, admin_url( 'nav-menus.php#menu-item-settings-' . $item_id ) ) );
	                                                ?>"><?php _e( 'Edit Menu Item' ); ?></a>
	                                        </span>
	                                </dt>
	                        </dl>
	
	                        <div class="menu-item-settings" id="menu-item-settings-<?php echo $item_id; ?>">
	                                <?php if( 'custom' == $item->type ) : ?>
	                                        <p class="field-url description description-wide">
	                                                <label for="edit-menu-item-url-<?php echo $item_id; ?>">
	                                                        <?php _e( 'URL' ); ?><br />
	                                                        <input type="text" id="edit-menu-item-url-<?php echo $item_id; ?>" class="widefat code edit-menu-item-url" name="menu-item-url[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->url ); ?>" />
	                                                </label>
	                                        </p>
	                                <?php endif; ?>
	                                <p class="description description-thin">
	                                        <label for="edit-menu-item-title-<?php echo $item_id; ?>">
	                                                <?php _e( 'Navigation Label' ); ?><br />
	                                                <input type="text" id="edit-menu-item-title-<?php echo $item_id; ?>" class="widefat edit-menu-item-title" name="menu-item-title[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->title ); ?>" />
	                                        </label>
	                                </p>
	                                <p class="description description-thin">
	                                        <label for="edit-menu-item-attr-title-<?php echo $item_id; ?>">
	                                                <?php _e( 'Title Attribute' ); ?><br />
	                                                <input type="text" id="edit-menu-item-attr-title-<?php echo $item_id; ?>" class="widefat edit-menu-item-attr-title" name="menu-item-attr-title[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->post_excerpt ); ?>" />
	                                        </label>
	                                </p>
	                                <p class="field-link-target description">
	                                        <label for="edit-menu-item-target-<?php echo $item_id; ?>">
	                                                <input type="checkbox" id="edit-menu-item-target-<?php echo $item_id; ?>" value="_blank" name="menu-item-target[<?php echo $item_id; ?>]"<?php checked( $item->target, '_blank' ); ?> />
	                                                <?php _e( 'Open link in a new window/tab' ); ?>
	                                        </label>
	                                </p>
	                                <p class="field-css-classes description description-thin">
	                                        <label for="edit-menu-item-classes-<?php echo $item_id; ?>">
	                                                <?php _e( 'CSS Classes (optional)' ); ?><br />
	                                                <input type="text" id="edit-menu-item-classes-<?php echo $item_id; ?>" class="widefat code edit-menu-item-classes" name="menu-item-classes[<?php echo $item_id; ?>]" value="<?php echo esc_attr( implode(' ', $item->classes ) ); ?>" />
	                                        </label>
	                                </p>
	                                <p class="field-xfn description description-thin">
	                                        <label for="edit-menu-item-xfn-<?php echo $item_id; ?>">
	                                                <?php _e( 'Link Relationship (XFN)' ); ?><br />
	                                                <input type="text" id="edit-menu-item-xfn-<?php echo $item_id; ?>" class="widefat code edit-menu-item-xfn" name="menu-item-xfn[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->xfn ); ?>" />
	                                        </label>
	                                </p>
                                        <p class="field-custom description description-thin">
                                            <label for="edit-menu-item-icon-<?php echo $item_id; ?>">
                                            <?php _e( 'Menu Icon (optional)', 'blackpirates' ); ?><br />
                                            <input type="text" id="edit-menu-item-icon-<?php echo $item_id; ?>" class="widefat code edit-menu-item-icon" name="menu-item-icon[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->icon ); ?>" />
                                            </label>
                                        </p>
	                                <p class="field-description description description-wide">
	                                        <label for="edit-menu-item-description-<?php echo $item_id; ?>">
	                                                <?php _e( 'Description' ); ?><br />
	                                                <textarea id="edit-menu-item-description-<?php echo $item_id; ?>" class="widefat edit-menu-item-description" rows="3" cols="20" name="menu-item-description[<?php echo $item_id; ?>]"><?php echo esc_html( $item->description ); // textarea_escaped ?></textarea>
	                                                <span class="description"><?php _e('The description will be displayed in the menu if the current theme supports it.'); ?></span>
	                                        </label>
	                                </p>
	 
   
	                                <p class="field-move hide-if-no-js description description-wide">
	                                        <label>
	                                                <span><?php _e( 'Move' ); ?></span>
	                                                <a href="#" class="menus-move menus-move-up" data-dir="up"><?php _e( 'Up one' ); ?></a>
	                                                <a href="#" class="menus-move menus-move-down" data-dir="down"><?php _e( 'Down one' ); ?></a>
	                                                <a href="#" class="menus-move menus-move-left" data-dir="left"></a>
	                                                <a href="#" class="menus-move menus-move-right" data-dir="right"></a>
	                                                <a href="#" class="menus-move menus-move-top" data-dir="top"><?php _e( 'To the top' ); ?></a>
	                                        </label>
	                                </p>
	
	                                <div class="menu-item-actions description-wide submitbox">
	                                        <?php if( 'custom' != $item->type && $original_title !== false ) : ?>
	                                                <p class="link-to-original">
	                                                        <?php printf( __('Original: %s'), '<a href="' . esc_attr( $item->url ) . '">' . esc_html( $original_title ) . '</a>' ); ?>
	                                                </p>
	                                        <?php endif; ?>
	                                        <a class="item-delete submitdelete deletion" id="delete-<?php echo $item_id; ?>" href="<?php
	                                        echo wp_nonce_url(
	                                                add_query_arg(
	                                                        array(
	                                                                'action' => 'delete-menu-item',
	                                                                'menu-item' => $item_id,
	                                                        ),
	                                                        admin_url( 'nav-menus.php' )
	                                                ),
	                                                'delete-menu_item_' . $item_id
	                                        ); ?>"><?php _e( 'Remove' ); ?></a> <span class="meta-sep hide-if-no-js"> | </span> <a class="item-cancel submitcancel hide-if-no-js" id="cancel-<?php echo $item_id; ?>" href="<?php echo esc_url( add_query_arg( array( 'edit-menu-item' => $item_id, 'cancel' => time() ), admin_url( 'nav-menus.php' ) ) );
	                                                ?>#menu-item-settings-<?php echo $item_id; ?>"><?php _e('Cancel'); ?></a>
	                                </div>
	
	                                <input class="menu-item-data-db-id" type="hidden" name="menu-item-db-id[<?php echo $item_id; ?>]" value="<?php echo $item_id; ?>" />
	                                <input class="menu-item-data-object-id" type="hidden" name="menu-item-object-id[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->object_id ); ?>" />
	                                <input class="menu-item-data-object" type="hidden" name="menu-item-object[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->object ); ?>" />
	                                <input class="menu-item-data-parent-id" type="hidden" name="menu-item-parent-id[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->menu_item_parent ); ?>" />
	                                <input class="menu-item-data-position" type="hidden" name="menu-item-position[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->menu_order ); ?>" />
	                                <input class="menu-item-data-type" type="hidden" name="menu-item-type[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->type ); ?>" />
	                        </div><!-- .menu-item-settings-->
	                        <ul class="menu-item-transport"></ul>
	                <?php
	                $output .= ob_get_clean();
	        }
	
	} // Walker_Nav_Menu_Edit