<?php
/**
 * Blog Default
 *
 * @package magplus
 * @since 1.0
 */
?>

<?php
  $post_format = get_post_format();
  if($post_format == 'gallery'):
    get_template_part('templates/blog/blog-single/parts/single', 'media');
  endif;
?>

<div class="container">
  <?php magplus_before_content_special_content(); ?>
  <div class="empty-space marg-lg-b60 marg-sm-b40 marg-xs-b30"></div>

  <?php get_template_part('templates/global/page-before-content'); ?>

    <?php while ( have_posts() ) : the_post(); ?>
      <?php magplus_setPostViews(get_the_ID()); ?>
      <article <?php post_class(); ?>>
        <!-- TT-BLOG-CATEGORY -->
        <div class="tt-blog-category post-single">
          <?php
            $category = get_the_category();
            if(is_array($category) && !empty($category)):
              foreach($category as $cat): ?>
                <a class="c-btn type-3 color-3" href="<?php echo esc_url(get_category_link($cat->term_id)); ?>"><?php echo esc_html($cat->cat_name); ?></a>
             <?php
              endforeach;
            endif;
          ?>
        </div>


        <div class="empty-space marg-lg-b10"></div>
        <h1 class="c-h1"><?php the_title(); ?></h1>
        <div class="empty-space marg-lg-b5"></div>

        <!-- TT-BLOG-USER -->

        <div class="tt-blog-user clearfix">

            <?php
            // ##################################################################
            // Modified by PublishPress, to make it compatible with
            // the Multiple Authors add-on.
            // ##################################################################
            ?>
            <div class="tt-blog-user-content">
                <?php do_action('pp_multiple_authors_show_author_box', false, 'inline_avatar', false); ?>

                <span class="tt-post-date-single"><?php echo magplus_time_format(); ?></span>
            </div>

            <?php
            // ##################################################################
            // The end of modifications.
            // ##################################################################
            ?>

        </div>


        <div class="empty-space marg-lg-b10"></div>

        <?php magplus_social_share('style1'); ?>

        <!-- TT-DEVIDER -->
        <div class="tt-devider"></div>
        <div class="empty-space marg-lg-b20"></div>

        <?php
          if($post_format != 'gallery'):
            get_template_part('templates/blog/blog-single/parts/single', 'media');
          endif;
        ?>


        <div class="empty-space marg-lg-b40 marg-sm-b30"></div>

        <div class="simple-text size-4 tt-content title-droid margin-big">
          <?php the_content(); ?>
        </div>
        <?php
          if($post_format == 'aside'):
            echo '<div class="empty-space marg-lg-b25"></div>';
            get_template_part('templates/blog/blog-single/parts/single', 'media');
          endif;
        ?>
        <?php
          wp_link_pages( array(
            'before'      => '<div class="page-links">' . magplus_get_opt('translation-pages'),
            'after'       => '</div>',
            'link_before' => '<span>',
            'link_after'  => '</span>',
          ) );
        ?>
      </article>
      <div class="empty-space marg-lg-b30 marg-sm-b30"></div>
      <?php the_tags( '<span class="tt-tag-title">'.magplus_get_opt('translation-tags').'</span><ul class="tt-tags"><li>', '</li><li>', '</li></ul>' ); ?>

    <?php endwhile; ?>

    <div class="empty-space marg-lg-b50 marg-sm-b30"></div>


    <?php
    // ##################################################################
    // Modified by PublishPress, to make it compatible with
    // the Multiple Authors add-on.
    // ##################################################################
    ?>
    <?php do_action('pp_multiple_authors_show_author_box', false, 'boxed', false); ?>

    <?php
    // ##################################################################
    // The end of modifications.
    // ##################################################################
    ?>


    <?php magplus_post_navigation(); ?>


    <?php magplus_related_post(); ?>


    <div class="tt-devider"></div>
    <div class="empty-space marg-lg-b55 marg-sm-b50 marg-xs-b30"></div>

    <?php
      if ( comments_open() || get_comments_number() ) :
        comments_template();
      endif;
    ?>

  <?php get_template_part('templates/global/page-after-content'); ?>

  <div class="empty-space marg-lg-b80 marg-sm-b50 marg-xs-b30"></div>
  <?php magplus_after_content_special_content(); ?>
</div>
