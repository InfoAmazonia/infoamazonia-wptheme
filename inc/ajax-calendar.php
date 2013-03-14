<?php
/*
Plugin Name: AJAX Calendar
Plugin URI: http://urbangiraffe.com/plugins/ajax-calendar/
Description: A version of the WordPress calendar that uses AJAX to allow the user to step through the months without updating the page. 
Version: 2.5.1
Author: John Godley
Author URI: http://urbangiraffe.com
*/

class AJAX_Calendar_Widget extends WP_Widget {
	var $category_ids = array();

	function AJAX_Calendar_Widget() {
		$widget_ops  = array( 'classname' => 'ajax_calendar_widget', 'description' => __( 'AJAX Powered Calendar', 'ajax-calendar' ) );
		$control_ops = array( 'width' => 300, 'height' => 300 );

		$this->WP_Widget( 'ajax-calendar', __( 'AJAX Calendar', 'ajax-calendar' ), $widget_ops, $control_ops );

		add_action( 'template_redirect', array( &$this, 'template_redirect' ) );
	}
	
	function template_redirect() {
		if ( is_date() && isset( $_GET['ajax'] ) && $_GET['ajax'] == 'true' ) {
			$settings = $this->get_settings();
			$settings = $settings[$this->number];
			
			$instance     = wp_parse_args( $settings, array( 'title' => __( 'AJAX Calendar', 'ajax-calendar' ), 'category_id' => '' ) );
			$this->category_ids = array_filter( explode( ',', $instance['category_id'] ) );
			
			echo $this->get_calendar();
			die();
		}
	}
	
	/**
	 * Display the widget
	 *
	 * @param string $args Widget arguments
	 * @param string $instance Widget instance
	 * @return void
	 **/
	function widget( $args, $instance ) {
		extract( $args );
	
		$instance     = wp_parse_args( (array)$instance, array( 'title' => __( 'AJAX Calendar', 'ajax-calendar' ), 'category_id' => '' ) );
		$category_id  = $instance['category_id'];

		$this->category_ids = array_filter( explode( ',', $category_id ) );
		
		echo $before_widget;
	
		echo $this->get_calendar();

		// MicroAJAX: http://www.blackmac.de/index.php?/archives/31-Smallest-JavaScript-AJAX-library-ever!.html
?>
<script type="text/javascript">
function show_micro_ajax(response){document.getElementById('infoamazonia-calendar').parentNode.innerHTML=response;}
function microAjax(url,cF){this.bF=function(caller,object){return function(){return caller.apply(object,new Array(object));}};
this.sC=function(object){if(this.r.readyState==4){this.cF(this.r.responseText);}};
this.gR=function(){if(window.ActiveXObject)
return new ActiveXObject('Microsoft.XMLHTTP');else if(window.XMLHttpRequest)
return new XMLHttpRequest();else return false;};
if(arguments[2])this.pb=arguments[2];else this.pb="";this.cF=cF;this.url=url;this.r=this.gR();if(this.r){this.r.onreadystatechange=this.bF(this.sC,this);if(this.pb!=""){this.r.open("POST",url,true);this.r.setRequestHeader('Content-type','application/x-www-form-urlencoded');this.r.setRequestHeader('Connection','close');}else{this.r.open("GET",url,true);}
this.r.send(this.pb);}}
</script>
<?php
		// After
		echo $after_widget;
	}
	
	function get_calendar() {
		global $wpdb, $m, $monthnum, $year, $wp_locale, $posts;

		$text = '<div id="infoamazonia-calendar"><h3>' . __('Stories calendar', 'infoamazonia') . '</h3>';


		add_filter( 'query', array( &$this, 'modify_calendar_query' ) );
		
		$text .= get_calendar( true, false );
		
		remove_filter( 'query', array( &$this, 'modify_calendar_query' ) );

		$text = str_replace('<caption>', '<caption><a href="' . get_month_link($year, $monthnum) . '">', $text);
		$text = str_replace('</caption>', '</a></caption>', $text);		
		$text = str_replace( '<td colspan="3" id="next"><a', '<td colspan="3" id="next"><a onclick="microAjax(this.href + \'?ajax=true\',show_micro_ajax); return false"', $text );
		$text = str_replace( '<td colspan="3" id="prev"><a', '<td colspan="3" id="prev"><a onclick="microAjax(this.href + \'?ajax=true\',show_micro_ajax); return false"', $text );
		$text .= '</div>';
		return $text;
	}
		
	function modify_calendar_query( $query ) {
		if ( !empty( $this->category_ids ) ) {
			global $wpdb;
			
			$query = str_replace( 'WHERE', "LEFT JOIN {$wpdb->prefix}term_relationships ON {$wpdb->prefix}posts.ID = {$wpdb->prefix}term_relationships.object_id INNER JOIN {$wpdb->prefix}term_taxonomy ON ({$wpdb->prefix}term_relationships.term_taxonomy_id = {$wpdb->prefix}term_taxonomy.term_taxonomy_id AND {$wpdb->prefix}term_taxonomy.taxonomy='category') WHERE", $query );
			if ( strpos( $query, 'ORDER' ) !== false )
				$query = str_replace( "ORDER", "AND {$wpdb->prefix}term_taxonomy.term_id IN (".implode (',', $this->category_ids ).') ORDER', $query );
			else
				$query .= "AND {$wpdb->prefix}term_taxonomy.term_id IN (".implode (',', $this->category_ids ).')';
		}

		return $query;
	}
	
	/**
	 * Display config interface
	 *
	 * @param string $instance Widget instance
	 * @return void
	 **/
	function form( $instance ) {
		$instance = wp_parse_args( (array)$instance, array( 'title' => __( 'AJAX Calendar', 'ajax-calendar' ), 'category_id' => '' ) );

		$category_id  = $instance['category_id'];

		?>
<p><label for="<?php echo $this->get_field_id( 'category_id' ); ?>"><?php _e( 'Category IDs:', 'ajax-calendar' ); ?> <input class="widefat" id="<?php echo $this->get_field_id( 'category_id' ); ?>" name="<?php echo $this->get_field_name( 'category_id' ); ?>" type="text" value="<?php echo esc_attr( $category_id ); ?>" /></label></p>
		<?php
	}
		
	/**
	 * Save widget data
	 *
	 * @param string $new_instance
	 * @param string $old_instance
	 * @return void
	 **/
	function update( $new_instance, $old_instance ) {
		$instance     = $old_instance;
		$new_instance = wp_parse_args( (array)$new_instance, array( 'category_id' => '' ) );

		$instance['category_id']  = implode( ',', array_filter( array_map( 'intval', explode( ',', $new_instance['category_id'] ) ) ) );
		
		return $instance;
	}
}

function register_ajax_calendar_widget() {
	register_widget( 'AJAX_Calendar_Widget' );
}

add_action( 'widgets_init', 'register_ajax_calendar_widget' );

function ajax_calendar ($categories = '') {
	// $calendar = AJAX_Calendar::get ();
	// $calendar->show ( $categories );
}
