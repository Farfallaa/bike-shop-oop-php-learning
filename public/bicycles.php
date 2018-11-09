<?php require_once('../private/initialize.php'); ?>

<?php $page_title = 'Inventory'; ?>
<?php include(SHARED_PATH . '/public_header.php'); ?>

<div id="main">

  <div id="page">
    <div class="intro">
      <img class="inset" src="<?php echo url_for('/images/AdobeStock_55807979_thumb.jpeg') ?>" />
      <h2>Our Inventory of Used Bicycles</h2>
      <p>Choose the bike you love.</p>
      <p>We will deliver it to your door and let you try it before you buy it.</p>
    </div>

    <table id="inventory">
      <tr>
        <th>Brand</th>
        <th>Model</th>
        <th>Year</th>
        <th>Category</th>
        <th>Gender</th>
        <th>Color</th>
        <th>Price</th>
        <th>&nbsp;</th>
      </tr>
        <?php
        //instantiate the parse csv:
//        $parser = new ParseCSV(PRIVATE_PATH. '/used_bicycles.csv');
//        $bike_array = $parser->parse();
        //instead of parsing use the array that you get
        //from find all  function in bicycle class
        //so that from now on the data will be taken
        //not from the csv file but from the database itself:
        $bikes = Bicycle::find_all();

//        print_r($bike_array);
        //now you need to loop through the bike array
        //and by taking each row at a time create a new
        //instance of a Bicycle class.

        //1. create an array of arguments to pass into it:
//        $args = ['brand' => 'Trek', 'model' => 'Emonda', 'year' => 2017, 'gender' => 'Unisex', 'color' => 'Black', 'weight_kg' => 1.5, 'price' => 1000.00, 'category' => 'Road'];
        //2.create a new bicycle and pass above args into it:


        //now you need to loop through the bike array
        //and by taking each row at a time create a new
        //instance of a Bicycle class.
        ?>
        <?php foreach($bikes as $bike){
//        $bike = new Bicycle($args); ?>
      <tr>
        <td><?php echo h($bike->brand); ?></td>
        <td><?php echo h($bike->model); ?></td>
        <td><?php echo h($bike->year); ?></td>
        <td><?php echo h($bike->category); ?></td>
        <td><?php echo h($bike->gender); ?></td>
        <td><?php echo h($bike->color); ?></td>
        <td><?php echo h('$'.$bike->price); ?></td>
        <td><a href="detail.php?id=<?php echo $bike->id; ?>">View</a></td>
      </tr>
        <?php } ?>
    </table>


      <?php

      //see how database works
      //$sql = "SELECT * FROM bicycles";
      //bicycle class, go to your public static database variable
      //and there you should find the database connection
      //and we will tell this database connection to form this
      //query.
      //next step is actually move the actual query into
      //the class itself so that instead of calling a query
      //we could call a method that calls a query in the class.
      //$result= Bicycle::$database->query($sql);
      //to follow the active record pattern we need
      //the find all to bring back an array of objects
      //prepopulated with correct values. Therefore
      //Im moving the below to the class itself.
        //      $bikes = Bicycle::find_all();
        //      $row = $result->fetch_assoc();
      ////      $result->free();






      ?>
  </div>

</div>

<?php include(SHARED_PATH . '/public_footer.php'); ?>
