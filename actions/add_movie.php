<?php
// Include config file
require_once "../config.php";

// Define variables and initialize with empty values
$title = $genre = $year = "";
// $image = "";
$title_err = $genre_err = $year_err = "";
// $image_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate title
    $input_title = trim($_POST["title"]);
    if(empty($input_title)){
        $title_err = "Please enter the movie title.";
    } elseif(!filter_var($input_title, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $title_err = "Please enter a valid title.";
    } else{
        $title = $input_title;
    }

    // Validate genre
    $input_genre = trim($_POST["genre"]);
    if(empty($input_genre)){
        $genre_err = "Please enter the movie genre.";
    } else{
        $genre = $input_genre;
    }

    // Validate year
    $input_salary = trim($_POST["year"]);
    if(empty($input_salary)){
        $salary_err = "Please enter the movie year.";
        // TODO: check if the year is <= the current year
    } elseif(!ctype_digit($input_salary)){
        $salary_err = "Please enter a positive integer value.";
    } else{
        $year = $input_salary;
    }

    // Validate image
    /*$input_image = trim($_POST["image"]);
    if(empty($input_image)){
        $image_err = "Please enter the movie image.";
    } else{
        $image = $input_image;
    }*/

    // Check input errors before inserting in database
    if(empty($name_err) && empty($address_err) && empty($salary_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO movies (title, genre, year) VALUES (?, ?, ?)";
        //$sql = "INSERT INTO movies (title, genre, year, image) VALUES (?, ?, ?, ?)";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sss", $param_title, $param_genre, $param_year);
            //mysqli_stmt_bind_param($stmt, "sss", $param_title, $param_genre, $param_year, $param_image);

            // Set parameters
            $param_title = $title;
            $param_genre = $genre;
            $param_year = $year;
            // $param_image = $image;

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                header("location: ../movies.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Close connection
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h2 class="mt-5">Create Record</h2>
                <p>Please fill this form and submit to add employee record to the database.</p>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" name="title" class="form-control <?php echo (!empty($title_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $title; ?>">
                        <span class="invalid-feedback"><?php echo $title_err;?></span>
                    </div>
                    <div class="form-group">
                        <label>Genre</label>
                        <textarea name="genre" class="form-control <?php echo (!empty($genre_err)) ? 'is-invalid' : ''; ?>"><?php echo $genre; ?></textarea>
                        <span class="invalid-feedback"><?php echo $genre_err;?></span>
                    </div>
                    <div class="form-group">
                        <label>Year</label>
                        <input type="text" name="year" class="form-control <?php echo (!empty($year_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $year; ?>">
                        <span class="invalid-feedback"><?php echo $year_err;?></span>
                    </div>
                    <!-- <div class="form-group">
                        <label>Image (link)</label>
                        <textarea name="image" class="form-control <?php echo (!empty($image_err)) ? 'is-invalid' : ''; ?>"><?php echo $image; ?></textarea>
                        <span class="invalid-feedback"><?php echo $image_err;?></span>
                    </div> -->
                    <input type="submit" class="btn btn-primary" value="Submit">
                    <a href="../movies.php" class="btn btn-secondary ml-2">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>