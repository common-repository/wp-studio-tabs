<div class="inside">
<div id="postbox-container" class="postbox-container">
<div id="normal-sortables" class="meta-box-sortables ui-sortable">
<div id="wpst-tab-group" class="postbox">
<div class="wpst-tabs-list-wrap">
<div class="inside wpst-tabs-list-header">

<ul class="wpst-table-head">
  <li class="tab-order tab-label">Order</li>
  <li class="tab-label tab-label">Tab Label</li>
  <li class="tab-slug tab-label">Tab Content</li>
  <li class="tab-type tab-label">Active?</li>
</ul>

<div class="tabs-field-list ui-sortable">

<?php

$tabs_order = get_post_meta($post->ID, 'wpst_tabs_order', true);
$tabs_order_array = explode(',', $tabs_order);
$started = false;
$array = array();
$i = 0;

function limit_text($text, $limit) {
if (str_word_count($text, 0) > $limit) {
  $words = str_word_count($text, 2);
  $pos = array_keys($words);
  $text = substr($text, 0, $pos[$limit]) . '...';
}
return $text;
} 

foreach ($tabs_order_array as $ordered_tab):

$value = uniqid('tab-', false);

if (!in_array($value, $array)):
  $array[] = $value;
endif; 

$id = !empty($ordered_tab) ? $ordered_tab : 'tab-1';
$wpst_tab_id = get_post_meta($post->ID, 'wpst_tab_id_'.$id, true);
$wpst_tab_label = get_post_meta($post->ID, 'wpst_tab_label_'.$id, true);
$wpst_tab_content = get_post_meta($post->ID, 'wpst_tab_content_'.$id, true);
$wpst_tab_active = get_post_meta($post->ID, 'wpst_tab_active', true); ?>

<div style="display:none" class="no-tabs-message">
  <ul class="wpst-table-body">
    <li style="width:100%">
      <div class="no-fields-message">No tabs have been added yet. Click the <strong>+ Add Tab</strong> button to create your first tab.</div>
    </li>
  </ul> <!-- .wpst-table-body -->
</div> <!-- .tabs-field-object --> 

<div id="<?= $id; ?>" class="tabs-field-object">
  <div class="handle">
    <ul class="wpst-table-body">
      <li class="tab-label"><span class="tabs-order-icon tabs-sortable-handle ui-sortable-handle" title="Drag to reorder">+</span><input type="hidden" name="wpst_tab_id_<?= (!empty($wpst_tab_id) ? esc_attr($wpst_tab_id) : esc_attr($id)); ?>" value="<?= (!empty($wpst_tab_id) ? esc_attr($wpst_tab_id) : esc_attr($id)); ?>" /></li>
      <li class="tab-label label-edit-field">
        <strong><a class="edit-field" title="Edit field" href="#"><?= !empty($wpst_tab_label) ? esc_html($wpst_tab_label) : 'Sample Tab'; ?></a></strong>
        <div class="row-options"><a class="edit-field" title="Edit field" href="#">Edit</a><a class="delete-field" title="Delete field" href="#">Delete</a></div>
      </li>
      
      <li class="tab-label"><?= (empty($wpst_tab_content) ? 'Tab content will be placed here.' : esc_html(limit_text($wpst_tab_content, 50))); ?></li>
      <li class="tab-label"><input type="radio" <?= ($wpst_tab_active=='wpst_tab_active_'.$id ? 'checked' : '').' name="wpst_tab_active" value="'.esc_attr('wpst_tab_active_'.$id); ?>" /></li>
    </ul>

    <div class="wpst-tabs-settings">
      <table class="wpst-settings-table">
        <tbody>
          <tr>
            <td class="setting-label" style="background-color:#f9f9f9">
              <div class="field-inside">
                <label for="tabs-name"><strong>Tab Label</strong></label>
                <p class="description">This displays as your tab name</p>
              </div>
            </td>
            <td class="setting-input" style="background-color:#fff">
              <div class="field-inside">
                <input class="wpst-tab-label" name="wpst_tab_label_<?= esc_attr($id); ?>" value="<?= esc_attr($wpst_tab_label); ?>" />
              </div>
            </td>
          </tr>

          <tr>
            <td class="setting-label" style="background-color:#f9f9f9">
              <div class="field-inside">
                <label for="tabs-name"><strong>Tab Content</strong></label>
                <p class="description">This displays as your tab content.</p>
              </div>
            </td>
            <td class="setting-input" style="background-color:#fff">
              <div class="field-inside">
                <textarea style="width:100%" class="wpst-tab-content" name="wpst_tab_content_<?= esc_attr($id); ?>" /><?= esc_attr($wpst_tab_content); ?></textarea>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
                  
<?php if ($started == false): ?>

<script>

function uniqid(a='tab-', b = false){
  var c = Date.now()/1000;
  var d = c.toString(16).split('.').join('');
  while(d.length < 14){
    d += '0';
  }
  var e = '';
  if(b){
    e = '.';
    var f = Math.round(Math.random()*100000000);
    e += f;
  }
  return a + d + e;
}

jQuery(document).ready(function($) {
  $('.add-tab').on('click', function(e) {
    var tab_active = '<?= esc_attr($wpst_tab_active); ?>';
    var wpst_tab_content = '<?= esc_html($wpst_tab_content); ?>';
    var count = $(document).find('.tabs-field-object').length;
    var next = count + 1;
    var id = uniqid();

    e.preventDefault();

    $('.tabs-field-list').prepend(`
    <div id="`+id+`" class="tabs-field-object">
      <div class="handle">
        <ul class="wpst-table-body">
          <li class="tab-label">
            <span class="tabs-order-icon tabs-sortable-handle" title="Drag to reorder">+</span>
          </li>
          <li class="tab-label label-edit-field">
            <strong>
              <a class="edit-field" title="Edit field" href="#">Sample Tab</a>
            </strong>
            <div class="row-options">
              <a class="edit-field" title="Edit field" href="#">Edit</a>
              <a class="delete-field" title="Delete field" href="#">Delete</a>
            </div>
          </li>
          <li class="tab-label"></li>
          <li class="tab-label"><input type="radio" `+ (tab_active=='wpst_tab_active_'.id ? 'checked' : '')+` name="wpst_tab_active" value="wpst_tab_active_`+id+`" /></li>
        </ul>

        <div class="wpst-tabs-settings">
          <table class="tabs-table">
            <tbody>
              <tr>
                <td class="setting-label" style="background-color:#f9f9f9">
                  <div class="field-inside">
                    <label for="tabs-name"><strong>Tab Label</strong></label>
                    <p class="description">This displays as your tab name</p>
                  </div>
                </td>
                <td class="setting-input" style="background-color:#fff">
                  <div class="field-inside">
                    <input class="wpst-tab-label" name="wpst_tab_label_`+id+`" value="" />
                  </div>
                </td>
              </tr>

              <tr>
                <td class="setting-label" style="background-color:#f9f9f9">
                  <div class="field-inside">
                    <label for="tabs-name"><strong>Tab Content</strong></label>
                    <p class="description">This displays as your tab content.</p>
                  </div>
                </td>
                <td class="setting-input" style="background-color:#fff">
                  <div class="field-inside">
                    <textarea style="width:100%" class="wpst-tab-content" name="wpst_tab_content_`+id+`"></textarea>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div> 
    </div>`); 

    $('.tabs-field-list').on('sortupdate',function() {
      var newOrder = $(this).sortable('toArray').toString();
      $.post("post.php", {order: newOrder});
      $('#order').val(newOrder);
    });

    // Update the sortable order when deleting a tab
    $('.tabs-field-list').trigger('sortupdate');
    });
  });
</script>

<?php $started = true; endif; $i++; endforeach; ?>

</div> <!-- .tab-field-list -->

<ul class="acf-hl acf-tfoot wpst-tabs-footer">
  <li class="">
    <a href="#" class="button button-primary button-large add-tab">+ Add Tab</a>
  </li>
</ul>

<input type="hidden" id="order" name="wpst_tabs_order" value="<?= esc_attr(implode(',', get_post_meta($post->ID, 'wpst_tabs_order', false))); ?>" />

</div> <!-- .inside -->
</div> <!-- .wpst-tabs-list-wrap -->
</div> <!-- .wpst-tab-group --> 
</div> <!-- .meta-box-sortables --> 
</div> <!-- .postbox-container -->
</div> <!-- .inside -->