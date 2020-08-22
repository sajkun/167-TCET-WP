<?php
if ( ! defined( 'ABSPATH' ) ) {
  die( '-1' );
}
?>

<div class="venues-filter">
  <h3 class="venues-filter__title">
    Filter Search
    <i class="venues-filter__icon">
      <svg width="22" height="15" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:avocode="https://avocode.com/" viewBox="0 0 22 15"><defs></defs><desc>Generated with Avocode.</desc><g><g><title>Rectangle 216</title><path d="M13.64565,6.75056v0h-7.40604v0v-3.92084v0h7.40604v0z" fill="#776e64" fill-opacity="1"></path></g><g><title>Polygon 7</title><path d="M0.57617,4.79013v0l7.40604,-4.57432v0v9.14863v0z" fill="#776e64" fill-opacity="1"></path></g><g><title>Group 133</title><g><title>Polygon 7</title><path d="M0.57617,4.79013v0l7.40604,-4.57432v0v9.14863v0z" fill="#776e64" fill-opacity="1"></path></g><g><title>Rectangle 216</title><path d="M13.64565,6.75056v0h-7.40604v0v-3.92084v0h7.40604v0z" fill="#776e64" fill-opacity="1"></path></g></g><g><title>Rectangle 215</title><path d="M9.04201,7.81038v0h7.40604v0v3.92084v0h-7.40604v0z" fill="#776e64" fill-opacity="1"></path></g><g><title>Polygon 6</title><path d="M22.11149,9.7708v0l-7.40604,4.57432v0v-9.14863v0z" fill="#776e64" fill-opacity="1"></path></g><g><title>Group 134</title><g><title>Polygon 6</title><path d="M22.11149,9.7708v0l-7.40604,4.57432v0v-9.14863v0z" fill="#776e64" fill-opacity="1"></path></g><g><title>Rectangle 215</title><path d="M9.04201,7.81038v0h7.40604v0v3.92084v0h-7.40604v0z" fill="#776e64" fill-opacity="1"></path></g></g><g><title>Group 513</title><g><title>Group 134</title><g><title>Polygon 6</title><path d="M22.11149,9.7708v0l-7.40604,4.57432v0v-9.14863v0z" fill="#776e64" fill-opacity="1"></path></g><g><title>Rectangle 215</title><path d="M9.04201,7.81038v0h7.40604v0v3.92084v0h-7.40604v0z" fill="#776e64" fill-opacity="1"></path></g></g><g><title>Group 133</title><g><title>Polygon 7</title><path d="M0.57617,4.79013v0l7.40604,-4.57432v0v9.14863v0z" fill="#776e64" fill-opacity="1"></path></g><g><title>Rectangle 216</title><path d="M13.64565,6.75056v0h-7.40604v0v-3.92084v0h7.40604v0z" fill="#776e64" fill-opacity="1"></path></g></g></g></g></svg>
    </i>
  </h3>
 <div class="spacer-h-10 spacer-h-lg-0"></div>
  <div class="row show-tablet">
    <div class="col-12 col-sm-6 col-md-12">
      <label class="label-location">Location</label>
      <select name="title" class="select-location" onchange="change_filter_select(this)">
        <option value="all">All Locations</option>
       <?php foreach ($names as $key => $name):
          if (!$name){ continue;}
         ?>
         <option value="<?php echo $name ?>"><?php echo $name ?></option>
         <?php endforeach ?>
      </select>
      <div class="spacer-h-10"></div>
    </div>
    <div class="col-12 col-sm-6 col-md-12">
      <label class="label-location">Location</label>
      <select name="category" " class="select-location" onchange="change_filter_select(this)">
         <option value="all">All Services</option>
         <?php foreach ($categories as $key => $name):
           if (!$name){ continue;}
          ?>
          <option value="<?php echo $name ?>"><?php echo $name ?></option>
         <?php endforeach ?>
      </select>
      <div class="spacer-h-30"></div>
    </div>
  </div>

  <div class="venues-filter__item expanded hide-tablet">
    <h4 class="venues-filter__item-title">Location <span class="marker"></span></h4>


    <div class="venues-filter__item-body" <?php echo 'style="display:block"'; ?> >
      <ul class="venues-filter__list">
        <?php foreach ($names as $key => $name):
          if (!$name){ continue;}
         ?>
        <li>
          <label class="radio-imitation">
            <input type="radio" name="title" value="<?php echo $name ?>" onchange="change_filter_checkbox('title', '<?php echo $name ?>', this)">
            <span class="radio-imitation__view"></span>
            <span class="radio-imitation__text"><?php echo $name ?></span>
          </label>
        </li>
        <?php endforeach ?>
      </ul>
    </div>
  </div>

  <div class="venues-filter__item hide-tablet">
    <h4 class="venues-filter__item-title">Services <span class="marker"></span></h4>

    <div class="venues-filter__item-body">
      <ul class="venues-filter__list">
        <?php foreach ($categories as $key => $name):
           if (!$name){ continue;}
          ?>

        <li>
          <label class="radio-imitation" >
            <input type="radio" name="category" value="<?php echo $name ?>"  onchange="change_filter_checkbox('category', '<?php echo $name ?>', this)">
            <span class="radio-imitation__view"></span>
            <span class="radio-imitation__text"><?php echo $name ?></span>
          </label>
        </li>
        <?php endforeach ?>
      </ul>
    </div>
  </div>
</div>