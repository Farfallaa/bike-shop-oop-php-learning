<?php

require_once('../../../private/initialize.php');

if(is_post_request()) {

  // Create record using post parameters
  $args = $_POST['bicycle'];
  //we want to create a new object from this array
    //then set bicycle objects values to be the same as the ones collected from
    //the form and are written into the associative array:
   $bicycle = new Bicycle($args);
  //we want now this object with all of the params
    //to be saved into the database as a new row
    //in the table by calling a simple function:
    $result = $bicycle->save();

    if($result === true) {
    $new_id = $bicycle->id;
    $_SESSION['message'] = 'The bicycle was created successfully.';
    redirect_to(url_for('/staff/bicycles/show.php?id=' . $new_id));
  } else {
    // show errors
  }

} else {
  // display the form
  $bicycle = new Bicycle;
}

?>

<?php $page_title = 'Create Bicycle'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="content">

  <a class="back-link" href="<?php echo url_for('/staff/bicycles/index.php'); ?>">&laquo; Back to List</a>

  <div class="bicycle new">
    <h1>Create Bicycle</h1>

    <?php echo display_errors($bicycle->errors); ?>

    <form action="<?php echo url_for('/staff/bicycles/new.php'); ?>" method="post">

      <?php include('form_fields.php'); ?>
      
      <div id="operations">
        <input type="submit" value="Create Bicycle" />
      </div>
    </form>

  </div>

</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
