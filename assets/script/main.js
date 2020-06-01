
function init_events_carousel(){
  jQuery('.upcomming-events.owl-carousel').each(function(ind,el){
    let owl = jQuery(el);
    owl.show().owlCarousel({
      responsive:{
        0 : {
          items: 1,
          center: true,
        },
        640: {
          items: 2,
          center: false,
        },

        992:{
          items: 3,
        }
      },
      margin:   10,
      autoplay: true,
      rewind:   true,
      dots:     false,
      autoplayTimeout: 10000,
      smartSpeed: 1200,
    });

    owl.siblings('.carousel-ctrl').find('.prev').click(function(event) {
      owl.trigger('prev.owl.carousel');
    });

    owl.siblings('.carousel-ctrl').find('.next').click(function(event) {
      owl.trigger('next.owl.carousel');
    });
  })
}


jQuery(document).ready(function(){
  init_events_carousel();
})
function init_count_down(){
  jQuery('.countdown').each(function(index, el) {
    let countdown = jQuery(el);
    setInterval(function(){
      jQuery(document.body).trigger('seconds_change', {countdown: countdown});
    }, 1000);
  });
}

jQuery(document.body).on('seconds_change', function(e,data){
  let seconds = parseInt(data.countdown.find('.seconds').data('value'));
  seconds--;
  if(seconds < 0){
   jQuery(document.body).trigger('minutes_change', {countdown: data.countdown});
  }
  seconds = (seconds < 0)? '59' : seconds;
  data.countdown.find('.seconds').data({'value': seconds}).text(seconds);
});

jQuery(document.body).on('minutes_change', function(e,data){
  let minutes = parseInt(data.countdown.find('.minutes').data('value'));
  minutes--;
  let label = data.countdown.find('.minutes').siblings('.label');
  let label_val = (minutes === 1)? label.data('single') : label.data('multiple');
  label.text(label_val);
  if(minutes < 0){
   jQuery(document.body).trigger('hours_change', {countdown: data.countdown});
  }
  minutes = (minutes < 0)? '59' : minutes;
  data.countdown.find('.minutes').data({'value': minutes}).text(minutes);
});


jQuery(document.body).on('hours_change', function(e,data){
  let hours = parseInt(data.countdown.find('.hours').data('value'));
  hours--;

  let label = data.countdown.find('.hours').siblings('.label');
  let label_val = (hours === 1)? label.data('single') : label.data('multiple');
  label.text(label_val);

  if(hours < 0){
   jQuery(document.body).trigger('days_change', {countdown: data.countdown});
  }
  hours = (hours < 0)? '23' : hours;
  data.countdown.find('.hours').data({'value': hours}).text(hours);
});

jQuery(document.body).on('days_change', function(e,data){
  let days = parseInt(data.countdown.find('.days').data('value'));
  days--;

  let label = data.countdown.find('.days').siblings('.label');
  let label_val = (days === 1)? label.data('single') : label.data('multiple');
  label.text(label_val);

  days = (days < 0)? '0' : days;
  data.countdown.find('.days').data({'value': days}).text(days);
});


jQuery(document).ready(function(){
  init_count_down();
})
jQuery('.icon-search').click(function(event) {
  jQuery('.site-header__top-row').addClass('show-search')
});

jQuery('.icon-hide-search').click(function(event) {
  jQuery('.site-header__top-row').removeClass('show-search')
});


jQuery('.icon-search-mobile').click(function(event) {
  jQuery('.search-container-mobile').slideDown();
});

jQuery('.search-container-mobile .icon-hide-search').click(function(event) {
  jQuery('.search-container-mobile').slideUp();
});


jQuery('.mobile-menu-toggle').click(function(event) {
  jQuery(this).toggleClass('active');

  jQuery(document.body).trigger('show_mobile_menu', {state: jQuery(this).hasClass('active')})
});


jQuery('.icon-close-mobile').click(function(e){
    jQuery('.mobile-menu-holder').removeClass('shown');
    jQuery('.mobile-menu-toggle').removeClass('active');
})

jQuery('.mobile-menu-container .menu-item-has-children').click(function(event) {

  if(!jQuery(event.target).closest('a').length){
    jQuery(this).find('.sub-menu').slideToggle();
    jQuery(this).toggleClass('expanded');;
    jQuery(this).siblings('.menu-item-has-children').removeClass('expanded').find('.sub-menu').slideUp();
  }
});

jQuery(document.body).on('show_mobile_menu', function(e, data){
  jQuery('.mobile-menu-holder').addClass('shown');
})

jQuery('.faq-item').click(function(event) {
  jQuery(this).toggleClass('expanded');
  jQuery(this).find('.faq-item__body').slideToggle()
  jQuery(this).siblings('div.faq-item').removeClass('expanded').find('div.faq-item__body').slideUp();
});
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