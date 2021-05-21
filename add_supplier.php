<?php
  $page_title = 'Add Product';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(2);
  $all_categories = find_all('categories');
  $all_photo = find_all('media');
?>
<?php
 if(isset($_POST['add_supplier'])){
   $req_fields = array('supplier-name','contact-no');
   validate_fields($req_fields);
   if(empty($errors)){
     $s_name  = remove_junk($db->escape($_POST['supplier-name']));
     $s_con   = remove_junk($db->escape($_POST['contact-no']));
     
    
     $query  = "INSERT INTO supplier (";
     $query .=" supplier_name,contact_no";
     $query .=") VALUES (";
     $query .=" '{$s_name}', '{$s_con}'";
     $query .=")";
     
     if($db->query($query)){
       $session->msg('s',"Supplier added ");
       redirect('add_supplier.php', false);
     } else {
       $session->msg('d',' Sorry failed to added!');
       redirect('supplier.php', false);
     }

   } else{
     $session->msg("d", $errors);
     redirect('add_supplier.php',false);
   }

 }

?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-12">
    <?php echo display_msg($msg); ?>
  </div>
</div>
  <div class="row">
  <div class="col-md-8">
      <div class="panel panel-default">
        <div class="panel-heading">
          <strong>
            <span class="glyphicon glyphicon-th"></span>
            <span>Add New Supplier</span>
         </strong>
        </div>
        <div class="panel-body">
         <div class="col-md-12">
          <form method="post" action="add_supplier.php" class="clearfix">
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-th-large"></i>
                  </span>
                  <input type="text" class="form-control" name="supplier-name" placeholder="Supplier name">
               </div>
              </div>


		<div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-th-large"></i>
                  </span>
                  <input type="text" class="form-control" name="contact-no" placeholder="Contact number">
               </div>
              </div>



             
              <button type="submit" name="add_supplier" class="btn btn-danger">Add Supplier</button>
          </form>
         </div>
        </div>
      </div>
    </div>
  </div>

<?php include_once('layouts/footer.php'); ?>
