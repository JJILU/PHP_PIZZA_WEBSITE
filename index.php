<?php
    
    /**
     * [1] MySQLi or PDO
     * ------------------
     * 
     * 1: To communicate with database i can use:
     *  --> MySQLi = i - improved (code in more procedural manner)
     *  --> PDO = php data objects
     */

    
    include('./config/db_connect.php');

    // write query to get all pizzas
    $sql = 'SELECT title,ingredients,id  FROM pizzas ORDER BY created_at';

    // make query & get result
    $result = mysqli_query($coon,$sql);

    // fetch resulting rows as an array
    $pizzas = mysqli_fetch_all($result, MYSQLI_ASSOC);

    // free result from memory
    mysqli_free_result($result);

    // close connection to db
    mysqli_close($coon);


    // print_r($pizzas);

   

    // explode function - converts string into an indexed array
    // print_r(explode(',',$pizzas[0]['ingredients']));

   
    

?>

<!DOCTYPE html>
<html lang="en">
<?php include('templates/header.php') ?>

<h4 class="center grey-text">Pizza!</h4>
<div class="container">
  <div class="row">
    <?php foreach ($pizzas as $pizza) : ?>
      <div class="col s6 md3">
        <div class="card z-depth-0">
          <div class="card-content center">
            <h6><?php echo htmlspecialchars($pizza['title']); ?></h6>
            <ul>
              <?php foreach (explode(',',$pizza['ingredients']) as $ingredient) : ?>
              <li><?php echo htmlspecialchars($ingredient) ?></li>
            <?php endforeach; ?>
            </ul>
          </div>
          <div class="card-action right-align">
            <a href="http://localhost/PHP_NETNINJA_2025/pizza_website/pizza_details.php?id=<?php echo $pizza['id']; ?>" class="brand-text">more info</a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>

<?php include('templates/footer.php') ?>
</html>