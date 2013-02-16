<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>" />
<title><?php
	global $page, $paged;

	wp_title( '|', true, 'right' );

	bloginfo( 'name' );

	$site_description = get_bloginfo('description', 'display');
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";

	if ( $paged >= 2 || $page >= 2 )
		echo ' | Página ' . max($paged, $page);

	?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('stylesheet_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<link rel="shortcut icon" href="<?php bloginfo('template_directory'); ?>/img/favicon.ico" type="image/x-icon" />
<?php wp_head(); ?>
</head>
<body <?php body_class(get_bloginfo('language')); ?>>
	<div id="fb-root"></div>
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/pt_BR/all.js#xfbml=1&appId=174607379284946";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>
	<header id="masthead">
		<div class="limiter">
			<h1><a href="<?php echo mappress_get_home_url('/'); ?>" title="<?php echo bloginfo('name'); ?>"><?php bloginfo('name'); ?><span class="icon logo">&nbsp;</span></a></h1>
			<em class="revision">
				<?php
				// get last post date
				$last_post = get_posts('post_type=post&posts_per_page=1');
				if($last_post) {
					$post = array_shift($last_post);
					setup_postdata($post);
					echo __('Last updated:', 'infoamazonia') . ' ' . get_the_date();
					wp_reset_postdata();
				}
				?>
			</em>
			<aside class="right">
				<nav id="mastnav">
					<ul>
						<li><a href="#submit" class="submit-story"><?php _e('Submit a story', 'infoamazonia'); ?></a></li>
						<li><a href="#">About</a></li>
						<li><a href="#">Data</a></li>
					</ul>
				</nav>
				<?php if(function_exists('qtrans_getLanguage')) : ?>
					<nav id="langnav">
						<ul>
							<?php
							global $q_config;
							if(is_404()) $url = get_option('home'); else $url = '';
							$current = qtrans_getLanguage();
							foreach($q_config['enabled_languages'] as $language) {
								$attrs = '';
								if($language == $current)
									$attrs = 'class="active"';
								echo '<li><a href="' . qtrans_convertURL($url, $language) . '" ' . $attrs . '>' . $language . '</a></li>';
							}
							?>
						</ul>
					</nav>
				<?php endif; ?>
			</aside>
		</div>
	</header>
	<section id="main-content">