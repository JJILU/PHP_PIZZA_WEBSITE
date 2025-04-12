<?php
  //  required & included statements  
  require_once('config/base_url.php');
  include('config/db_connect.php');

  $email = $title = $ingredients = $price = "";


  // get id to update pizza data
  if (isset($_GET['id'])) {
    
    // connect to db
    $id_to_update = mysqli_real_escape_string($coon,$_GET['id']);

    // make sql query 
    $sql = "SELECT * FROM pizzas WHERE id = $id_to_update";

    // make the query
    $result = mysqli_query($coon, $sql);

    // transform to associate array
    $pizza = mysqli_fetch_assoc($result);

    // free result from memory
    mysqli_free_result($result);

    // close db connection
    mysqli_close($coon);

    // print_r($pizza);
  }
  
  
  
  if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $email = $_POST['email'];
    $title = $_POST['title'];
    $ingredients = $_POST['ingrediants'];
    $price = $_POST['price'];

    echo $email . " " . $title . " " . $ingredients . " " . $price . " " . $id;

    


    // connect to db
    $id_update = mysqli_real_escape_string($coon, $_POST['id']);


    // make sql query : NOT SAFE ENOUGH
    // $sql = "UPDATE pizzas SET 
    // email='$email',title='$title',
    //  ingredients='$ingredients', 
    //  price='$price', 
    //  updated_at=NOW()
    // WHERE id = $id_to_update";


    // prepare statements
    $sql = "UPDATE pizzas SET
    email = ?,
    title = ?,
    ingredients = ?,
    price = ?,
    updated_at = NOW()
    WHERE id = ?";
    
    // prepare the statement for execution using the database connection ($coon)
    $query = mysqli_prepare($coon, $sql);

    // s - string (email,title, ingredients)
    // d - for double (price, since it's a float)
    // - i integer (id_to_update, since id is an integer )
    mysqli_stmt_bind_param($query,"sssdi", $email,$title,$ingredients,$price,$id_update);

    // execute the prepared statement to run the query and update pizza record
    


    if (mysqli_stmt_execute($query)) {
      // echo "✅ Query successful!";
      // Optional: redirect or show popup here
      header('Location: index.php');
    } else {
        echo "❌ Query failed: " . mysqli_error($coon);
    }

  }


  // KEEPS
  
?>

<html>
  <?php  include('templates/header.php');?>


  <section class="container grey-text">
  <h4 class="center">Update Pizza Data</h4>
   <form action="admin_update_pizza.php" class="white" method="POST">
    <!-- Pizza Id -->
    <input type="hidden" name="id" value="<?php echo htmlspecialchars($pizza['id']); ?>">

    <!-- Email -->
    <label for="email">Your Email:</label>
    <input type="text" id="email" name="email" value="<?php echo htmlspecialchars($pizza['email']); ?>">
    
    <!-- Pizza Title -->
    <label for="title">Pizza Title:</label>
    <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($pizza['title']); ?>">
   
    <!-- Ingrediants -->
    <label for="ingrediants">Ingredients (comma separated):</label>
    <input type="text" id="ingrediants" name="ingrediants" value="<?php echo htmlspecialchars($pizza['ingredients']); ?>">
    
    <label for="price">Pizza Price (ZMW): </label>
    <input type="number" step="0.01" min="0" name="price" value="<?php echo htmlspecialchars($pizza['price']); ?>">
    
    <div class="center">
      <button class="btn brand z-depth-0" type="submit" value="submit" name="update"> 
        submit
      </button>
    </div>
   </form>
</section>

  <?php  include('templates/footer.php');?>
</html>