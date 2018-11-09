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

  // Delete bicycle
    $result= $bicycle->delete();


  $_SESSION['message'] = 'The bicycle was deleted successfully.';
  redirect_to(url_for('/staff/bicycles/index.php'));

} else {
  // Display form
}

?>

<?php $page_title = 'Delete Bicycle'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="content">

  <a class="back-link" href="<?php echo url_for('/staff/bicycles/index.php'); ?>">&laquo; Back to List</a>

  <div class="bicycle delete">
    <h1>Delete Bicycle</h1>
    <p>Are you sure you want to delete this bicycle?</p>
    <p class="item"><?php echo h($bicycle->name()); ?></p>

    <form action="<?php echo url_for('/staff/bicycles/delete.php?id=' . h(u($id))); ?>" method="post">
      <div id="operations">
        <input type="submit" name="commit" value="Delete Bicycle" />
      </div>
    </form>
  </div>

</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
