<?php get_header(); $classes = array('medium-12', 'columns'); ?>
			
<div id="content">
	<div id="inner-content">
		<div class="row">
			<div class="<?php echo implode(' ', $classes); ?>">
				<div class="row" data-equalizer="brellis" data-equalize-on="medium">
					<div class="medium-9 medium-push-3 columns" data-equalizer-watch="brellis">
						<div class="row">
							<main id="main" class="medium-8 columns" role="main">
								

								<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

									<?php get_template_part( 'parts/loop', 'single' ); ?>

								<?php endwhile; else : ?>

									<?php get_template_part( 'parts/content', 'missing' ); ?>

								<?php endif; ?>

							</main> <!-- end #main -->
							<?php get_sidebar('download-meta'); ?>
						</div>
						
					</div>
					

					<?php get_sidebar(); ?>
					
				</div>
			</div>
		</div>
	</div> <!-- end #inner-content -->

</div> <!-- end #content -->

<?php get_footer(); ?>