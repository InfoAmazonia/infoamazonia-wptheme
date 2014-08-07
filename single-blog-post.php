<?php get_header(); ?>

<section id="content">
<?php if(have_posts()) : while(have_posts()) : the_post(); ?>
	<div id="page" class="gray-page">
		<div class="container row">
			<div class="eight columns">
				<article id="post-<?php the_ID(); ?>" <?php post_class('main'); ?>>
						<header class="page-header">
							<h2><a href="<?php echo get_post_type_archive_link('blog-post'); ?>">Blog</a></h2>
							<h1><?php the_title(); ?></h1>
							<div class="meta">
								<p class="author"><span class="lsf">&#xE137;</span> <?php _e('by', 'infoamazonia'); ?> <?php the_author(); ?></p>
								<p class="date"><span class="lsf">&#xE15e;</span> <?php echo get_the_date(); ?></p>
								<?php the_terms($post->ID, 'blog-category', '<p class="categories"><span class="lsf">&#xE128;</span>', ', ', '</p>'); ?>
							</div>
						</header>
						<aside class="social clearfix">
							<div class="fb-like" data-href="<?php the_permalink(); ?>" data-send="false" data-layout="button_count" data-width="450" data-show-faces="false" data-font="verdana"></div>
							<div class="twitter-button">
								<a href="https://twitter.com/share" class="twitter-share-button" data-via="infoamazonia" <?php if(function_exists('qtrans_getLanguage')) : ?>data-lang="<?php echo qtrans_getLanguage(); ?>"<?php endif; ?>>Tweet</a>
							</div>
						</aside>
						<section class="post-content">
							<?php the_content(); ?>
						</section>
				</article>
				<?php comments_template(); ?>
			</div>
		</div>
	</div>
<?php endwhile; endif; ?>
</section>

<?php get_footer(); ?>