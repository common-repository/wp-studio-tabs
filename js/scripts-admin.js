(function( $ ) {

  'use strict'
 
  $(function() {
    // Grab the wrapper for the Navigation Tabs
    var navTabs = $( '#wp-simple-tabs-nav').children( '.nav-tab-wrapper' ), tabIndex = null;

    navTabs.children().each(function() {

      $( this ).on( 'click', function( evt ) {

        evt.preventDefault();

        // If this tab is not active...
        if ( ! $( this ).hasClass( 'nav-tab-active' ) ) {
          // Unmark the current tab and mark the new one as active
          $( '.nav-tab-active' ).removeClass( 'nav-tab-active' );
          $( this ).addClass( 'nav-tab-active' );

          // Save the index of the tab that's just been marked as active. It will be 0 - 3.
          tabIndex = $( this ).index();

          // Hide the old active content
          $( '#wp-simple-tabs-nav' )
              .children( 'div:not( .inside.hidden )' )
              .addClass( 'hidden' );

          $( '#wp-simple-tabs-nav' )
              .children( 'div:nth-child(' + ( tabIndex ) + ')' )
              .addClass( 'hidden' );

          // And display the new content
          $( '#wp-simple-tabs-nav' )
              .children( 'div:nth-child( ' + ( tabIndex + 2 ) + ')' )
              .removeClass( 'hidden' );
        }
      });
    });
  });
 
})( jQuery );

// Color Picker
jQuery(document).ready(function($) {
  $(function() {
    $('.color-field').wpColorPicker();
  });  
}); //jQuery

jQuery(document).ready(function($) {
  $(document).on('click', '.delete-field', function(e) {
    var count = $(document).find('.tabs-field-object').length;
    e.preventDefault();
    $(this).parent().parent().parent().parent().parent().next('.tabs-field-settings').remove();
    $(this).parent().parent().parent().parent().parent().remove();
    
    count--;

    $('.tabs-field-list').on('sortupdate',function() {
      var newOrder = $(this).sortable('toArray').toString();
      $.post("post.php", {order: newOrder});
      $('#order').val(newOrder);
    });

    // Update the sortable order when deleting a tab
    $('.tabs-field-list').trigger('sortupdate');
  });
});

// Add sorting functionality to the Tab Options metabox
jQuery(document).ready(function($) {    
  $('.tabs-field-list').sortable({
      cursor: 'move',
      //handle: '.handle',
      //helper: 'clone',
      opacity: 0.7,
      items: ".tabs-field-object:not(.unsortable)",
      //items: '.tabs-field-object:not(.unsortable)',
      update: function(event,ui) {
        var newOrder = $(this).sortable('toArray').toString();
        $.post("post.php", {order: newOrder});
        $('#order').val(newOrder);
      },
  });
  $('.tabs-field-list').disableSelection();
});

jQuery(document).ready(function($) {
  $('input').on('click', function() {
    $(this).closest('.tabs-field-object').addClass('unsortable');
  });
});

jQuery(document).ready(function($) {
  $(document).on('click', '.label-edit-field', function(e) {
    e.preventDefault();
    var parent = $(this).parent().parent().parent();
  
    if (parent.hasClass('open')) {
      parent.removeClass('open');
      parent.find('.wpst-tabs-settings').slideUp('medium');
    } else {
      parent.addClass('open');
      parent.find('.wpst-tabs-settings').slideDown('medium');
    }
  });
});