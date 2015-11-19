<?php

/* 
 * Default Constants and values
 */
$defaultoptions = array(
    'js-version'		    => '1.0',
    'optionpage-tab-default'	    => 'website',
    'content-width'		    => 770,
    'breadcrumb_root'			=> __('Start page', 'blackpirates'),
    'breadcrumb_delimiter'		=> ' <span>/</span> ',
    'breadcrumb_beforehtml'		=> '<span class="active">', // '<span class="current">'; // tag before the current crumb
    'breadcrumb_afterhtml'		=> '</span>',
    'breadcrumb_uselastcat'		=> true,
    'breadcrumb_withtitle'		=> false,
    
); 


    
  
  
$default_header_logos = array(
    'blackpirates' => array(
	    'url'           => '%s/img/logo-fau.png',
	    'thumbnail_url' => '%s/img/logo-fau.png',
	    'description'   => _x( 'FAU', 'Offizielles FAU-Logo', 'blackpirates' )
    ),
  /*    'fak-med' => array(
	    'url'           => '%s/img/logo-fak-med.png',
	    'thumbnail_url' => '%s/img/logo-fak-med.png',
	    'description'   => _x( 'FAKMED', 'Offizielles Logo der Medizin', 'blackpirates' )
    ),
  'fak-nat' => array(
	    'url'           => '%s/img/logo-fak-nat.png',
	    'thumbnail_url' => '%s/img/logo-fak-nat.png',
	    'description'   => _x( 'FAKNAT', 'Offizielles Logo der Naturwissenschaft', 'blackpirates' )
    ),
    'fak-phil' => array(
	    'url'           => '%s/img/logo-fak-phil.png',
	    'thumbnail_url' => '%s/img/logo-fak-phil.png',
	    'description'   => _x( 'FAKPHIL', 'Offizielles Logo der Philosophischen Fakultät', 'blackpirates' )
    ),
    'fak-rechtswiwi' => array(
	    'url'           => '%s/img/logo-fak-rechtswiwi.png',
	    'thumbnail_url' => '%s/img/logo-fak-rechtswiwi.png',
	    'description'   => _x( 'FAKRECHTSWIWI', 'Offizielles Logo der Rechts- und Wirtschaftswissenschaftlichen Fakultät', 'blackpirates' )
    ),
    'fak-tech' => array(
	    'url'           => '%s/img/logo-fak-tech.png',
	    'thumbnail_url' => '%s/img/logo-fak-tech.png',
	    'description'   => _x( 'FAKTECH', 'Offizielles Logo der Technischen Fakultät', 'blackpirates' )
    ) */
);

 $categories=get_categories(array('orderby' => 'name','order' => 'ASC'));
 foreach($categories as $category) {
     if (!is_wp_error( $category )) {
	$currentcatliste[$category->cat_ID] = $category->name.' ('.$category->count.' '.__('Einträge','blackpirates').')';
     }
 }        

$setoptions = array(
    'blackpirates_theme_options'   => array(
       
       'website'   => array(
           'tabtitle'   => __('Misc Options', 'blackpirates'),
           'fields' => array(
	      
	       
	        'breadcrumb'  => array(
		    'type'    => 'section',
		    'title'   => __( 'Breadcrumb', 'blackpirates' ),                      
		),
		'breadcrumb_root'	 => array(
		    'type'    => 'text',
		    'title'   => __( 'Titel for Startpage', 'blackpirates' ),
		    'label'   => __( 'Defines which text shall be displayed as a first page of the site', 'blackpirates' ),               
		    'default' => $defaultoptions['breadcrumb_root'],
		    'parent'  => 'breadcrumb'
		), 
		'breadcrumb_withtitle'	  => array(
		    'type'    => 'bool',
		    'title'   => __( 'Website-Titel', 'blackpirates' ),
		    'label'   => __( 'Zeige den Website-Titel oberhalb der Breadcrumb', 'blackpirates' ),                
		    'default' => $defaultoptions['breadcrumb_withtitle'],
		    'parent'  => 'breadcrumb'
		),   
          )
       ),
            
    )
);
	       