jQuery(window).on('load', function() {

  jQuery('.tabs-menu').each(function(index) {
    // Setup tabs
    var id = index + 1;
    jQuery(this).attr('data-tabs-' + id, '');

    var tabs = new Tabby('[data-tabs-' + id + ']');

  });

  jQuery('[role="tab-vertical"]').on('click', function(e) {
    e.preventDefault();
      
      var $this = jQuery(this);
      var $all_siblings = $this.parent().siblings();
      console.log($all_siblings);
      var $this_link = $this.attr('href');
      var $this_content = jQuery($this_link);

      $all_siblings.find('div').attr('hidden','hidden');
      $this_content.removeAttr('hidden');
  });



});