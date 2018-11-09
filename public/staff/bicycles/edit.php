<?php

require_once('../../../private/initialize.php');

if(!isset($_GET['id'])) {
  redirect_to(url_for('/staff/bicycles/index.php'));
}
$id = $_GET['id'];
$bicycle = Bicycle::find_by_id($id);
if($bicycle == false){
    redirect_to(url_for('/staff/bicycles/index.php'));
}

if(is_post_request()) {

  // Save record using post parameters
  $args = $_POST['bicycle'];
    //we need a method to merge attributes in a way
    //that the bicycle object would have the form
    ////values  but not the database values anymore.
  $bicycle->merge_attributes($args);
  //we will tell the bicycle to update and this will
    //save those values back to the database.
  $result = $bicycle->save();


  if($result === true) {
    $_SESSION['message'] = 'The bicycle was updated successfully.';
    redirect_to(url_for('/staff/bicycles/show.php?id=' . $id));
  } else {
    // show errors
  }

} else {

  // display the form

}

?>

<?php $page_title = 'Edit Bicycle'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="content">

  <a class="back-link" href="<?php echo url_for('/staff/bicycles/index.php'); ?>">&laquo; Back to List</a>

  <div class="bicycle edit">
    <h1>Edit Bicycle</h1>

    <?php echo display_errors($bicycle->errors); ?>

    <form action="<?php echo url_for('/staff/bicycles/edit.php?id=' . h(u($id))); ?>" method="post">

      <?php include('form_fields.php'); ?>
      
      <div id="operations">
        <input type="submit" value="Edit Bicycle" />
      </div>
    </form>

  </div>

</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
