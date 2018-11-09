<?php

require_once('../../../private/initialize.php');

if(!isset($_GET['id'])) {
  redirect_to(url_for('/staff/admins/index.php'));
}
$id = $_GET['id'];
$admin = Admin::find_by_id($id);
if($admin == false) {
  redirect_to(url_for('/staff/admins/index.php'));
}

if(is_post_request()) {

  // Save record using post parameters
  $args = $_POST['admin'];
  $admin->merge_attributes($args);
  $result = $admin->save();

  if($result === true) {
    $_SESSION['message'] = 'The admin was updated successfully.';
    redirect_to(url_for('/staff/admins/show.php?id=' . $id));
  } else {
    // show errors
  }

} else {

  // display the form

}

?>

<?php $page_title = 'Edit Admin'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="content">

  <a class="back-link" href="<?php echo url_for('/staff/admins/index.php'); ?>">&laquo; Back to List</a>

  <div class="admin edit">
    <h1>Edit Admin</h1>

    <?php echo display_errors($admin->errors); ?>

    <form action="<?php echo url_for('/staff/admins/edit.php?id=' . h(u($id))); ?>" method="post">

      <?php include('form_fields.php'); ?>

      <div id="operations">
        <input type="submit" value="Edit Admin" />
      </div>
    </form>

  </div>

</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
