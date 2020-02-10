<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by Tankó Péter
 */
?>
<script type="text/javascript">
    var BASE_URL = "<?=base_url()?>";
    var csrfName = '<?= $this->security->get_csrf_token_name(); ?>';
    var csrfHash = '<?= $this->security->get_csrf_hash(); ?>';
</script>
<div class="main">
    <div class="form-group has-search">
        <span class="fa fa-search form-control-feedback"></span>
        <input id="nameSearch" type="text" class="form-control" placeholder="<?= lang('default.00002') ?>">
    </div>
</div>
<div class="row">
    <div class="col-10 mx-auto">
        <div id="hotel-table"></div>
    </div>
</div>