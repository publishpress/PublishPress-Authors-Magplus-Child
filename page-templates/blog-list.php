<?php
/**
 *
 * @package magplus
*/
get_header();
if (get_query_var('paged')) {
  $paged = get_query_var('paged');
} elseif (get_query_var('page')) {
  $paged = get_query_var('page');
} else {
  $paged = 1;
}

$post_per_page = magplus_get_post_opt('blog-posts-per-page');
if (!$post_per_page) {
  $post_per_page = get_option('posts_per_page');
}

$post_args = array(
  'posts_per_page' => $post_per_page,
  'orderby'        => 'date',
  'paged'          => $paged,
  'order'          => 'DESC',
  'post_type'      => 'post',
  'post_status'    => 'publish'
);

$categories = magplus_get_post_opt('blog-category');
if (is_array($categories)) {
  $post_args['category__in'] =  $categories;
}

$query = new WP_Query( $post_args );
if(is_page()) {
  $max_num_pages = $query -> max_num_pages;
} else {
  global $wp_query;
  $query = $wp_query;
  $max_num_pages = false;
}

?>

<div class="container">
  <div class="empty-space marg-lg-b60 marg-sm-b20 marg-xs-b15"></div>
  <?php get_template_part('templates/global/page-before-content'); ?>
    <?php if($query -> have_posts()): while ($query -> have_posts()) : $query -> the_post(); ?>
      <div <?php post_class('tt-post tt-blog-list-index'); ?>>

        <?php magplus_post_format('magplus-big','img-responsive'); ?>

        <div class="tt-post-info">
          <?php magplus_blog_category(); ?>
          <?php magplus_blog_title(); ?>

            <?php
            // ##################################################################
            // Modified by PublishPress, to make it compatible with
            // the Multiple Authors add-on.
            // ##################################################################
            ?>
            <div class="tt-post-label">
                <span class="tt-post-author-name"><?php do_action('pp_multiple_authors_show_author_box', false, 'inline', false, true); ?></span>
                <span class="tt-post-date"><?php echo get_the_date(get_option('date_format')); ?></span>
            </div>

            <?php
            // ##################################################################
            // The end of modifications.
            // ##################################################################
            ?>

          <?php magplus_blog_excerpt(); ?>
          <?php magplus_blog_post_bottom(); ?>
        </div>
      </div>
      <div class="empty-space marg-lg-b30"></div>
    <?php endwhile; wp_reset_postdata(); else:
      get_template_part('templates/content', 'none');
    endif; ?>

    <?php magplus_paging_nav($max_num_pages, 'default'); ?>
    <div class="empty-space marg-sm-b30"></div>
  <?php get_template_part('templates/global/page-after-content'); ?>
</div>
<div class="empty-space marg-lg-b55 marg-sm-b30 marg-xs-b20"></div>
<?php
get_footer();
