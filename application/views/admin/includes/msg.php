<?php if(validation_errors()){ ?>
<div class="alert alert-danger alert-dismissable">
   <?php  echo validation_errors(); ?>
   <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
</div>
<?php } ?>

<?php //echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>

<?php $success = $this->session->flashdata('success');
if($success){?>
<div class="alert alert-success alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <?php echo $this->session->flashdata('success'); ?>
</div>
<?php } ?>
<?php $error = $this->session->flashdata('error');
if($error){?>
<div class="alert alert-danger alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <?php echo $this->session->flashdata('error'); ?>
</div>
<?php } ?>