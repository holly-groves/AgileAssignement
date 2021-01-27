<?php include 'includes/header.php'?>
<?php
//ensures user is logged in
  // if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === false){
  //   header("location: login.php");
  //   exit;
  // }
  // if(isset($_SESSION["experimentID"])){
  //   $experimentID = $_SESSION["experimentID"];
  // } else {
  //   //If an experiment hasn't been selected redirect to relevant page
  //   header("location: experimentList.php");
  //   exit;
  // }
  if(isset($_POST['quit'])) {
    unset($_SESSION['experimentName']);
    unset($_SESSION['experimentID']);
    unset($_SESSION['questionnaireName']);
    unset($_SESSION['questionnaireID']);
    header("location: experimentList.php");
    exit;
  }
  ?>


  <!DOCTYPE html>
  <html lang="en" dir="ltr">
    <head>
      <meta charset="utf-8">
      <title>Add a Question</title>
      <!-- Bootstrap CSS -->
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.min.css" />
      <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
    </head>

    <body>
      <img class="img-fluid" src="University-of-Dundee-logo.png" width="300px">
        <div class="jumbotron text-center">
          <h1 class="text-center">Add a Question</h1>
        </div>
      <div class="container-fluid" style="padding:0">
        <div class="jumbotron" style="margin-bottom:1px;">
          <h2 class="text-center">You are creating a question for questionnaire:
          <?php echo $_SESSION['questionnaireName']; ?></h2>
            <form method="POST">
              <div class="form-group">
                <label>Please enter the question: </label>
                <input type="text" name="questionText"><br><br>
                <input type="submit" value="Add question" name="addQ">
                <input type="submit" value="quit" name="quit">
            </form>
            <br></br>
          </div>
        </div>
    </body>
  </html>