<?php
/**
* The template for the search form in header
*
*/
global $options;
?>


    <h2 class="screen-reader-text"><a name="searchform"><?php _e("Search", 'blackpirates'); ?></a></h2>
    <div class="searchwrap fa fa-search 2x">
        <form method="get" class="searchform" action="<?php echo blackpirates_esc_url(home_url( '/' ))?>">
                <label class="screen-reader-text" for="searchheader"><?php _e("Search for", 'blackpirates'); ?>:</label>
                <input type="text" value="<?php the_search_query(); ?>" name="s" id="searchheader" 
                    placeholder="<?php _e("Enter search term", 'blackpirates'); ?>"  
                    onfocus="if(this.value=='<?php _e("Enter search term", 'blackpirates'); ?>')this.value='';" onblur="if(this.value=='')this.value='<?php _e("Enter search term", 'blackpirates'); ?>';" />
                <input type="submit" class="fa fa-search searchsubmit" value="<?php _e("Search", 'blackpirates'); ?>" />

        </form>
    </div>
   
