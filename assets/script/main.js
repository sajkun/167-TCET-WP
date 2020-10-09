var Cookie =
{
   set: function(name, value, days)
   {
      var domain, domainParts, date, expires, host;

      if (days)
      {
         date = new Date();
         date.setTime(date.getTime()+(days*24*60*60*1000));
         expires = "; expires="+date.toGMTString();
      }
      else
      {
         expires = "";
      }

      host = location.host;
      if (host.split('.').length === 1)
      {
         // no "." in a domain - it's localhost or something similar
         document.cookie = name+"="+value+expires+"; path=/";
      }
      else
      {
         // Remember the cookie on all subdomains.
          //
         // Start with trying to set cookie to the top domain.
         // (example: if user is on foo.com, try to set
         //  cookie to domain ".com")
         //
         // If the cookie will not be set, it means ".com"
         // is a top level domain and we need to
         // set the cookie to ".foo.com"
         domainParts = host.split('.');
         domainParts.shift();
         domain = '.'+domainParts.join('.');

         document.cookie = name+"="+value+expires+"; path=/; domain="+domain;

         // check if cookie was successfuly set to the given domain
         // (otherwise it was a Top-Level Domain)
         if (Cookie.get(name) == null || Cookie.get(name) != value)
         {
            // append "." to current domain
            domain = '.'+host;
            document.cookie = name+"="+value+expires+"; path=/; domain="+domain;
         }
      }
   },

   get: function(name)
   {
      var nameEQ = name + "=";
      var ca = document.cookie.split(';');
      for (var i=0; i < ca.length; i++)
      {
         var c = ca[i];
         while (c.charAt(0)==' ')
         {
            c = c.substring(1,c.length);
         }

         if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
      }
      return null;
   },

   erase: function(name)
   {
      Cookie.set(name, '', -1);
   }
};

function clog(data){
  if(typeof(THEME_DEBUG) !== 'undefined' && THEME_DEBUG == 'yes'){
    console.log(data);
  }
}


function review_carousel(){
  if (jQuery('.about__body').length && jQuery(window).width() < 992) {

    var owl = jQuery('.about__body .owl-carousel');

    owl.find('.about__item-spacer').remove();


    owl.on('initialized.owl.carousel', function(){
      owl.siblings('.owl-ctrl').removeClass('visuallyhidden');
    })

    owl.owlCarousel({

      responsive:{
        0   : {
          item: 1,
        },
        480 : {
          items: 2,
          slideBy: 2,
        },
      },
      items: 1,
      autoplay: true,
      loop: true,
    });

     owl.siblings('.owl-ctrl').find('.next').click(function(event) {
       owl.trigger('next.owl.carousel');
     });

     owl.siblings('.owl-ctrl').find('.prev').click(function(event) {
       owl.trigger('prev.owl.carousel');
     });
  }
}
jQuery(document).on('click', '.mobile-menu-switcher', function(){
  jQuery(this).toggleClass('active');
  jQuery('.menu-holder').toggleClass('shown');
})

jQuery(document).on('click', '.site-container', function(e){
  if(!jQuery(e.target).closest('.menu-holder').length && !jQuery(e.target).closest('.mobile-menu-switcher').length){
    jQuery('.mobile-menu-switcher').removeClass('active');
    jQuery('.menu-holder').removeClass('shown');
  }
})
jQuery(document).ready(function(){
  review_carousel();
})