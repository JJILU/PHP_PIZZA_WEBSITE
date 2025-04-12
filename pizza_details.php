<?php
    
    include('config/db_connect.php');

    if (isset($_POST['delete'])) {
      // escape mysql injection
      $id_to_delete = mysqli_real_escape_string($coon,$_POST['id_to_delete']);

      // make sql 
      $sql = "DELETE FROM pizzas WHERE id = $id_to_delete";

      // get query result
      $result = mysqli_query($coon,$sql);

      if ($result) {
        // successfully deleted pizza
        // echo 'query success';
        header('Location: index.php');        
      }
      else {
        // failure to delete pizza
        echo 'query error: ' . mysqli_error($coon);
      }


       // free result from memory
       mysqli_free_result($result);

       // close connection to db
       mysqli_close($coon);

    }

    // check GET request id param
    if (isset($_GET['id'])) {
      //  echo 'id: ' . htmlspecialchars($_GET['id']);
      $id = mysqli_real_escape_string($coon, $_GET['id']);

      // make sql
      $sql = "SELECT * FROM pizzas WHERE id = $id";

      // get query result
      $result = mysqli_query($coon, $sql);

      // fetch result in array format
      $pizza = mysqli_fetch_assoc($result);

      // free result from memory
      mysqli_free_result($result);

      // close connection to db
      mysqli_close($coon);
      
      // print_r($pizza);
    }

?>

<!DOCTYPE html>
<html lang="en">
<?php  include('./templates/header.php'); ?>

<div class="container center">
  <?php if($pizza): ?>
    <h4><?php htmlspecialchars($pizza['title']); ?></h4>
    <p>created by: <?php echo htmlspecialchars($pizza['email']); ?></p>
    <p>created by: <?php echo htmlspecialchars(date($pizza['created_at'])); ?></p>
    <h5>Ingredients:</h5>
    <p><?php echo  htmlspecialchars($pizza['ingredients']); ?></p>
      <form action="pizza_details.php" method="POST">
        <input type="hidden" name="id_to_delete" value="<?php echo $pizza['id']; ?>">
        <input type="submit" class="btn brand z-depth-0" name="delete" value="Delete">
      </form>
  <?php else: ?>
     <h5>No such pizza exists!</h5>
  <?php endif; ?>


</div>

<?php  include('./templates/footer.php'); ?>
</html>