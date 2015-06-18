<?php

// Buttons  
$col_shortcodes['button'] = array(
	'params' => array(
		'url' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Button URL', 'framework'),
			'desc' => __('', 'framework')
		),
		'target' => array(
			'std' => '',
			'type' => 'select',
			'label' => __('Target', 'framework'),
			'desc' => __('', 'framework'),
			'options' => array(
				'_self' => 'Open in same page',
				'_blank' => 'Open in new page'	
			)
		),
		'size' => array(
			'std' => '',
			'type' => 'select',
			'label' => __('Size', 'framework'),
			'desc' => __('', 'framework'),
			'options' => array(
				'' => 'Normal',
				'mini' => 'Mini',
				'large' => 'Large',
			)
		),
		'color' => array(
			'type' => 'select',
			'label' => __('Button\'s Style', 'framework'),
			'desc' => __('', 'framework'),
			'options' => array(
				'orange' => 'Orange',
				'blue' => 'Blue',
				'red' => 'Red',
				'black' => 'Black',
				'gray' => 'Gray'			
			)
		),		
		'content' => array(
			'std' => 'Button Text',
			'type' => 'text',
			'label' => __('Button\'s Text', 'framework'),
			'desc' => __('', 'framework'),
		)
	),
	'shortcode' => '[button url="{{url}}" color="{{color}}" size="{{size}}" target="{{target}}" name="{{content}}"]',
	'popup_title' => __('Insert Button', 'framework')
);


// GOOGLE MAP  
$col_shortcodes['gmap'] = array(
	'params' => array(
		'address' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Address', 'framework'),
			'desc' => __('Your address', 'framework')
		),
		'width' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Width', 'framework'),
			'desc' => __('It can be specified as px or %. Default value is 100%.', 'framework')
		),
		'height' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Height', 'framework'),
			'desc' => __('It can be specified as px or %. Default value is 250px.', 'framework')
		),
		'zoom' => array(
			'type' => 'select',
			'label' => __('Zoom', 'framework'),
			'desc' => __('Zoom value for the map. Default is 14', 'framework'),
			'options' => array(
				'5' => '5',
				'6' => '6',
				'7' => '7',
				'8' => '8',
				'9' => '9',
				'10' => '10',
				'11' => '11',
				'12' => '12',
				'13' => '13',
				'14' => '14',
				'15' => '15',
				'16' => '16',
				'17' => '17',
				'18' => '18',
				'19' => '19'
			)
		)
	),
	'shortcode' => '[md_google_map address="{{address}}" width="{{width}}" height="{{height}}" zoom="{{zoom}}"]',
	'popup_title' => __('Insert Google Map', 'framework')
);



// Contact Form  

$col_shortcodes['contactform'] = array(
	'params' => array(
		'myemail' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Email', 'framework'),
			'desc' => __('Enter your email address', 'framework')
		),
		'title' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Form Title', 'framework'),
			'desc' => __('Contact form title. Default : Contact Form', 'framework')
		),
		'success' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Success Message', 'framework'),
			'desc' => __('', 'framework')
		),
		'failure' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Failure Message', 'framework'),
			'desc' => __('', 'framework')
		)
	),
    'no_preview' => true,
	'shortcode' => '[md_contact_form myemail="{{myemail}}" title="{{title}}" success="{{success}}" failure="{{failure}}"]',
	'popup_title' => __('Insert Contact Form', 'framework')
);




// Alerts  
$col_shortcodes['alert'] = array(
	'params' => array(
		'color' => array(
			'type' => 'select',
			'label' => __('Color', 'framework'),
			'desc' => __('', 'framework'),
			'options' => array(
				'' => 'Gray',
				'blue' => 'Blue',
				'red' => 'Red',
				'orange' => 'Orange',
				'green' => 'Green'
			)
		),
		'content' => array(
			'std' => 'Your Alert!',
			'type' => 'textarea',
			'label' => __('Text', 'framework'),
			'desc' => __('', 'framework'),
		)
		
	),
	'shortcode' => '[alert color="{{color}}"] {{content}} [/alert]',
	'popup_title' => __('Insert Alert', 'framework')
);


// Tabs
$col_shortcodes['tabs'] = array(
    'params' => array(),
    'no_preview' => true,
    'shortcode' => '[tabs] {{child_shortcode}}  [/tabs]',
    'popup_title' => __('Insert Tabs', 'framework'),
    
    'child_shortcode' => array(
        'params' => array(
            'title' => array(
                'std' => '',
                'type' => 'text',
                'label' => __('Title', 'framework'),
                'desc' => __('', 'framework'),
            ),
            'content' => array(
                'std' => '',
                'type' => 'textarea',
                'label' => __('Content', 'framework'),
                'desc' => __('', 'framework')
            )
        ),
        'shortcode' => '[tab title="{{title}}"] {{content}} [/tab]',
        'clone_button' => __('Add New Tab', 'framework')
    )
);


// Slider
$col_shortcodes['slider'] = array(
    'params' => array(),
    'no_preview' => true,
    'shortcode' => '[slider] {{child_shortcode}}  [/slider]',
    'popup_title' => __('Insert Slider', 'framework'),
    
    'child_shortcode' => array(
        'params' => array(
			'type' => array(
				'type' => 'select',
				'label' => __('Column Type', 'framework'),
				'desc' => __('Url, target and caption values will be ignored on "video" slide type', 'framework'),
				'options' => array(
					'image' => 'Image',
					'video' => 'Video',
				)
			),
			'content' => array(
				'std' => '',
				'type' => 'textarea',
				'label' => __('Image URL or Video Embed Code', 'framework'),
				'desc' => __('This is content of your slider. You might prefer to use image URL or video embed code from youtube, vimeo etc.', 'framework'),
			),
            'url' => array(
                'std' => '',
                'type' => 'text',
                'label' => __('Url', 'framework'),
                'desc' => __('', 'framework'),
            ),
			'target' => array(
				'std' => '',
				'type' => 'select',
				'label' => __('Target', 'framework'),
				'desc' => __('', 'framework'),
				'options' => array(
					'_self' => 'Open in same page',
					'_blank' => 'Open in new page'	
				)
			),
			'caption' => array(
				'std' => '',
				'type' => 'textarea',
				'label' => __('Caption', 'framework'),
				'desc' => __('', 'framework'),
			)
        ),
        'shortcode' => '[slide type="{{type}}" url="{{url}}" target="{{target}}" caption="{{caption}}"] {{content}} [/slide]',
        'clone_button' => __('Add New Slide', 'framework')
    )
);


// Gallery
$col_shortcodes['gallery'] = array(
    'params' => array(),
    'no_preview' => true,
    'shortcode' => '[nor_gallery] {{child_shortcode}}  [/nor_gallery]',
    'popup_title' => __('Insert Gallery', 'framework'),
    
    'child_shortcode' => array(
        'params' => array(
            'title' => array(
                'std' => '',
                'type' => 'text',
                'label' => __('Title', 'framework'),
                'desc' => __('', 'framework'),
            ),
			'type' => array(
				'type' => 'select',
				'label' => __('Column Type', 'framework'),
				'desc' => __('Url, target and caption values will be ignored for video slide', 'framework'),
				'options' => array(
					'image' => 'Image',
					'video' => 'Video',
				)
			),
			'content' => array(
				'std' => '',
				'type' => 'textarea',
				'label' => __('Image URL or Video Embed Code', 'framework'),
				'desc' => __('This is content of your gallery. You might prefer to use image URL or video URL from Youtube or Vimeo', 'framework'),
			),
			'caption' => array(
				'std' => '',
				'type' => 'textarea',
				'label' => __('Caption', 'framework'),
				'desc' => __('', 'framework'),
			)
        ),
        'shortcode' => '[nor_gallery_item type="{{type}}" title="{{title}}" caption="{{caption}}"] {{content}} [/nor_gallery_item]',
        'clone_button' => __('Add New Slide', 'framework')
    )
);


// Columns
$col_shortcodes['columns'] = array(
	'params' => array(),
	'shortcode' => ' {{child_shortcode}} ', // as there is no wrapper shortcode
	'popup_title' => __('Insert Columns', 'framework'),
	'no_preview' => true,
	
	'child_shortcode' => array(
		'params' => array(
			'column' => array(
				'type' => 'select',
				'label' => __('Column Type', 'framework'),
				'desc' => __('Select column type. This theme uses sixteen columns grid system', 'framework'),
				'options' => array(
					'one_third' => 'One Third',
					'two_third' => 'Two Third',
					'one_col' => 'One',
					'two_col' => 'Two',
					'three_col' => 'Three',
					'four_col' => 'Four',
					'five_col' => 'Five',
					'six_col' => 'Six',
					'seven_col' => 'Seven',
					'eight_col' => 'Eight',
					'nine_col' => 'Nine',
					'ten_col' => 'Ten',
					'eleven_col' => 'Eleven',
					'twelve_col' => 'Twelve',
					'thirteen_col' => 'Thirteen',
					'fourteen_col' => 'Fourteen',
					'fifteen_col' => 'Fifteen',
					'sixteen_col' => 'Sixteen'
				)
			),
			'content' => array(
				'std' => '',
				'type' => 'textarea',
				'label' => __('Column Content', 'framework'),
				'desc' => __('', 'framework'),
			),
			'pos' => array(
			'type' => 'select',
			'label' => __('Position in the row', 'framework'),
			'desc' => __('This option helps to remove margins of the first and last columns in order to prevent the collapse. If the column is not the first or last in the row, you should leave it as default', 'framework'),
			'options' => array(
					'0' => 'Default',
					'first' => 'First',
					'last' => 'Last',
				)
			)
		),
		'shortcode' => '[{{column}} pos="{{pos}}"] {{content}} [/{{column}}] ',
		'clone_button' => __('Add Column', 'framework')
	)
);





// Icons  
$col_shortcodes['icons'] = array(
	'params' => array(
		'name' =>  array(
			'std' => '',
			'type' => 'text',
			'label' => __('Icon Name', 'framework'),
			'desc' => __('Enter your icon name. E.g. : icon-remove <br>To see complete icon list : <a href="http://fortawesome.github.io/Font-Awesome/3.2.1/icons/" target="_blank">http://fortawesome.github.io/Font-Awesome/3.2.1/icons/</a>', 'framework')
		),
			'size' => array(
			'type' => 'select',
			'label' => __('Size', 'framework'),
			'desc' => __('', 'framework'),
			'options' => array(
					'' => 'Default',
					'icon-large' => 'Large',
					'icon-2x' => '2x',
					'icon-3x' => '3x',
					'icon-4x' => '4x',
				)
			)
		
	),
	'shortcode' => '[icon name="{{name}}" size="{{size}}"]',
	'popup_title' => __('Insert Icon', 'framework')
);



?>