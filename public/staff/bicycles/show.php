<?php require_once('../../../private/initialize.php'); ?>

<?php

$id = $_GET['id'] ?? '1'; // PHP > 7.0

$bicycle = Bicycle::find_by_id($id);

?>

<?php $page_title = 'Show Bicycle: ' . h($bicycle->name()); ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="content">

  <a class="back-link" href="<?php echo url_for('/staff/bicycles/index.php'); ?>">&laquo; Back to List</a>

  <div class="bicycle show">

    <h1>Bicycle: <?php echo h($bicycle->name()); ?></h1>

    <div class="attributes">
      <dl>
        <dt>Brand</dt>
        <dd><?php echo h($bicycle->brand); ?></dd>
      </dl>
      <dl>
        <dt>Model</dt>
        <dd><?php echo h($bicycle->model); ?></dd>
      </dl>
      <dl>
        <dt>Year</dt>
        <dd><?php echo h($bicycle->year); ?></dd>
      </dl>
      <dl>
        <dt>Category</dt>
        <dd><?php echo h($bicycle->category); ?></dd>
      </dl>
      <dl>
        <dt>Color</dt>
        <dd><?php echo h($bicycle->color); ?></dd>
      </dl>
      <dl>
        <dt>Gender</dt>
        <dd><?php echo h($bicycle->gender); ?></dd>
      </dl>
      <dl>
        <dt>Weight</dt>
        <dd><?php echo h($bicycle->weight_kg()) . ' / ' . h($bicycle->weight_lbs()); ?></dd>
      </dl>
      <dl>
        <dt>Condition</dt>
        <dd><?php echo h($bicycle->condition()); ?></dd>
      </dl>
      <dl>
        <dt>Price</dt>
        <dd><?php echo h($bicycle->price); ?></dd>
      </dl>
      <dl>
        <dt>Description</dt>
        <dd><?php echo h($bicycle->description); ?></dd>
      </dl>
    </div>

  </div>

</div>
