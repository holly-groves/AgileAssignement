<?php include 'includes/header.php'?>
<?php
//ensures user is logged in
  if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] === false){
    header("location: login.php");
    exit;
  }
  if(isset($_SESSION["experimentID"])){
    $experimentID = $_SESSION["experimentID"];
  } else {
    //If an experiment hasn't been selected redirect to relevant page
    header("location: experimentList.php");
    exit;
  }

  include "Includes/db.inc.php";
  $questionnaireID = $_SESSION['questionnaireID'];
  $extraOptions = $_GET['on'];

    if(isset($_POST['addsubQ'])){
      echo "extra options= ".$extraOptions."<br><br>";
      $extraOptions= $extraOptions + 1;
      echo "extra options + 1= ".$extraOptions."<br><br>";
      header("location: addUsabilityScale.php?on={$extraOptions}");
      exit;
    }

  if(isset($_POST['addQ'])){
    $questiontext = $_POST['questionText'];
    if (empty($questiontext)) {
      echo "The question must have text!";
    }
    else {
      $success = true;
      //send to db sql here
      $questionID = uniqid($prefix="", $more_entropy=false);
      $questionType = 4;
      $sql = $conn->prepare("INSERT INTO questions(questionID, questionText, questionnaireID, questionType) VALUES ('$questionID', ?, '$questionnaireID', $questionType)");
      $sql->bind_param('s', $questiontext);
      if ($sql->execute() === TRUE) {
        echo "New record created successfully";
        for ($i=0; $i < $extraOptions+2; $i++) {
          $variablename = "subQ".$i."";
          $subQtext = $_POST[$variablename];
          if (empty($subQtext)) {
            echo "The sub question must have text!";
          }
          else {
            $uqID = uniqid($prefix="", $more_entropy=false);
            $newSql = $conn->prepare("INSERT INTO usabilityquestions(uqID, uqText, questionID) VALUES ('$uqID', ?, '$questionID')");
            $newSql->bind_param('s', $subQtext);
            if ($newSql->execute() === TRUE) {
              echo "New record created successfully";
            }
            else {
              $success = false;
              echo "Error: " . $sql . "<br>" . $conn->error;
            }
          }
        }
        if ($success){
          echo "It was a success!";
          header("location: addUsabilityScale.php");
        }
      }
      else {
        echo "Error: " . $sql . "<br>" . $conn->error;
      }
    }
  }

  if(isset($_POST['quit'])) {
    $questiontext = $_POST['questionText'];
    if (!empty($questiontext)) {
      $success = true;
      //send to db sql here
      $questionID = uniqid($prefix="", $more_entropy=false);
      $questionType = 4;
      $sql = $conn->prepare("INSERT INTO questions(questionID, questionText, questionnaireID, questionType) VALUES ('$questionID', ?, '$questionnaireID', $questionType)");
      $sql->bind_param('s', $questiontext);
      if ($sql->execute() === TRUE) {
        echo "New record created successfully";
        for ($i=0; $i < $extraOptions+2; $i++) {
          $variablename = "subQ".$i."";
          $subQtext = $_POST[$variablename];
          if (empty($subQtext)) {
            echo "The sub question must have text!";
          }
          else {
            $uqID = uniqid($prefix="", $more_entropy=false);
            $newSql = $conn->prepare("INSERT INTO usabilityquestions(uqID, uqText, questionID) VALUES ('$uqID', ?, '$questionID')");
            $newSql->bind_param('s', $subQtext);
            if ($newSql->execute() === TRUE) {
              echo "New record created successfully";
            }
            else {
              $success = false;
              echo "Error: " . $sql . "<br>" . $conn->error;
            }
          }
        }
        if ($success){
          echo "It was a success!";
          header("location: addUsabilityScale.php");
        }
      }
      else {
        echo "Error: " . $sql . "<br>" . $conn->error;
      }
    }

    header("location: questionnaireList.php?c=t");
    exit;
  }

  if(isset($_POST['cancel'])) {
    $sql = "DELETE FROM questions WHERE questionnaireID = '$questionnaireID'";
    if ($conn->query($sql) === TRUE) {
      echo "Questions deleted successfully";
    }
    else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $sql = "DELETE FROM questionnaires WHERE questionnaireID = '$questionnaireID'";
    if ($conn->query($sql) === TRUE) {
      echo "Questionnaire deleted successfully";
    }
    else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
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
      <link rel="stylesheet" href="style.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js">
      <style>
      /* Dropdown Button */
      .dropbtn {
        background-color: #4CAF50;
        color: white;
        padding: 16px;
        font-size: 16px;
        border: none;
      }

      /* The container <div> - needed to position the dropdown content */
      .dropdown {
        position: relative;
        display: inline-block;
      }

      /* Dropdown Content (Hidden by Default) */
      .dropdown-content {
        display: none;
        position: absolute;
        background-color: #f1f1f1;
        min-width: 160px;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        z-index: 1;
      }

      /* Links inside the dropdown */
      .dropdown-content a {
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
      }

      /* Change color of dropdown links on hover */
      .dropdown-content a:hover {background-color: #ddd;}

      /* Show the dropdown menu on hover */
      .dropdown:hover .dropdown-content {display: block;}

      /* Change the background color of the dropdown button when the dropdown content is shown */
      .dropdown:hover .dropbtn {background-color: #3e8e41;}
      </style>
    </head>

    <body>
      <header style="height:150px;">
        <a href="Includes/redirect.inc.php"><img class="img-fluid" src="University-of-Dundee-logo.png" width="300px" style="padding:20px; float: left"></a>
        <button onclick="location.href='Includes/logout.inc.php';" type='button' class='btn btn-secondary' style="float: right; margin:20px">Logout</button>
      </header>

        <div class="jumbotron text-center">
          <h1 class="text-center">Add a Usability Scale Question</h1>
        </div>
      <div class="container-fluid" style="padding:0">
        <div class="jumbotron" style="margin-bottom:1px;">
          <h2 class="text-center">You are creating a question for questionnaire:
          <?php echo $_SESSION['questionnaireName']; ?></h2>
          <br>
          <div class="dropdown">
            <button class="dropbtn">Change question type</button> <br>
            <div class="dropdown-content">
              <a href="addQuestions.php">Text Answer</a>
              <a href="addMultipleChoice.php">Multiple Choice</a>
              <a href="addSingleChoice.php">Single Choice</a>
            </div>
          </div>
          <br>
            <form method="POST">
              <div class="form-group">
                <label>Please enter the Question: </label>
                <input type="text" name="questionText"><br><br>
                <label>Please enter a sub question: </label>
                <input type="text" name="subQ0"><br><br>
                <?php
                for ($i=0; $i < $extraOptions; $i++) {
                  $tempNo = 1 + $i;
                  $subQname = "subQ" . $tempNo;
                  echo "<label>Please enter a sub question: </label>
                  <input type='text' name=".$subQname."><br><br>";
                }
                ?>
                <form method="post">
                  <input type="submit" name="addsubQ" value="+ Add a sub question" class='btn btn-outline-success'>

                </form>
                <input type="submit" value="Add question" name="addQ" class='btn btn-outline-success'>
                <input type="submit" value="Save and quit" name="quit" class='btn btn-outline-success'>
                <input type="submit" value="Cancel questionnaire" name="cancel" class='btn btn-outline-success'>
            </form>
            <br></br>
          </div>
        </div>
      <footer>
        <img class="img-fluid mx-auto d-block" src="University-of-Dundee-logo-small.png" width="100px" style="padding:20px">
      </footer>
    </body>
  </html>
