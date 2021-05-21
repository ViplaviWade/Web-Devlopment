<?php
  $page_title = 'Edit Order';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(2);
?>
<?php
$suporder = find_by_id('suporder',(int)$_GET['id']);
//$all_categories = find_all('categories');
//$all_photo = find_all('media');
if(!$suporder){
  $session->msg("d","Missing supplier id.");
  redirect('viewsuporder.php');
}
?>
<?php
 if(isset($_POST['product'])){
    $req_fields = array('status');
    validate_fields($req_fields);

   if(empty($errors)){
       $status  = remove_junk($db->escape($_POST['status']));
       $date   = $_POST['date'];
	$pId= remove_junk($db->escape($_POST['pid']));
	$q= remove_junk($db->escape($_POST['quantity']));
              $query   = "UPDATE suporder SET";
       $query  .=" status ='{$status}', dateofarrival ='{$date}'";
      
       $query  .=" WHERE id ='{$suporder['id']}'";
       $result = $db->query($query);
               if($result && $db->affected_rows() === 1){
                 $session->msg('s',"Order updated ");
                

		//$q=$suporder['quantity'];
		if(add_product_qty($q,$pId)){
		 redirect('viewsuporder.php', false);
		$session->msg('s',"product updated ");		
		}else{
			$session->msg('s',"product not updated ");		
			}




               } else {
                 $session->msg('d',' Sorry failed to update!');
                 redirect('editsuporder.php?id='.$suporder['id'], false);
               }

   } else{
       $session->msg("d", $errors);
       redirect('editsuporder.php?id='.$suporder['id'], false);
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
      <div class="panel panel-default">
        <div class="panel-heading">
          <strong>
            <span class="glyphicon glyphicon-th"></span>
            <span>Update Order</span>
         </strong>
        </div>
        <div class="panel-body">
         <div class="col-md-7">
           <form method="post" action="editsuporder.php?id=<?php echo (int)$suporder['id'] ?>">
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-th-large"></i>
                  </span>
                  <input type="text" class="form-control" name="status" value="<?php echo remove_junk($suporder['status']);?>">
               </div>
              </div>
              
<div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-th-large"></i>
                  </span>
                  <input type="date" class="form-control datepicker" name="date" data-date-format="" value="<?php echo remove_junk($suporder['dateofarrival']); ?>">
               </div>
              </div>
<input type="hidden"  name="pid" value="<?php echo $suporder['pid'];?>">
<input type="hidden"  name="quantity" value="<?php echo $suporder['quantity'];?>">

             
              <button type="submit" name="product" class="btn btn-danger">Update</button>
          </form>
         </div>
        </div>
      </div>
  </div>

<?php include_once('layouts/footer.php'); ?>
