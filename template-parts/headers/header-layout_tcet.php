<?php
/**
 * Header layout7 file.
 *
 */
?>

      <?php
              ob_start();
              orgafresh_search_by_category();
              $search_html = ob_get_contents();
              ob_get_clean();

       ?>
<div class="header-alus <?php echo (wp_is_mobile())? 'header-mobile' : ''; ?> header-<?php echo esc_attr(orgafresh_get_opt('alus_header_layout')); ?>">
  <?php if( orgafresh_get_opt('alus_header_top_bar') ) : ?>
    <div class="site-header__top-row">
      <div class="container">
        <div class="row">

          <div class="col-12 col-sm-6 text-left valign-center" >
            <div id="accesibility-header">
            </div>
          </div>

          <div class="col-12 col-sm-6 text-right">
            <div class="row no-gutters justify-content-end">

          <?php if( orgafresh_get_opt('alus_login_url') ): ?>
            <a href="<?php echo orgafresh_get_opt('alus_login_url') ?>" class="header-login-link" target="_blank"><?php _e('Login','theme-translation'); ?></a>
          <?php endif; ?>

          <?php if( orgafresh_get_opt('alus_donate_url') ): ?>
            <a href="<?php echo orgafresh_get_opt('alus_donate_url') ?>" class="header-donate-link" target="_blank"><?php _e('Donate','theme-translation'); ?></a>
          <?php endif; ?>

          <?php if( orgafresh_get_opt('alus_enable_search') ): ?>
              <i class="icon-search"></i>
          <?php endif; ?>
            </div>
          </div>
        </div>
        <?php if( orgafresh_get_opt('alus_enable_search') && !wp_is_mobile() ): ?>
          <div class="search-container">
            <div class="icon-hide-search">×</div>
            <div class="alus-header-search">
              <?php echo str_replace('for post', '' , $search_html );?>
            </div>
          </div>
        <?php endif; ?>
      </div>
    </div><!-- site-header__top-row -->
  <?php endif; ?>

  <div class="site-header__main-row">
    <div class="container">
      <div class="row justify-content-between no-gutters">
        <div class="logo-wrap"><?php echo orgafresh_logo(); ?></div>

        <nav class="menu">
          <?php
            if ( has_nav_menu( 'vertical' ) ) {
               get_template_part( 'template-parts/navigation/navigation', 'vertical' );
           }
            if ( has_nav_menu( 'primary' ) ) {
                get_template_part( 'template-parts/navigation/navigation', 'primary' );
            }
            ?>
        </nav>

        <div class="block-right-mobile">
          <?php if( orgafresh_get_opt('alus_donate_url') ): ?>
           <a href="<?php echo orgafresh_get_opt('alus_donate_url') ?>" class="button-donate-mobile" target="_blank"><?php _e('Donate','theme-translation'); ?></a>
          <?php endif; ?>

          <?php if( orgafresh_get_opt('alus_enable_search') ): ?>
            <i class="icon-search-mobile"></i>
          <?php endif; ?>

          <div class="mobile-switcher-holder">
            <div class="mobile-menu-toggle equis"><span></span></div>
          </div>
        </div>
      </div>


      <?php if( orgafresh_get_opt('alus_enable_search') && wp_is_mobile()): ?>
        <div class="search-container-mobile">
          <div class="icon-hide-search">×</div>
          <div class="alus-header-search">
            <?php
              echo str_replace('for post', '' , $search_html );
            ?>
          </div>
        </div>
      <?php endif; ?>
    </div><!-- container -->
  </div><!-- site-header__main-row -->
</div>

<div class="mobile-menu-holder <?php echo (wp_is_mobile())? 'header-mobile' : ''; ?>">
  <div class="container">

    <div class="mobile-menu-holder__top">
      <div class="logo-wrap_mobile"><?php echo orgafresh_logo(); ?></div>
      <div class="icon-close-mobile"></div>
    </div>
  </div>

  <div class="mobile-menu-holder__scroll">


  <?php /* if( orgafresh_get_opt('alus_enable_search') ): ?>
     <?php echo str_replace('for post', '' , $search_html ); ?>
  <?php endif; */ ?>

  <?php
    wp_nav_menu( array(
      'theme_location' => 'primary',
      'menu_class' => 'mobile-menu',
      'container_class' => 'mobile-menu-container',
      'container'  => 'nav',
    ) );
  ?>
  <div class="text-center">
    <?php if( orgafresh_get_opt('alus_login_url') ): ?>
      <a href="<?php echo orgafresh_get_opt('alus_login_url') ?>" class="header-login-link-mobile" target="_blank"><?php _e('Login','theme-translation'); ?></a>
    <?php endif; ?>

    <?php if( orgafresh_get_opt('alus_donate_url') ): ?>
      <a href="<?php echo orgafresh_get_opt('alus_donate_url') ?>" class="header-donate-link-mobile" ><?php _e('Donate','theme-translation'); ?></a>
    <?php endif; ?>
  </div>
  </div>
</div>