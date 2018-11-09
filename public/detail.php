<?php require_once('../private/initialize.php'); ?>

<?php

// Get requested ID

$id = $_GET['id'] ?? false;

if(!$id) {
    redirect_to('bicycles.php');
}

// Find bicycle using ID

$bike = Bicycle::find_by_id($id);

?>


<?php $page_title = 'Detail: '. $bike->name(); ?>
<?php include(SHARED_PATH . '/public_header.php'); ?>

<div id="main">

  <a href="bicycles.php">Back to Inventory</a>

  <div id="page">

    <div class="detail">
      <dl>
        <dt>Brand</dt>
        <dd><?php echo h($bike->brand); ?></dd>
      </dl>
      <dl>
        <dt>Model</dt>
        <dd><?php echo h($bike->model); ?></dd>
      </dl>
      <dl>
        <dt>Year</dt>
        <dd><?php echo h($bike->year); ?></dd>
      </dl>
      <dl>
        <dt>Category</dt>
        <dd><?php echo h($bike->category); ?></dd>
      </dl>
      <dl>
        <dt>Gender</dt>
        <dd><?php echo h($bike->gender); ?></dd>
      </dl>
      <dl>
        <dt>Color</dt>
        <dd><?php echo h($bike->color); ?></dd>
      </dl>
      <dl>
        <dt>Weight</dt>
        <dd><?php echo h($bike->weight_kg()) . ' / ' . h($bike->weight_lbs()); ?></dd>
      </dl>
      <dl>
        <dt>Condition</dt>
        <dd><?php echo h($bike->condition()); ?></dd>
      </dl>
      <dl>
        <dt>Price</dt>
        <dd><?php echo h($bike->price); ?></dd>
      </dl>
      <dl>
        <dt>Description</dt>
        <dd><?php echo h($bike->description); ?></dd>
      </dl>
    </div>

  </div>

</div>

<?php include(SHARED_PATH . '/public_footer.php'); ?>
