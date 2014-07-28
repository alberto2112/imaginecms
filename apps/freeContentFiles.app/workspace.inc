<?php
  global $_CURRENT;
  includeLib('filesystem');
  require_once('vars.inc');
?>
<!-- freeContentFiles - Workspace -->
<div class="fcf_workspace">

<!-- List Of Files -->
<div class="fcf_lof">
  <ul>
  <?php include('inc/list_of_files.inc'); ?>
  </ul>
</div>
<!-- End List Of Files -->

<!-- File editor -->
<div class="fcf_editor_wrapper">
  <div class="fcf_editor_tools"></div>
  <!-- File editor: textarea -->
  <div class="fcf_editor">
    <?php include('inc/read_file.inc'); ?>
  </div>
  <!-- End File editor: textarea -->
</div>
<!-- End File editor -->

</div>
<!-- End freeContentFiles - Workspace -->