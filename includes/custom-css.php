<?php 

  global $post;

  $tabs_custom_css = get_post_meta ($post->ID, 'tabs_custom_css', true);

 ?>

<div class="inside wpst-tab-settings hidden">
  <table class="form-table">
    <tbody>
      <tr>
        <th scope="row" colspan="6">
          <h3>Enter custom CSS styles:</h3>
        </th>
      </tr>
      
      <tr>
        <td scope="row" colspan="6" class="custom-css">
          <textarea name="tabs_custom_css" id="tabs-custom-css"><?= $tabs_custom_css; ?></textarea> 
        </td>
      </tr>
    </tbody>
  </table>
</div> <!-- .inside -->