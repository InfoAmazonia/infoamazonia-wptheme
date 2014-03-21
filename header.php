<!DOCTYPE html>
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
		echo ' | ' . __('Page', 'infoamazonia') . max($paged, $page);

	?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('stylesheet_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<link rel="shortcut icon" href="<?php bloginfo('stylesheet_directory'); ?>/img/favicon.ico" type="image/x-icon" />
<?php wp_head(); ?>
</head>
<body <?php body_class(get_bloginfo('language')); ?>>
	<div id="fb-root"></div>
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/pt_BR/all.js#xfbml=1&appId=459964104075857";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>
	<header id="masthead">
		<div class="container">
			<div class="twelve columns">
				<?php
				$lang = '';
				if(function_exists('qtrans_getLanguage'))
					$lang = qtrans_getLanguage();
				?>
				<h1>
					<a href="<?php echo home_url('/' . $lang); ?>" title="<?php echo bloginfo('name'); ?>"><?php bloginfo('name'); ?> <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/logo.png" class="logo" /></a>
				</h1>
				<p class="slogan"><?php bloginfo('description'); ?></p>
				<?php get_search_form(); ?>
			</div>
		</div>
		<section id="mastnav" class="clearfix">
			<div class="container">
				<div class="eight columns">
					<nav>
						<ul>
							<?php wp_nav_menu(array(
								'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s<li><a href="#submit" class="submit-story">' . __('Submit a story', 'infoamazonia') . '</a></li></ul>'
							)); ?>
						</ul>
					</nav>
				</div>
				<div class="four columns">
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
					<nav id="social">
						<ul>
							<li class="twitter">
								<a href="https://twitter.com/infoamazonia" rel="external" target="_blank" title="Twitter"></a>
							</li>
							<li class="fb">
								<a href="https://www.facebook.com/oecodata" rel="external" target="_blank" title="Facebook"></a>
							</li>
						</ul>
					</nav>
					<nav id="feedback">
						<ul>
							<li>
								<a href="<?php echo infoamazonia_home_url('/about/'); ?>" title="<?php _e('About', 'infoamazonia'); ?>"><?php _e('About', 'infoamazonia'); ?></a>
							</li>
						</ul>
					</nav>
				</div>
			</div>
		</section>
	</header>
	<section id="main-content">
