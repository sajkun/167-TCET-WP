
function clog(data){
  if(typeof(THEME_DEBUG) !== 'undefined' && THEME_DEBUG == 'yes'){
    console.log(data);
  }
}

var maps = {};

function  do_google_map(map_id, lat, lng, marker_url) {
  clog('do_google_map')
  var styledMapType = new google.maps.StyledMapType(
      [],
      {name: 'Styled Map'}
      );

  // Create a map object, and include the MapTypeId to add
  // to the map type control.
   maps[map_id] = new google.maps.Map(document.getElementById(map_id), {
    center: {lat: parseFloat(lat), lng: parseFloat(lng)},
    zoom: 14,
    mapTypeControlOptions: {
      mapTypeIds: ['roadmap', 'satellite', 'hybrid', 'terrain',
              'styled_map']
    }
  });

  var marker_args =  {
    position: {lat: parseFloat(lat), lng: parseFloat(lng)},
    map:       maps[map_id],
  };

  if('undefined' !== typeof('marker_url')){
    marker_args.icon = marker_url;
  }

   new google.maps.Marker(marker_args);
}

var search_map_object;

var markers = {};



function add_search_marker(lat, lng, marker_url, title){
  clog('add_search_marker');
  var marker_args =  {
    position: {lat: parseFloat(lat), lng: parseFloat(lng)},
    map:   search_map_object,
    title: title,
  };

  if('undefined' !== typeof('marker_url')){
    marker_args.icon = marker_url;
  }

  var regexp = new RegExp('\\s{1,}', 'g');

  var index = title.replace(regexp, '_');

  markers[index]  = new google.maps.Marker(marker_args);

  markers[index].addListener('click',function(){
    search_map_object.panTo( markers[index].getPosition());

    var zoom = parseInt(jQuery('#search-map').data('zoom'));
    search_map_object.setZoom(zoom);

    jQuery(document.body).trigger('search.map.location', [title])
  })
}




function center_search_map(newLat, newLng){

  try{
    search_map_object.panTo({
    lat : parseFloat(newLat),
    lng : parseFloat(newLng)
  });


   search_map_object.setZoom(15);
   jQuery('html, body').animate({'scrollTop': 0})
  } catch{}
}



function do_search_map(id, lat, lng, zoom){
  search_map_object = new google.maps.Map(document.getElementById(id), {
    center: {lat: parseFloat(lat), lng: parseFloat(lng)},
    zoom: parseInt(zoom),
    mapTypeControl: false,
    mapTypeControlOptions: {
      mapTypeIds: ['roadmap',
              'styled_map']
    }
  });
}


function do_large_map(id, lat, lng, zoom, title){
  var large_map = new google.maps.Map(document.getElementById(id), {
    center: {lat: parseFloat(lat), lng: parseFloat(lng)},
    zoom: parseInt(zoom),
    mapTypeControl: false,
    mapTypeControlOptions: {
      mapTypeIds: ['roadmap',
              'styled_map']
    }
  });

  var marker_args =  {
    position: {lat: parseFloat(lat), lng: parseFloat(lng)},
    map:   large_map,
    title: title,
  };

  new google.maps.Marker(marker_args);

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

  jQuery('div.venues-preview').find('.js-show-venue.hidden').each(function(ind, el){

    if(counter < 6){
      var map = jQuery(el).find('div.google-map-preview');


      jQuery(el)
        .css({opacity:0})
        .removeClass('hidden');

      if(map.length){
          var block_id = map.attr('id');
          var lat      = map.data('lat');
          var lng      = map.data('lng');
          var marker   = map.data('marker');
         do_google_map(block_id, lat, lng,  marker);
      }
    }
    counter++;
  });

   setTimeout(function(){
     jQuery('div.venues-preview').find('div.js-show-venue').css({opacity:1})
   }, 100);

   if(! jQuery('div.venues-preview').find('.js-show-venue.hidden').length){

     jQuery('.load-more-venues').remove();
   }
})


// scroll button action
jQuery('.go-up-button').click(function(){
  jQuery('html, body').animate({scrollTop: 0});
})

jQuery(window).scroll(function(){
  var pos = jQuery(window).scrollTop()

  if(pos > 300){
    jQuery('.go-up-button').addClass('shown');
  }else{
    jQuery('.go-up-button').removeClass('shown');
  }
})

jQuery('.theme-accordeon__head').click(function(event) {
  jQuery(this).siblings('.theme-accordeon__body').slideToggle();
  jQuery(this).closest('div.theme-accordeon').toggleClass('expanded');
});

jQuery('.theme-accordeon-mob__head').click(function(event) {
  if (jQuery(window).width() < 992) {
    jQuery(this).siblings('.theme-accordeon-mob__body').slideToggle();
    jQuery(this).closest('div.theme-accordeon-mob').toggleClass('expanded');
  }
});



jQuery('.wp-google-place').click(function(e){
  if(!jQuery(e.target).closest('.wp-google-name').length){
    // jQuery(this).siblings('.wp-google-content-inner').slideToggle();
    // jQuery(this).toggleClass('expanded');
  }
})


jQuery(document.body).on('theme.init.map',function(event, id, lng, lat, $marker_url){
  do_google_map(id, lng, lat, $marker_url);
})



jQuery(document.body).on('theme.init.search',function(event, id, lat, lng, zoom){

  var obj = jQuery('#'+id);
  var margin = obj.closest('div.container').css('margin-right');

  obj.css({'padding-right': margin});
  do_search_map(id, lat, lng, zoom);
})


jQuery(document.body).on('theme.init.largemap',function(event, id, lat, lng, zoom, title){

  var obj = jQuery('#'+id);
  var margin = obj.closest('div.container').css('margin-right');

  obj.css({'padding-right': margin});
  do_large_map(id, lat, lng, zoom, title);
})



jQuery(window).resize(function(){
  var obj = jQuery('.search-map');
  var margin = obj.closest('div.container').css('margin-right');

  obj.css({'padding-right': margin});
})



jQuery(document.body).on('theme.add.map.search.marker',function(event,  lat, lng, marker, title){
  add_search_marker(lat, lng, marker, title);
})



jQuery(document.body).on('search.map.center', function(event, lat, lng){
  center_search_map(lat, lng);
})



jQuery(document.body).on('search.map.location',function(event, title){
  jQuery('.location-item').removeClass('active');
  jQuery('.location-item[data-title="'+title+'"]').addClass('active');

  var pos = jQuery('.location-item[data-title="'+title+'"]').offset().top - 100;

  jQuery('html, body').animate({'scrollTop': pos});
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


jQuery('.location-item').click(function(event) {
  if(!jQuery(event.target).closest('a.location-item__more').length){
    var lng = parseFloat(jQuery(this).data('lng'));
    var lat = parseFloat(jQuery(this).data('lat'));
    jQuery('.location-item').removeClass('active');

    jQuery(document.body).trigger('search.map.center', [lat, lng]);
  }
});

var timeout_loc;

jQuery('.search-locations-wrapper .field').on('input',function(){
  var val = jQuery(this).val().toLowerCase();

  // var searches = val.split(' ');
  // console.log(searches);

  var locations = jQuery('.location-item');

  jQuery('.venues-filter__list input').each(function(ind, el){
    jQuery(el).prop({'checked': 0})
  })

  if(val.length  < 3){
    locations.each(function(ind, el){
      jQuery(el).closest('div.js-parent').slideDown();
    })
  }

  if(timeout_loc ){
    clearTimeout(timeout_loc);
  }

  timeout_loc = setTimeout(function(){
    locations.each(function(ind, el){
      var search = jQuery(el).data('search').toLowerCase();

      if(search.indexOf(val) < 0){
        if(jQuery(el).is(':visible')){
          jQuery(el).closest('div.js-parent').slideUp();
        }
      }else{
        if(!jQuery(el).is(':visible')){
          jQuery(el).closest('div.js-parent').slideDown();
        }
      }
    })
  }, 500);
})



jQuery(document).ready(function($) {
  if(jQuery('.service-select').length && 'undefined' !== typeof(link_passed_service)){

    var value = false;
    link_passed_service = link_passed_service.toLowerCase();

    jQuery('.service-select option').each(function(index, el) {
      var val = jQuery(el).val().toLowerCase();

      value = val.indexOf(link_passed_service) >= 0 ? jQuery(el).val() : value;
    });

    if(value){
      jQuery('.service-select').val(value);
    }
  }
});
var locations_selected = {}

var selected_services = [];


function change_filter_checkbox(name, val, obj){

  if('undefined' == typeof(locations_selected[name])){
    locations_selected[name] = [];
  }

  var state = jQuery(obj).prop('checked');

  if(state){
    var ind = locations_selected[name].indexOf(val);

    if(ind < 0){
      locations_selected[name].push(val);
    }

  }else{
    var ind = locations_selected[name].indexOf(val);

    if(ind >= 0){
      locations_selected[name].splice(ind, 1);
    }
  }

  jQuery('.location-items').css({opacity: '.6'});
  setTimeout(function(){
    jQuery(document.body).trigger('filter_locations', [locations_selected])
  }, 50);
}

function change_filter_select(obj){

  var name = jQuery(obj).attr('name');
  var value = jQuery(obj).val();

  if('undefined' == typeof(locations_selected[name])){
    locations_selected[name] = [];
  }


  locations_selected[name] = (value != 'all')? [value] : [];

  console.log(locations_selected)


  jQuery('.location-items').css({opacity: '.6'});
  setTimeout(function(){
    jQuery(document.body).trigger('filter_locations', [locations_selected])
  }, 50);
}

jQuery(document.body).on('filter_locations', function(e,locations_selected){
  var locations = jQuery('.location-item');
  var show_all = true;

  for(id in locations_selected){
    show_all = locations_selected[id].length > 0? false: show_all;
  }
  console.log(locations_selected)
  if(show_all){
    locations.each(function(ind, el){
       jQuery(el).closest('div.js-parent').slideDown();
    })
    setTimeout(function(){
     jQuery('.location-items').css({opacity: '1'});
  }, 50);
    return;
  }

  locations.each(function(ind,el){
    var title    = jQuery(el).data('title');
    var category = jQuery(el).data('category');

    var show_element = true;


    for(var id in locations_selected){
      var param = locations_selected[id];
      var compare_value = jQuery(el).data(id);
      show_element = (param.length > 0 && param.indexOf(compare_value) < 0) ? false : show_element;
    }


    if(show_element){
      jQuery(el).closest('div.js-parent').slideDown();
    }else{
      jQuery(el).closest('div.js-parent').slideUp();
    }
  })

    setTimeout(function(){
     jQuery('.location-items').css({opacity: '1'});
  }, 50);
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


function reloadDate(obj){


  var $form = jQuery(obj).closest('form');
  var data  = $form.serializeArray();


  var _data = {};

  for(id in data){
    _data[data[id].name] = data[id].value;
  }


   var data = {
      prev_url: "",
      should_manage_url: true,
      url: "http://localhost/tcet/?post_type=tribe_events&eventDisplay="+_data.display+"&name=tcet",
      view_data: {'tribe-bar-date':  _data.eventDate},
      _wpnonce: jQuery(document.body).find('.tribe-events-view').data( 'view-rest-nonce' ),

      search_service_term: _data.services_term,
      venue_id:            _data.locations_filter,
    };

    var $container = jQuery(document.body).find('.tribe-events-view');

    window.tribe.events.views.manager.request(data, $container );

    var script = jQuery(document.body).find('[data-js="tribe-events-view-data"]');
    var data    = JSON.parse(jQuery.trim(script.text()));

    window.save_this_data = {
      eventDate:          _data.eventDate,
      services_term:        _data.services_term,
      locations_filter:             _data.locations_filter,
    };
}


jQuery(document.body).on('afterAjaxSuccess.tribeEvents',  '.tribe-events-view', function(e,data, textStatus, jqXHR ){

  for(select_name in window.save_this_data){
    jQuery('select[name='+select_name+']').val(window.save_this_data[select_name]);
  }

})