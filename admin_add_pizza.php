<?php
    include('./config/db_connect.php');
    
    // GET METHOD
    // if(isset($_GET['submit'])) {
    //   echo $_GET['email'] . '<br/>';
    //   echo $_GET['title']. '<br/>';
    //   echo $_GET['ingrediants']. '<br/>';
    // }

    print_r($_POST);

    $errors = array(
      'email_error' => "",
      'title_error' => "",
      'ingredients' => "",
      'price_error' => ""
    );

    $email = $title = $ingrediants = $price = "";
    // print_r($_POST['email']);

    // POST METHOD
    if(isset($_POST['submit'])) {
      // echo htmlspecialchars($_POST['email']) . '<br/>';
      // echo htmlspecialchars($_POST['title']). '<br/>';
      // echo htmlspecialchars($_POST['ingrediants']). '<br/>';

      // check wether email field is empty
      if (empty($_POST['email'])) {
        $errors['email_error'] = 'email is required';
      }
      else 
      {
        $email = $_POST['email'];
        if (!filter_var($email,FILTER_VALIDATE_EMAIL)) {
          $errors['email_error'] = "email must be a valid email";
        }
      }

      // check wether title field is empty
      if (empty($_POST['title'])) {
        $errors['title_error'] = 'title is required';
      }
      else {
        $title = $_POST['title'];
        if (!preg_match('/^[a-zA-Z\s]+$/',$title)) {
            $errors['title_error'] = "Title must be letter and spaces only";
        }
      }

      // check wether ingrediants field is empty
      if (empty($_POST['ingrediants'])) {
        $errors['ingredients'] = 'ingredients is required';
      }
      else {
        $ingrediants = $_POST['ingrediants'];
        if (!preg_match('/^([a-zA-Z\s]+)(,\s*[a-zA-Z\s]*)*$/',$ingrediants)) {
          $errors['ingredients'] = "Ingredients must be a comma separated list";
        }
      }


      // check wether price is empty
      if (empty($_POST['price'])) {
        $errors['price_error'] = "Price is required";
      } 
      else
      {
        $price = $_POST['price'];
        if ($price < 10) {
          $errors['price_error'] = "Price must not be less than ZMW 10";
        }
      }


      // check if form has errors
    if (array_filter($errors)) {
      // no errors in form
      echo "error raised in form";
    }
    else 
    {
        // no errors
  
      // header('Location: index.php');

      // protect from sql injection
      $email = mysqli_real_escape_string($coon, $_POST['email']);
      $title = mysqli_real_escape_string($coon, $_POST['title']);
      $ingrediants = mysqli_real_escape_string($coon, $_POST['ingrediants']);
      // echo $email . $title . $ingrediants;

      // create sql : insee
      $sql = "INSERT INTO pizzas(title,email,price,ingredients) VALUES ('$title','$email','$price','$ingrediants')";

      // save to db and check
      if (mysqli_query($coon,$sql)) {
        // success
        // header('Location: index.php');
      } 
      else 
      {
      // fail : error
      echo "query error: " . mysqli_error($coon);
      }

      header('Location: index.php');
    }
    



    }



    

    
   
?>

<!DOCTYPE html>
<html lang="en">
<?php include('templates/header.php') ?>

<section class="container grey-text">
  <h4 class="center">Add a Pizza</h4>
   <form action="admin_add_pizza.php" class="white" method="POST">
    <!-- Email -->
    <label for="email">Your Email:</label>
    <input type="text" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" autocomplete="on">
    <div class="red-text"><?= $errors['email_error'] ?></div>
    <!-- Pizza Title -->
    <label for="title">Pizza Title:</label>
    <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($title); ?>" autocomplete="on">
    <div class="red-text"><?= $errors['title_error'] ?></div>
    <!-- Ingrediants -->
    <label for="ingrediants">Ingrediants (comma separated):</label>
    <input type="text" id="ingrediants" name="ingrediants" value="<?php echo htmlspecialchars($ingrediants); ?>" autocomplete="on">
    <div class="red-text"><?= $errors['ingredients'] ?></div>
    <label for="price">Pizza Price (ZMW): </label>
    <input type="number" step="0.01" min="0" name="price" value="<?php echo htmlspecialchars($price); ?>">
    <div class="red-text"><?= $errors['price_error'] ?></div>
    <div class="center">
      <button class="btn brand z-depth-0" type="submit" value="submit" name="submit"> 
        submit
      </button>
    </div>
   </form>
</section>


