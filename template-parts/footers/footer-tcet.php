<div class="site-footer__top">
  <div class="container">
     <?php if( orgafresh_get_opt('velesh_footer_menu') ):
        wp_nav_menu( array(
           'menu_class' => 'site-footer__menu',
           'menu' => (int)orgafresh_get_opt('velesh_footer_menu'),
           'walker' => new Orgafresh_Mega_Menu_Walker())
        );
       endif; ?>
  </div>
</div><!-- site-footer__menu -->

<div class="site-footer__bottom">
  <div class="container">
    <div class="row">
      <div class="col-12 col-md-4 text-center text-left-md order-3 order-md-0">
         <?php if( orgafresh_get_opt('velesh_footer_copyrights') ):
            printf('<p class="copyrights">%s</p>', orgafresh_get_opt('velesh_footer_copyrights'));
          endif; ?>
      </div>
      <div class="col-12 show-mobile order-2 order-md-0">
      <?php if( orgafresh_get_opt('velesh_footer_menu') ):
        wp_nav_menu( array(
           'menu_class' => 'site-footer__menu-mobile',
           'menu' => (int)orgafresh_get_opt('velesh_footer_menu'),
           'walker' => new Orgafresh_Mega_Menu_Walker())
        );
       endif; ?>
      </div>
      <div class="col-12 col-md-4 valign-center">
        <div id="accesibility-footer">
        </div>
      </div>
      <div class="col-12 col-md-4 text-center text-right-md">
        <?php if( orgafresh_get_opt('velesh_social_menu') ):
        wp_nav_menu(
           array(
             'menu_class' => 'site-footer__social',
             'menu' => (int)orgafresh_get_opt('velesh_social_menu'),
             'walker' => new Orgafresh_Mega_Menu_Walker()) );
        endif; ?>
      </div>
    </div>
  </div>
</div>