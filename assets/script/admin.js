  var theme_actions ={

   string_replace: function(needle, highstack){
    var template = highstack;
      for(key in needle){
      var exp = new RegExp("\\{" + key + "\\}", "gi");
        template = template.replace(exp, function(str){
          value = needle[key];
          return value;
        });
      }
      return template;
    },

     formatMoney: function(number, decPlaces, decSep, thouSep) {
      decPlaces = isNaN(decPlaces = Math.abs(decPlaces)) ? 2 : decPlaces,
      decSep = typeof decSep === "undefined" ? "." : decSep;
      thouSep = typeof thouSep === "undefined" ? "," : thouSep;
      var sign = number < 0 ? "-" : "";
      var i = String(parseInt(number = Math.abs(Number(number) || 0).toFixed(decPlaces)));
      var j = (j = i.length) > 3 ? j % 3 : 0;

      return sign +
        (j ? i.substr(0, j) + thouSep : "") +
        i.substr(j).replace(/(\decSep{3})(?=\decSep)/g, "$1" + thouSep) +
        (decPlaces ? decSep + Math.abs(number - i).toFixed(decPlaces).slice(2) : "");
    }
  }

function add_image_block(slug){

   var number = jQuery('.counter_'+slug).val();

   var tmpl = '<div class="image-settings"> <img src="{image_url}" alt=""> <input type="hidden" class="image_id" name="events_images[{slug}][items][{number}]" value="{image_id}"> <a href="javascript:void(0)" class="remove" onclick="remove_image_setting(this)">Remove</a> </div>';


    wp.media.editor.send.attachment = function(props, attachment) {
      var search = {
        image_id: attachment.id,
        slug: slug,
        number: number,
        image_url:attachment.sizes.thumbnail.url
      }

      var html = theme_actions.string_replace(search, tmpl);

      number++;
      jQuery('.counter_'+slug).val(number);
       jQuery('.'+slug).find('.no-images').remove();
      jQuery('.'+slug).append(html);
    };
    wp.media.editor.open();
 }


 function remove_image_setting(obj){
  jQuery(obj).closest('.image-settings').remove();
 }