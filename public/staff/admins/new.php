<?php

require_once('../../../private/initialize.php');

if(is_post_request()) {

  // Create record using post parameters
  $args = $_POST['admin'];
  $admin = new Admin($args);
  $result = $admin->save();

  if($result === true) {
    $new_id = $admin->id;
    $_SESSION['message'] = 'The admin was created successfully.';
    redirect_to(url_for('/staff/admins/show.php?id=' . $new_id));
  } else {
    // show errors
  }

} else {
  // display the form
  $admin = new Admin;
}

?>

<?php $page_title = 'Create Admin'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="content">

  <a class="back-link" href="<?php echo url_for('/staff/admins/index.php'); ?>">&laquo; Back to List</a>

  <div class="admin new">
    <h1>Create Admin</h1>

    <?php echo display_errors($admin->errors); ?>

    <form action="<?php echo url_for('/staff/admins/new.php'); ?>" method="post">

      <?php include('form_fields.php'); ?>

      <div id="operations">
        <input type="submit" value="Create Admin" />
      </div>
    </form>

  </div>

</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
