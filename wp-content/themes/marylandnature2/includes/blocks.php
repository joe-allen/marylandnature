<?php

function nhsm_register_block() {
    // Register our block script with WordPress
    wp_register_script(
        'nhsm-blocks',
        get_stylesheet_directory_uri() . '/blocks/dist/blocks.build.js',
        ['wp-blocks', 'wp-element', 'wp-editor'],
        filemtime(get_stylesheet_directory() . '/blocks/dist/blocks.build.js')
    );

    // Register our block's base CSS
    wp_register_style(
        'nhsm-block-styles',
        get_stylesheet_directory_uri() . '/blocks/dist/blocks.style.build.css',
        [],
        filemtime( get_stylesheet_directory() . '/blocks/dist/blocks.style.build.css' )
    );

    // Register our block's editor-specific CSS
    if( is_admin() ) :
        wp_register_style(
            'nhsm-block-editor-styles',
            get_stylesheet_directory_uri() . '/blocks/dist/blocks.editor.build.css',
            ['wp-edit-blocks'],
            filemtime( get_stylesheet_directory() . '/blocks/dist/blocks.editor.build.css' )
        );
    endif;

    // Register blocks
    register_block_type('nhsm-featurettes/newsletter-signup', [
        'editor_script' => 'nhsm-blocks',
        'editor_style' => 'nhsm-block-editor-styles',
        'style' => 'nhsm-block-styles',
        'render_callback' => 'nhsm_featurette_newsletter_signup_render',
    ]);
    register_block_type('nhsm-featurettes/collections', [
        'editor_script' => 'nhsm-blocks',
        'editor_style' => 'nhsm-block-editor-styles',
        'style' => 'nhsm-block-styles',
        'render_callback' => 'nhsm_featurette_collections_render'
    ]);
    register_block_type('nhsm-widgets/collections', [
        'editor_script' => 'nhsm-blocks',
        'editor_style' => 'nhsm-block-editor-styles',
        'style' => 'nhsm-block-styles',
        'render_callback' => 'nhsm_widgets_collections_render',
        'attributes' => [
            'count' => [
                'default' => 6,
                'type' => 'integer'
            ]
        ]
    ]);
}
add_action( 'init', 'nhsm_register_block' );

/** Render Functions **/
function nhsm_featurette_newsletter_signup_render($attributes, $content){
    $photo_credit = nhsm_format_image_credit_line( false, $attributes['imageID'] );
    if ( $photo_credit ) {
        if ( strpos( $content, '<figcaption>' ) !== false ) {
            $content = str_replace( '<figcaption>', '<figcaption class="figure__caption">'.esc_html( $photo_credit ), $content );
        } else {
            $content = str_replace( '</figure>', '<figcaption class="figure__caption">'.esc_html( $photo_credit ).'</figcaption></figure>', $content );
        }
    }

    return $content;
}

function nhsm_featurette_collections_render($attributes, $content){
    $collections = nhsm_widgets_collections_render(['count' => 3]);
    $content = str_replace('<div id="collections_list"></div>', $collections, $content);

    return $content;
}

function nhsm_widgets_collections_render($attributes){
    $collections_args = [
        'post_type' => 'nhsm_collections',
        'post_status' => 'publish',
        'posts_per_page' => $attributes['count'],
        'orderby' => 'rand'
    ];
    $collections = new WP_Query($collections_args);

    ob_start();
    ?>

    <?php if($collections->have_posts()): ?>
        <?php while($collections->have_posts()): $collections->the_post(); ?>
            <?php get_template_part( 'parts/card', get_post_type() ); ?>
        <?php endwhile; wp_reset_postdata(); ?>
    <?php endif;

    $content = ob_get_clean();

    return $content;
}

/** Misc **/
function nhsm_block_categories( $categories, $post ) {
    return array_merge(
        $categories,
        [
            [
                'slug' => 'nhsm-featurettes',
                'title' => 'NHSM Featurettes'
            ],
        ]
    );
}
add_filter( 'block_categories', 'nhsm_block_categories', 10, 2);

function nhsm_theme_supports(){
    add_theme_support( 'editor-color-palette', [
        [
            'name' => 'grass green (primary)',
            'slug' => 'green-primary',
            'color' => '#367202',
        ],
        [
            'name' => 'lime green (secondary)',
            'slug' => 'green-secondary',
            'color' => '#abd037',
        ],
        [
            'name' => 'forest green',
            'slug' => 'green-dark',
            'color' => '#121a18',
        ],
        [
            'name' => 'white',
            'slug' => 'white',
            'color' => '#ffffff',
        ],
        [
            'name' => 'very light gray',
            'slug' => 'very-light-gray',
            'color' => '#e8e8e8',
        ],
        [
            'name' => 'light gray',
            'slug' => 'light-gray',
            'color' => '#d9d9d9',
        ],
        [
            'name' => 'dark gray (reading)',
            'slug' => 'dark-gray-reading',
            'color' => '#444',
        ],
        [
            'name' => 'black',
            'slug' => 'black',
            'color' => '#000000',
        ],

    ]);
}
add_action('after_setup_theme', 'nhsm_theme_supports');

