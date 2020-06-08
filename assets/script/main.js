
function clog(data){
  if(typeof(THEME_DEBUG) !== 'undefined' && THEME_DEBUG == 'yes'){
    console.log(data);
  }
}

function  do_google_map(id, lat, lng, marker_url) {
  clog(id);
  clog(lng);
  clog(lat);
  clog(marker_url);

  // Create a new StyledMapType object, passing it an array of styles,
  // and the name to be displayed on the map type control.
  var styledMapType = new google.maps.StyledMapType(
      [
        {elementType: 'geometry', stylers: [{color: '#f2f2f2'}]},
        {elementType: 'labels.text.fill', stylers: [{color: '#414141'}]},
        {elementType: 'labels.text.stroke', stylers: [{color: '#f5f1e6'}]},
        {
          featureType: 'administrative',
          elementType: 'geometry.stroke',
          stylers: [{color: '#c9b2a6'}]
        },
        {
          featureType: 'administrative.land_parcel',
          elementType: 'geometry.stroke',
          stylers: [{color: '#dcd2be'}]
        },
        {
          featureType: 'administrative.land_parcel',
          elementType: 'labels.text.fill',
          stylers: [{color: '#a7a7a7'}]
        },
        {
          featureType: 'landscape.natural',
          elementType: 'geometry',
          stylers: [{color: '#dfd2ae'}]
        },
        {
          featureType: 'poi',
          elementType: 'geometry',
          stylers: [{color: '#dfd2ae'}]
        },
        {
          featureType: 'poi',
          elementType: 'labels.text.fill',
          stylers: [{color: '#a7a7a7'}]
        },
        {
          featureType: 'poi.park',
          elementType: 'geometry.fill',
          stylers: [{color: '#a5b076'}]
        },
        {
          featureType: 'poi.park',
          elementType: 'labels.text.fill',
          stylers: [{color: '#a7a7a7'}]
        },
        {
          featureType: 'road',
          elementType: 'geometry',
          stylers: [{color: '#f5f1e6'}]
        },
        {
          featureType: 'road.arterial',
          elementType: 'geometry',
          stylers: [{color: '#fdfcf8'}]
        },
        {
          featureType: 'road.highway',
          elementType: 'geometry',
          stylers: [{color: '#f8c967'}]
        },
        {
          featureType: 'road.highway',
          elementType: 'geometry.stroke',
          stylers: [{color: '#e9bc62'}]
        },
        {
          featureType: 'road.highway.controlled_access',
          elementType: 'geometry',
          stylers: [{color: '#e98d58'}]
        },
        {
          featureType: 'road.highway.controlled_access',
          elementType: 'geometry.stroke',
          stylers: [{color: '#db8555'}]
        },
        {
          featureType: 'road.local',
          elementType: 'labels.text.fill',
          stylers: [{color: '#a7a7a7'}]
        },
        {
          featureType: 'transit.line',
          elementType: 'geometry',
          stylers: [{color: '#dfd2ae'}]
        },
        {
          featureType: 'transit.line',
          elementType: 'labels.text.fill',
          stylers: [{color: '#a7a7a7'}]
        },
        // {
        //   featureType: 'transit.line',
        //   elementType: 'labels.text.stroke',
        //   stylers: [{color: '#ebe3cd'}]
        // },
        {
          featureType: 'transit.station',
          elementType: 'geometry',
          stylers: [{color: '#dfd2ae'}]
        },
        {
          featureType: 'water',
          elementType: 'geometry.fill',
          stylers: [{color: '#9d9d9f'}]
        },
        {
          featureType: 'water',
          elementType: 'labels.text.fill',
          stylers: [{color: '#a7a7a7'}]
        }
      ],
      {name: 'Styled Map'});

  // Create a map object, and include the MapTypeId to add
  // to the map type control.
  var map = new google.maps.Map(document.getElementById(id), {
    center: {lat: parseFloat(lat), lng: parseFloat(lng)},
    zoom: 14,
    mapTypeControlOptions: {
      mapTypeIds: ['roadmap', 'satellite', 'hybrid', 'terrain',
              'styled_map']
    }
  });

  var marker_args =  {
    position: {lat: parseFloat(lat), lng: parseFloat(lng)},
    map:       map,
  };

  if('undefined' !== typeof('marker_url')){
    marker_args.icon = marker_url;
  }

  var marker = new google.maps.Marker(marker_args);

  //Associate the styled map with the MapTypeId and set it to display.
  map.mapTypes.set('styled_map', styledMapType);
  map.setMapTypeId('styled_map');
}

var search_map_object;

function add_search_marker(lat, lng, marker_url){
  var marker_args =  {
    position: {lat: parseFloat(lat), lng: parseFloat(lng)},
    map:       search_map_object,
  };



  if('undefined' !== typeof('marker_url')){
    marker_args.icon = marker_url;
  }

  new google.maps.Marker(marker_args);
}


function do_search_map(id, lat, lng, zoom){
  search_map_object = new google.maps.Map(document.getElementById(id), {
    center: {lat: parseFloat(lat), lng: parseFloat(lng)},
    zoom: parseInt(zoom),
    mapTypeControlOptions: {
      mapTypeIds: ['roadmap', 'satellite', 'hybrid', 'terrain',
              'styled_map']
    }
  });
}


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


// load more venues and init maps
jQuery('.load-more-venues').click(function(e){
  e.preventDefault();
  clog('show more venues');

  var counter = 0;

  jQuery('div.venues-preview').find('.venue-preview.hidden').each(function(ind, el){

    if(counter < 6){
      var map = jQuery(el).find('div.google-map-preview');

      var block_id = map.attr('id');
      var lat      = map.data('lat');
      var lng      = map.data('lng');
      var marker   = map.data('marker');

      jQuery(el)
        .css({opacity:0})
        .removeClass('hidden');
       do_google_map(block_id, lat, lng,  marker);
    }
    counter++;
  });

   setTimeout(function(){
     jQuery('div.venues-preview').find('div.venue-preview').css({opacity:1})
   }, 100);

   if(! jQuery('div.venues-preview').find('.venue-preview.hidden').length){

     jQuery('.load-more-venues').remove();
   }

})


jQuery(document.body).on('theme.init.map',function(event, id, lng, lat, $marker_url){
  do_google_map(id, lng, lat, $marker_url);
})

jQuery(document.body).on('theme.init.map.search',function(event, id, lat, lng, zoom){
  do_search_map(id, lat, lng, zoom);
})



jQuery(document.body).on('theme.add.map.search.marker',function(event,  lat, lng, marker){
  add_search_marker(lat, lng, marker);
})


jQuery('.venues-filter__item-title').click(function(){
  $action_expand =  !jQuery(this).closest('.venues-filter__item').hasClass('expanded');

  if($action_expand){
    jQuery(this).closest('.venues-filter__item').addClass('expanded');
    jQuery(this).siblings('.venues-filter__item-body').slideDown();
  }else{
    jQuery(this).closest('.venues-filter__item').removeClass('expanded');
    jQuery(this).siblings('.venues-filter__item-body').slideUp();

  }
})
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