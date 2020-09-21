var style = '<style> .tribe-events .tribe-events-c-events-bar__views {display: none!important; flex: none; } .event-list__more { display: none !important; } .event-list__service-marker { display: none !important; } .event-list__title { line-height: 20px !important; font-size: 18px !important; font-weight: 700 !important;} .event-list__address { line-height: 20px !important; font-size: 18px !important; margin: 0 0 0px !important;} .event-list__date  { line-height: 20px !important; font-size: 18px !important; } .event-list__time { line-height: 20px !important; font-size: 18px !important; } .event-list { margin: 0 0 40px !important; } .tribe-common--breakpoint-medium.tribe-events .tribe-events-header { display: none !important; } .tribe-events-c-nav__next-label  { display: none !important; } .export-events  { display: none !important; } .tribe-events-c-nav__next  { display: none !important; } #real-accessability a#real-accessability-btn { display: none !important; } .event-meta-text {font-size: 16px; line-height: 20px; } .single-event-meta-title {height: 20px !important; font-size: 18px !important; } .event-meta-text.service {display: none; } .spacer-h-20 {height: 0px !important; } .spacer-h-30 {height: 10px!important; } .sinle-event__sideinfo dd {font-size: 16px; } .sinle-event__sideinfo address {font-size: 16px !important; line-height: 20px; } .event-meta-text .icon-label {display: none; } #real-accessability a#real-accessability-btn {display: none; } .events-line {margin: 5px 0; } </style> ';

  var image = '<img src="/wp-content/uploads/2020/05/logo.png" style="height: 45px; width:auto">';

function print_pdf(id){

  var obj = jQuery('#tribe-events-content').clone();

  obj.find('.tribe-events-cal-links').remove();
  obj.find('img').remove();
  obj.find('.social-share').remove();
  obj.find('.events-line').remove();
  obj.find('form').remove();
  obj.find('.col-lg-8').addClass('col-12').removeClass('col-lg-8');
  obj.find('.col-lg-4').addClass('col-12').removeClass('col-lg-4');
  obj.find('.tribe-events-address').find('.event-meta-text').remove();
  obj.find('.eligibility-title').closest('.row').after('<div class="html2pdf__page-break"></div>');

  var element = obj.html();
  element = image + element + style;

  var opt = {
    margin:       .4,
    filename:     ('undefined' !== typeof(tribe_event_title))? tribe_event_title : 'event.pdf',
    image:        { type: 'jpeg', quality: 0.98 },
    html2canvas:  { scale: 2 },
    jsPDF:        { unit: 'in', format: 'A4', orientation: 'portrait' }
  };

  html2pdf().from(element).set(opt).save();
}


function print_pdf_list(){
  var obj = jQuery('.tribe-events-calendar-list').clone();

  obj.find('.event-list__more').remove();

  var childs = obj.find('.event-list');

  obj.addClass('print_style');



  childs.each(function(index, el) {
    if((index + 1) % 4 == 0 && index> 0){
      // jQuery(el).after('<div class="html2pdf__page-break"></div>');
    }
  });

  var element = obj.html();

  var print_element = image + element + style;

  var opt = {
    margin:       .4,
    filename:     ('undefined' !== typeof(tribe_event_title))? tribe_event_title : 'events.pdf',
    image:        { type: 'jpeg', quality: 0.98 },
    html2canvas:  { scale: 2 },
    jsPDF:        { unit: 'in', format: 'A4', orientation: 'portrait' }
  };

  html2pdf().from(print_element).set(opt).save();
}

console.log('test');