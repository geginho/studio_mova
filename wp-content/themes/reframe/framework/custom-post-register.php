<?php

///// WORKS REGISTER

class WPSE_Filter_Storage
{
    /**
     * Filled by __construct(). Used by __call().
     *
     * @type mixed Any type you need.
     */
    protected $values;

    /**
     * Stores the values for later use.
     *
     * @param  mixed $values
     * @return void
     */
    public function __construct( $values )
    {
        $this->values = $values;
    }

    /**
     * Catches all function calls except __construct().
     *
     * Be aware: Even if the function is called with just one string as an
     * argument it will be sent as an array.
     *
     * @param  string $callback Function name
     * @param  array  $arguments
     * @return mixed
     */
    public function __call( $callback, $arguments )
    {
        if ( is_callable( $callback ) )
        {
            return call_user_func( $callback, $arguments, $this->values );
        }
    }
}




if ( ! function_exists( 'md_works_edit_columns' ) ) {		 
	function md_works_edit_columns( $columns, $type) {
	  
	  $columns = array(
		"cb" => "<input type=\"checkbox\" />",
		"title" => __( "Title", 'dronetv' ),
		"description" => __( "Description", 'dronetv' ),
		$type."-categories" => __( "Fields", 'dronetv' ),
		//"work_tags" => __( "Tags", 'dronetv' ),
		"date" => __( "Date", 'dronetv' )
	  );
	 
	  return $columns;
	  
	}
}




if ( ! function_exists( 'md_works_custom_columns' ) ) {		
	function md_works_custom_columns( $column) {
	  
	  global $post;
	 
	  switch ($column) {
		case "description":
		  the_excerpt();
		break;
	  }
	  
		if(strpos($column,'-categories')!==false) {
		   echo get_the_term_list( $post->ID, $column, '', ', ','' );
		}
		
	  
	}
}





if ( ! function_exists( 'md_works' ) ) {	
	function md_works() {
		 
		global $custompostvals;
		 
		$customtypes = of_get_option('md_custom_posts');
		
		if(!is_array($customtypes)) { 
		
			$customtypes['default']['title'] = $custompostvals['title']; // post name / slug
			$customtypes['default']['singular'] = $custompostvals['singular']; // single name
			$customtypes['default']['plural'] = $custompostvals['plural']; // name
			$customtypes['default']['slug'] = $custompostvals['slug']; // slug
			
			$customtypes['default']['categoryname'] = $custompostvals['categoryname']; // category name
			$customtypes['default']['categorytitle'] = $custompostvals['categorytitle']; // slug
			$customtypes['default']['categorysingletitle'] = $custompostvals['categorysingletitle']; // slug
			$customtypes['default']['categoryslug'] = $custompostvals['categoryslug']; // slug
			$customtypes['default']['color'] = $custompostvals['color']; // category name
			$customtypes['default']['withbg'] = $custompostvals['withbg']; // slug
			$customtypes['default']['dropdown'] = $custompostvals['dropdown']; // slug
			$customtypes['default']['dropdowntitle'] = $custompostvals['dropdowntitle']; // slug
			
			
		}
		
		
		
		foreach($customtypes as $k => $foo) { 
			
			
			$name_vars[0] = $foo['title']; // post name / slug
			$name_vars[1] = $foo['singular']; // single name
			$name_vars[2] = $foo['plural']; // name
			$name_vars[3] = $foo['slug']; // slug
			
			$name_vars[4] = $foo['categoryname']; // category name
			$name_vars[5] = $foo['categorytitle']; // slug
			$name_vars[6] = $foo['categorysingletitle']; // slug
			$name_vars[7] = $foo['categoryslug']; // slug
			
			
			if($name_vars[3]!='') {
				$slugname = $name_vars[3];
			}else{
				$slugname = strtolower($name_vars[0]);
			}
			
			
			$labels = array(
				'name' => _x( $name_vars[2], "Post type name", 'dronetv' ),
				'singular_name' => _x( $name_vars[1], "Post type singular name", 'dronetv' ),
				'add_new' => _x( "Add New ".$name_vars[1], "post item", 'dronetv' ),
				'add_new_item' => __( "Add New ".$name_vars[1], 'dronetv' ),
				'edit_item' => __( "Edit ".$name_vars[1], 'dronetv' ),
				'new_item' => __( "New ".$name_vars[1], 'dronetv' ),
				'view_item' => __( "View ".$name_vars[1], 'dronetv' ),
				'search_items' => __( "Search ".$name_vars[1], 'dronetv' ),
				'not_found' =>  __( "Not found", 'dronetv' ),
				'not_found_in_trash' => __( "Trash is empty", 'dronetv' ),
				'parent_item_colon' => ''
			);
			
			register_post_type( $name_vars[0] , array(
				'label'=>_x($name_vars[2],'Type','dronetv'),
				'description'=>__('Special type of post for creating '.$name_vars[1],'dronetv'),
				'labels' => $labels,
				'public' => true,
				'menu_position' => 5,
				'show_ui' => true,
				'show_in_menu' => true,
				'publicly_queryable' => true,
				'exclude_from_search' => false,
				'query_var' => true,
				'menu_icon'=>get_template_directory_uri() . '/framework/options/assets/images/northeme_custom.png',
				'rewrite' => array('slug' => $slugname),
				'capability_type' => 'post',
				'hierarchical' => false,
				'supports' => array( 'title', 'editor','thumbnail','excerpt','comments')
				)
			  ); 
		
				register_taxonomy( $name_vars[0]."-categories", 
					array( 	$name_vars[0] ), 
					array( 	"hierarchical" => true,
							"labels" => array('name'=>$name_vars[4],'add_new_item'=>$name_vars[5]), 
							"singular_label" => __( $name_vars[6], 'dronetv' ), 
							"show_ui"=>true,
							"exclude_from_search" => false,
							"show_in_nav_menus"=>true,
							"rewrite" => array( 'slug' => $name_vars[7], // This controls the base slug that will display before each term 
											'with_front' => false)
						 ) 
				);

				$my_extra_param = new WPSE_Filter_Storage($name_vars[0]);
					
				add_filter( "manage_edit-".$name_vars[0]."_columns",array($my_extra_param,"md_works_edit_columns"));
				add_action( "manage_".$name_vars[0]."_posts_custom_column", "md_works_custom_columns");


		}
		
		if(isset($_GET['flush'])) { 
			flush_rewrite_rules();
		}
	
		//$wp_rewrite->flush_rules();
		//flush_rewrite_rules();
	}
}



// Custom post type for works
add_action( 'init', 'md_works' );


?>