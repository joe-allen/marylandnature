<?php get_header(); ?>
			
	<div id="content">
		<div id="inner-content">
			<div class="row">
				<div class="medium-12 columns">
			
					<div class="row" data-equalizer data-equalize-on="medium">
						<main id="main" class="medium-9 medium-push-3 columns" role="main" data-equalizer-watch>
						
						
						
							<header class="article-header">
								<div class="float-right">
									<!-- Go to www.addthis.com/dashboard to customize your tools -->
									<div class="addthis_inline_share_toolbox"></div>
								</div>
								<h1 class="entry-title single-title">Search<?php if(get_search_query() != '') echo ' for "'.esc_attr(get_search_query()).'"'; ?></h1>
							</header>
						
							<?php if(get_search_query() != ''): ?>
								<p>Showing results for <em><?php echo esc_attr(get_search_query()); ?></em></p>
							<?php endif;
							get_search_form(); ?>
							<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
								<?php get_template_part( 'parts/loop', 'archive' ); ?>
							<?php endwhile; 
							joints_page_navi();
							else : ?>
								<?php get_template_part( 'parts/content', 'missing' ); ?>
							<?php endif; ?>
							
						</main> <!-- end #main -->

						<?php get_sidebar(); ?>

					</div>
				</div>
			</div>

		</div> <!-- end #inner-content -->

	</div> <!-- end #content -->

<?php get_footer(); ?>
