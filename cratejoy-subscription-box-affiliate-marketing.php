<?php
/*
Plugin Name: Cratejoy Subscription Box Affiliate Marketing
Plugin URI: https://www.cratejoy.com/affiliates
Description: This plugin adds a custom widget that displays a slideshow of Cratejoy subscription boxes.
Version: 1.0.5
Author: Cratejoy
Author URI: https://www.cratejoy.com/
License: GPL2
*/

namespace Cratejoyboxes_Widget;
use \WP_Widget;

// Prevent direct access to this file
if ( ! defined( 'ABSPATH' ) ) exit;

// Register Cratejoy Boxes Widget widget
add_action( 'widgets_init', function() {
     register_widget( 'Cratejoyboxes_Widget\Cratejoyboxes_Widget' );
});

// Create a simple function to delete our transient
add_action( 'edit_term', function() {
	delete_transient( 'cratejoyboxes' );
});

/**
* Adds Cratejoy Boxes widget
*/
class Cratejoyboxes_Widget extends WP_Widget {

	/**
	* Register widget with WordPress
	*/
	function __construct() {
		parent::__construct(
			'cratejoyboxes_widget', // Base ID
			esc_html__( 'Cratejoy Subscription Box Affiliate Marketing', 'textdomain' ), // Name
            array( 'description' => esc_html__( 'This plugin adds a custom widget that displays a slideshow of Cratejoy subscription boxes.', 'textdomain' ), ), // Args
            array( 'customize_selective_refresh' => true ) // Refresh
		);
	}

	/**
	* Widget Fields
	*/
	private $widget_fields = array(
		array(
			'label' => 'New Arrivals',
			'id' => 'cratejoy_box_new',
			'default' => 'https://www.cratejoy.com/collection/new-arrivals/',
			'type' => 'checkbox',
		),
		array(
			'label' => 'Beauty Subscription Boxes',
			'id' => 'cratejoy_box_beauty',
			'default' => 'https://www.cratejoy.com/category/beauty-fashion-subscription-boxes/',
			'type' => 'checkbox',
		),
		array(
			'label' => 'Book Subscription Boxes',
			'id' => 'cratejoy_box_book',
			'default' => 'https://www.cratejoy.com/category/book-subscription-boxes/',
			'type' => 'checkbox',
		),
		array(
			'label' => 'Boxes for Women',
			'id' => 'cratejoy_box_women',
			'default' => 'https://www.cratejoy.com/category/subscription-boxes-for-women/',
			'type' => 'checkbox',
		),
		array(
			'label' => 'Subscription Boxes for Men',
			'id' => 'cratejoy_box_men',
			'default' => 'https://www.cratejoy.com/category/subscription-boxes-for-men/',
			'type' => 'checkbox',
		),
		array(
			'label' => 'Food & Drink Subscription Boxes',
			'id' => 'cratejoy_box_food-drink',
			'default' => 'https://www.cratejoy.com/category/food-subscription-boxes/',
			'type' => 'checkbox',
		),
		array(
			'label' => 'Geek Subscription Boxes',
			'id' => 'cratejoy_box_geek',
			'default' => 'https://www.cratejoy.com/category/geek-gaming-subscription-boxes/',
			'type' => 'checkbox',
		),
		array(
			'label' => 'Health & Fitness Subscription Boxes',
			'id' => 'cratejoy_box_health',
			'default' => 'https://www.cratejoy.com/category/fitness-health-subscription-boxes/',
			'type' => 'checkbox',
		),
		array(
			'label' => 'Family-Friendly & Kids Subscription Boxes',
			'id' => 'cratejoy_box_family',
			'default' => 'https://www.cratejoy.com/category/family-kids-subscription-boxes/',
			'type' => 'checkbox',
		),
		array(
			'label' => 'Art Subscription Boxes',
			'id' => 'cratejoy_box_art',
			'default' => 'https://www.cratejoy.com/category/art-culture-subscription-boxes/',
			'type' => 'checkbox',
		),
		array(
			'label' => 'Pet Subscription Boxes',
			'id' => 'cratejoy_box_pet',
			'default' => 'https://www.cratejoy.com/category/animals-pets-subscription-boxes/',
			'type' => 'checkbox',
		),
		array(
			'label' => 'Home & Living Subscription Boxes',
			'id' => 'cratejoy_box_home',
			'default' => 'https://www.cratejoy.com/category/home-garden-subscription-boxes/',
			'type' => 'checkbox',
		),
		array(
			'label' => 'Novelty & Unique Subscription Boxes',
			'id' => 'cratejoy_box_novelty',
			'default' => 'https://www.cratejoy.com/category/novelty-subscription-boxes/',
			'type' => 'checkbox',
		),
		array(
			'label' => 'Paste a Cratejoy URL',
			'id' => 'cratejoy_box_custom1',
			'type' => 'text',
		),
		array(
			'label' => 'Paste a Cratejoy URL',
			'id' => 'cratejoy_box_custom2',
			'type' => 'text',
		),
		array(
			'label' => 'Paste a Cratejoy URL',
			'id' => 'cratejoy_box_custom3',
			'type' => 'text',
		),
		array(
			'label' => 'Affiliate ID',
			'id' => 'cratejoy_box_aid',
			'type' => 'text',
		),
	);

	/**
	* Front-end display of widget
	*/
	public function widget( $args, $instance ) {
        
		echo $args['before_widget'];

		// Output widget title
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
        }

        if ( is_active_widget( false, $this->id, $this->id_base, true ) ) {
            wp_enqueue_style( 'cratejoy-box-widget', plugin_dir_url(__FILE__) . 'public/vendor/slick-1.8.1/slick/slick.css', 'parent-stylesheet', '1.0.0' );
            wp_enqueue_style( 'cratejoy-box-widget-theme', plugin_dir_url(__FILE__) . 'public/vendor/slick-1.8.1/slick/slick-theme.css', 'cratejoy-box-widget', '1.0.0' );
			
	        $color = "#333";
	        $custom_css = "
	            .cj-boxes { margin: auto; width: 300px; height: auto; }
				.cj-boxes a, .cj-boxes a:hover, .cj-boxes a:active { box-shadow: none; }
	            .cj-box { outline: none; }
				.cj-box-img-wrapper { width: auto; height: 225px; overflow: hidden; }
				.cj-box-img { object-fit: cover; }
	            .cj-box-title { width: 300px; text-align: center; margin: 0 auto; padding: 15px 0; }
	            .cj-box-description { text-align: center; padding: 0 40px; }
	            .cj-boxes .slick-prev:before, .cj-boxes .slick-next:before { color: $color; }
				.cj-boxes .slick-prev, .cj-boxes .slick-next { top: 122.5px; }
	        ";     
            wp_add_inline_style( 'cratejoy-box-widget-theme', $custom_css );


            wp_enqueue_script( 'cratejoy-box-widget', plugin_dir_url(__FILE__) . 'public/vendor/slick-1.8.1/slick/slick.min.js', array( 'jquery' ), '1.0.0', true );
			
	        $custom_js = "(function($) {
	            jQuery('.cj-boxes').slick({
	                centerMode: true,
	                variableWidth: true,
	                arrows: true,
	                dots: false,
	                fade: false,
					autoplay: true,
					autoplaySpeed: 5000,
	                slidesToShow: 1,
	                slidesToScroll: 1,
	            });
	        })( jQuery );";
			wp_add_inline_script( 'cratejoy-box-widget', $custom_js );
        }
		
        $cratejoy_box_show_box_title = true;
		$cratejoy_box_show_box_desc  = false;
		
		
		// Get any existing copy of our transient data
		if ( false === ( $cratejoyboxes = get_transient( 'cratejoyboxes' ) ) ) {
		    // Create an array of boxes
		    $cratejoyboxes = [];		

			foreach ( $instance as $instance_key => $instance_value ) {
				if ( $instance_key != 'title' && $instance_value ) {
					foreach ( $this->widget_fields as $widget_field ) {
						if ( $instance_key === $widget_field['id'] && isset( $widget_field['default'] ) ) {
							$cratejoyboxes[] = $this->get_cratejoy_boxes($widget_field['default']);
						}
					}
				}
			}
		
			if ( $instance['cratejoy_box_custom1'] ) {
				$cratejoyboxes[] = $this->get_cratejoy_boxes($instance['cratejoy_box_custom1'] );
			}

			if ( $instance['cratejoy_box_custom2'] ) {
				$cratejoyboxes[] = $this->get_cratejoy_boxes($instance['cratejoy_box_custom2']);
			}

			if ( $instance['cratejoy_box_custom3'] ) {
				$cratejoyboxes[] = $this->get_cratejoy_boxes($instance['cratejoy_box_custom3']);
			}
		}
		
		set_transient( 'cratejoyboxes', $cratejoyboxes, 12 * HOUR_IN_SECONDS );
		
        echo '<div class="cj-boxes">';
        foreach ($cratejoyboxes as $boxes_key => $boxes) {
			foreach ($boxes as $box) {
				if ( $instance['cratejoy_box_aid'] ) {
					$link = '<a href="https://cratejoy.evyy.net/c/' . $instance['cratejoy_box_aid'] . '/559913/4453?u=' . $box['cratejoy_box_link'] . '" target="_blank">';
				} else {
					$link = '<a href="' . $box['cratejoy_box_link'] . '" target="_blank">';
				}
				$link_close = '</a>';
				
				echo $link . '<div class="cj-box">';
					if ( $box['cratejoy_box_img'] ) {
						echo '<div class="cj-box-img-wrapper"><img src="' . $box['cratejoy_box_img'] . '" class="cj-box-image"></div>';
					} else {
						echo '<div class="cj-box-img-wrapper">MISSING IMAGE</div>';
					}
	                
	                if ( $cratejoy_box_show_box_title ) {
	                    echo '<h3 class="cj-box-title">' . $box['cratejoy_box_title'] . '</h3>';
	                }
	                if ( $cratejoy_box_show_box_desc ) {
	                    echo '<p class="cj-box-description">' . $box['cratejoy_box_desc'] . '</p>';
	                }
	            echo '</div>' . $link_close;
			}
        }
        echo '</div>';
		
		echo $args['after_widget'];
	}

	/**
	* Back-end widget fields
	*/
	public function field_generator( $instance ) {
		$output = '';
		foreach ( $this->widget_fields as $widget_field ) {
			$widget_value = ! empty( $instance[$widget_field['id']] ) ? $instance[$widget_field['id']] : '';
			switch ( $widget_field['type'] ) {
				case 'checkbox':
					$output .= '<p>';
					$output .= '<input class="checkbox" type="checkbox" ';
					if ( isset( $widget_value ) ) {
						$output .= checked( $widget_value, true, false );
					}
					$output .= ' id="' . esc_attr( $this->get_field_id( $widget_field['id'] ) ) . '" name="' . esc_attr( $this->get_field_id( $widget_field['id'] ) ) . '" value="1">';
					$output .= '<label for="' . esc_attr( $this->get_field_id( $widget_field['id'] ) ) . '">' . esc_attr( $widget_field['label'], 'textdomain' ) . '</label>';
					$output .= '</p>';
					break;
				default:
					$output .= '<p>';
					$output .= '<label for="' . esc_attr( $this->get_field_id( $widget_field['id'] ) ) . '">' . esc_attr( $widget_field['label'], 'textdomain' ) . ':</label> ';
					$output .= '<input class="widefat" id="' . esc_attr( $this->get_field_id( $widget_field['id'] ) ) . '" name="' . esc_attr( $this->get_field_name( $widget_field['id'] ) ) . '" type="'.$widget_field['type'] . '" value="';
					if ( isset( $widget_value ) ) {
						$output .= esc_attr( $widget_value );
					}
					$output .= '">';
					$output .= '</p>';
			}
		}
		echo $output;
	}

	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( '', 'textdomain' );
		?>
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'textdomain' ); ?></label>
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<?php
		$this->field_generator( $instance );
	}

	/**
	* Sanitize widget form values as they are saved
	*/
	public function update( $new_instance, $old_instance ) {
		delete_transient( 'cratejoyboxes' );
		
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		foreach ( $this->widget_fields as $widget_field ) {
			switch ( $widget_field['type'] ) {
				case 'checkbox':
					$instance[$widget_field['id']] = $_POST[$this->get_field_id( $widget_field['id'] )];
					break;
				default:
					$instance[$widget_field['id']] = ( ! empty( $new_instance[$widget_field['id']] ) ) ? strip_tags( $new_instance[$widget_field['id']] ) : '';
			}
		}
		return $instance;
	}
	
	/**
	* Parse the Cratejoy pages
	*/
    private function get_cratejoy_boxes ( $url ) {
	    // It wasn't there, so regenerate the data and save the transient
		$cratejoyboxes = [];
		$url_arr = explode( '/', $url );
		$title   = '';
		$desc    = '';
		$img     = '';
		$link    = '';
		$str     = '';

		$str = $this->get_response( $url );
	    
		if ( ! function_exists( 'simple_html_dom' ) ) {
			require_once plugin_dir_path( __FILE__ ) . 'lib/simple_html_dom.php';
		    $html = new simple_html_dom();
			$html->load( $str );
		}

		if ( ! empty( $html ) ) {
			if ( $url_arr[3] === 'subscription-box' ) {
				$title = ( $html->find( 'meta[property=og:title]', 0 )->getAttribute( 'content' ) ? $html->find( 'meta[property=og:title]', 0 )->getAttribute( 'content' ) : '' );
				$desc  = ( $html->find( 'meta[property=og:description]', 0 )->getAttribute( 'content' ) ? $html->find( 'meta[property=og:description]', 0 )->getAttribute( 'content' ) : '' );
				$img   = ( $html->find( 'meta[property=og:image]', 0 )->getAttribute( 'content' ) ? $html->find( 'meta[property=og:image]', 0 )->getAttribute( 'content' ) : '' );
				$link  = ( $html->find( 'link[rel="canonical"]', 0 )->href ? $html->find( 'link[rel="canonical"]', 0 )->href : '' );

				$cratejoyboxes[] = [
					'cratejoy_box_title' => ( $title ? $title : '' ),
					'cratejoy_box_desc'  => ( $desc ? $desc : '' ),
					'cratejoy_box_img'   => ( $img ? $img : '' ),
					'cratejoy_box_link'  => ( $link ? $link : '' )
				];
			} else {
				if ( $html->find( 'div.listingResults-row') ) {
					foreach ( $html->find( 'div.listing-box' ) as $box ) {            
						$title = ( trim( $box->find( 'h5.listing-box-header', 0 )->plaintext ) ? trim( $box->find( 'h5.listing-box-header', 0 )->plaintext ) : '' );
						$desc  = ( $box->find( 'div.product-brief-desc', 0 )->plaintext ? trim( $box->find( 'div.product-brief-desc', 0 )->plaintext ) : '' );
						$img   = ( $box->find( 'img.listing-box-image', 0 )->getAttribute( 'data-src' ) ? $box->find( 'img.listing-box-image', 0 )->getAttribute( 'data-src' ) : '' );
						$link  = ( $box->find( 'a.normal-link', 0 )->getAttribute( 'href' ) ? 'https://www.cratejoy.com' . $box->find( 'a.normal-link', 0 )->getAttribute( 'href' )  : '' );
						
						$cratejoyboxes[] = [
							'cratejoy_box_title' => ( $title ? $title : '' ),
							'cratejoy_box_desc'  => ( $desc ? $desc : '' ),
							'cratejoy_box_img'   => ( $img ? $img : '' ),
							'cratejoy_box_link'  => ( $link ? $link : '' )
						];
					}
				}
			}
		}

		return $cratejoyboxes;
    }
	
	/**
	 * Defines the function used to initial the cURL library.
	 *
	 * @param  string  $url        To URL to which the request is being made
	 * @return string  $response   The response, if available; otherwise, null
	 */
	private function curl( $url ) {

		$curl = curl_init( $url );

		curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $curl, CURLOPT_HEADER, 0 );
		curl_setopt( $curl, CURLOPT_USERAGENT, '' );
		curl_setopt( $curl, CURLOPT_TIMEOUT, 10 );

		$response = curl_exec( $curl );
		if( 0 !== curl_errno( $curl ) || 200 !== curl_getinfo( $curl, CURLINFO_HTTP_CODE ) ) {
			$response = null;
		} // end if
		curl_close( $curl );

		return $response;

	} // end curl

	/**
	 * Retrieves the response from the specified URL using one of PHP's outbound request facilities.
	 *
	 * @params	$url	The URL of the feed to retrieve.
	 * @returns		The response from the URL; null if empty.
	 */
	private function request_data( $url ) {

		$response = null;

		// First, we try to use wp_remote_get
		$response = wp_remote_get( $url );
		if( is_wp_error( $response ) ) {

			// If that doesn't work, then we'll try file_get_contents
			$response = file_get_contents( $url );
			if( false == $response ) {

				// And if that doesn't work, then we'll try curl
				$response = $this->curl( $url );
				if( null == $response ) {
					$response = 0;
				} // end if/else

			} // end if

		} // end if

		// If the response is an array, it's coming from wp_remote_get,
		// so we just want to capture to the body index for json_decode.
		if( is_array( $response ) ) {
			$response = $response['body'];
		} // end if/else

		return $response;

	} // end request_data

	/**
	 * Retrieves the response from the specified URL using one of PHP's outbound request facilities.
	 *
	 * @params	$url	The URL of the feed to retrieve.
	 * @returns			The response from the URL; null if empty.
	 */
	private function get_response( $url ) {

		$response = null;

		// First, we try to use wp_remote_get
		$response = wp_remote_get( $url );
		if( is_wp_error( $response ) ) {

			// If that doesn't work, then we'll try file_get_contents
			$response = file_get_contents( $url );
			if( false == $response ) {

				// And if that doesn't work, then we'll try curl
				$response = $this->curl( $url );
				if( null == $response ) {
					$response = 0;
				} // end if/else

			} // end if

		} // end if

		// If the response is an array, it's coming from wp_remote_get,
		// so we just want to capture to the body index for json_decode.
		if( is_array( $response ) ) {
			$response = $response['body'];
		} // end if/else

		return $response;

	} // end get_response
	
} // class Cratejoyboxeswidget_Widget

