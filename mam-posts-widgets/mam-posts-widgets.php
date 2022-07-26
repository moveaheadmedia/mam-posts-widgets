<?php
/**
 * MAM Posts Widgets
 *
 * @package   mam-posts-widgets
 * @author    Move Ahead Media <ali@moveaheadmedia.co.uk>
 * @copyright 2022 MAM Posts Widgets
 * @license   GPLv2
 * @link      https://moveaheadmedia.com
 *
 * Plugin Name:     MAM Posts Widgets
 * Plugin URI:      https://moveaheadmedia.com
 * Description:     Used to create shortcodes [mam-recent-posts count="3" categories="100,50,20"] [mam-featured-posts count="3" categories="100,50,20"] [mam-posts count="3" categories="100,50,20"]
 * Version:         1.0.0
 * Author:          Move Ahead Media
 * Author URI:      https://moveaheadmedia.com
 * Text Domain:     mam-posts-widgets
 * Domain Path:     /languages
 * Requires PHP:    7.1
 * Requires WP:     5.5.0
 * Namespace:       MamPostsWidgets
 */


// [mam-recent-posts]
// [mam-recent-posts count="4" categories="100,50,20"]
function mam_recent_posts($atts)
{
    $a = shortcode_atts(array(
        'count' => '3',
        'categories' => '',
    ), $atts);

    $categories = array();
    if ($a['categories']) {
        $categories = explode(',', $a['categories']);
    }

    $args = array(
        'post_type' => array('post'),
        'post_status' => array('publish'),
        'posts_per_page' => $a['count'],
        'ignore_sticky_posts' => true,
        'order' => 'DESC',
        'orderby' => 'date',
        'category__in' => $categories
    );

    $query = new WP_Query($args);

    ob_start();
    ?>
    <div class="mam-posts mam-recent-posts">
        <?php
        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $_category = '';
                $categories = get_the_category();
                if (!empty($categories)) {
                    $_category = esc_html($categories[0]->name);
                }
                ?>
                <div class="mam-posts-post-item">
                    <h3><?php echo get_the_title(); ?></h3>
                    <div class="mam-posts-meta">
                        <?php if ($_category) { ?>
                            <span class="mam-posts-meta-category"><?php echo $_category; ?></span>
                        <?php } ?>
                        <span class="mam-posts-meta-date"><?php echo get_the_date(); ?></span>
                        <a href="<?php echo get_permalink(); ?>" title="<?php echo get_the_title(); ?>"
                           class="mam-posts-meta-read-more"><?php _e('Read More'); ?></a>
                    </div>
                </div>
                <?php
            }
        }
        ?>

    </div>

    <?php
    wp_reset_postdata();
    return ob_get_clean();
}

add_shortcode('mam-recent-posts', 'mam_recent_posts');


// [mam-featured-posts]
// [mam-featured-posts count="4" categories="100,50,20"]
function mam_featured_posts($atts)
{
    $a = shortcode_atts(array(
        'count' => '3',
        'categories' => '',
    ), $atts);

    $categories = array();
    if ($a['categories']) {
        $categories = explode(',', $a['categories']);
    }

    $args = array(
        'post_type' => array('post'),
        'post_status' => array('publish'),
        'posts_per_page' => $a['count'],
        'ignore_sticky_posts' => true,
        'post__in' => get_option('sticky_posts'),
        'order' => 'DESC',
        'orderby' => 'date',
        'category__in' => $categories
    );

    $query = new WP_Query($args);

    ob_start();
    ?>
    <div class="mam-posts mam-featured-posts">
        <?php
        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $_category = '';
                $categories = get_the_category();
                if (!empty($categories)) {
                    $_category = esc_html($categories[0]->name);
                }
                ?>
                <div class="mam-posts-post-item">
                    <h3><?php echo get_the_title(); ?></h3>
                    <div class="mam-posts-meta">
                        <?php if ($_category) { ?>
                            <span class="mam-posts-meta-category"><?php echo $_category; ?></span>
                        <?php } ?>
                        <span class="mam-posts-meta-date"><?php echo get_the_date(); ?></span>
                        <a href="<?php echo get_permalink(); ?>" title="<?php echo get_the_title(); ?>"
                           class="mam-posts-meta-read-more"><?php _e('Read More'); ?></a>
                    </div>
                </div>
                <?php
            }
        }
        ?>

    </div>

    <?php
    wp_reset_postdata();
    return ob_get_clean();
}

add_shortcode('mam-featured-posts', 'mam_featured_posts');


// [mam-posts]
// [mam-posts count="3" categories="100,50,20"]
function mam_posts($atts)
{
    $a = shortcode_atts(array(
        'count' => '3',
        'categories' => '',
    ), $atts);

    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

    $categories = array();
    if ($a['categories']) {
        $categories = explode(',', $a['categories']);
    }

    $args = array(
        'nopaging' => false,
        'posts_per_page' => $a['count'],
        'paged' => $paged,
        'post_type' => array('post'),
        'post_status' => array('publish'),
        'ignore_sticky_posts' => true,
        'post__in' => get_option('sticky_posts'),
        'order' => 'DESC',
        'orderby' => 'date',
        'posts_per_archive_page' => $a['count'],
        'nopaging' => false,
        'category__in' => $categories
    );
    $query = new WP_Query($args);
    ob_start();
    ?>
    <div class="mam-posts mam-posts-list">
        <?php

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $_category = '';
                $categories = get_the_category();
                if (!empty($categories)) {
                    $_category = esc_html($categories[0]->name);
                }
                ?>
                <div class="row">
                    <div class="col-md-4">
                        <div class="mam-posts-post-image">
                            <?php echo get_the_post_thumbnail(get_the_ID(), 'medium'); ?>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="mam-posts-post-item">
                            <h3><?php echo get_the_title(); ?></h3>
                            <div class="mam-posts-meta">
                                <?php if ($_category) { ?>
                                    <span class="mam-posts-meta-category"><?php echo $_category; ?></span>
                                <?php } ?>
                                <span class="mam-posts-meta-date"><?php echo get_the_date(); ?></span>
                                <a href="<?php echo get_permalink(); ?>" title="<?php echo get_the_title(); ?>"
                                   class="mam-posts-meta-read-more"><?php _e('Read More'); ?></a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
        }
        ?>
        <div class="mam-posts-list-pagination">
            <?php
            $GLOBALS['wp_query']->max_num_pages = $query->max_num_pages;
            the_posts_pagination([
                'prev_text' => __('<i class="fas fa-angle-left"></i>'),
                'next_text' => __('<i class="fas fa-angle-right"></i>'),
            ]);
            ?>
        </div>
    </div>

    <?php
    wp_reset_postdata();
    return ob_get_clean();
}

add_shortcode('mam-posts', 'mam_posts');
