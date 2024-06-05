<?php


$quotes = json_decode(file_get_contents('quotes.json'), true);
$carousel_items = json_decode(file_get_contents('carousel_items.json'), true);
$xml = @simplexml_load_file('shrek_movies.xml');



function loadXMLFile($filename)
{
    return simplexml_load_file($filename);
}


function saveXMLFile($xml, $filename)
{
    $xml->asXML($filename);
}


function getMovieDetails($xml, $title)
{
    foreach ($xml->movie as $movie) {
        if ((string)$movie->title === $title) {
            return $movie;
        }
    }
    return null;
}

function updateMovie($xml, $title, $year, $directors, $rating)
{
    foreach ($xml->movie as $movie) {
        if ((string)$movie->title === $title) {
            $movie->year = $year;
            $movie->director = $directors;
            $movie->rating = $rating;
            break;
        }
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $xml = loadXMLFile('shrek_movies.xml');

    
    if (isset($_POST['editTitle'])) {
        $titleToEdit = $_POST['editTitle'];

        
        $movie = getMovieDetails($xml, $titleToEdit);
    }

 
    if (isset($_POST['update'])) {
        $title = $_POST['title'];
        $year = $_POST['year'];
        $directors = $_POST['directors'];
        $rating = $_POST['rating'];

        
        updateMovie($xml, $title, $year, $directors, $rating);

      
        saveXMLFile($xml, 'shrek_movies.xml');

       
        header("Location: index.php");
        exit();
    }
}
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bootstrap demo</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>




<style>

.centered {
           position: fixed;
            top: 80%;
            left: 4%;
            transform: translate(-50%, -50%);
  
         
            border-radius: 10px;
            max-width: 10%;
            max-height: 10%;
        }

        .centered1 {   
          position: relative;   
          top:100px;
            width: 500px;
            height: 500px;
            border-radius: 10px;
          left:400px;
        }   
        .centered1 img {
            display: block;
            margin: 0 auto;
            max-width: 100%;
            max-height: 100%;
        }


        .centered img {
            display: block;
            margin: 0 auto;
            max-width: 100%;
            max-height: 100%;
        }





body {
    
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

    .container {
      width: 80%;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    table, th, td {
      border: 1px solid black;
      text-align: center;
      padding: 8px;
    }

    th {
      background-color: #f2f2f2;
    }
    .carousel-item img {
      max-height: 500px;
      width: auto;
      margin: 0 auto;
    }
    .carousel-control-prev-icon, .carousel-control-next-icon {
      background-color: black;
    }

 
    body {
      background-color: #d9f7a5; 
    }
    
    .navbar {
      background-color: #7ba05b; 
      border-bottom: 5px solid #9fbf90; 
    }
    
    .navbar-brand, .nav-link {
      color: #000000; 
    }
    
    .navbar-brand:hover, .nav-link:hover {
      color: #7ba05b; 
    }
    
    .navbar-toggler {
      border-color: #ffffff; 
    }
    
    .navbar-toggler-icon {
      background-image: url('https://img.icons8.com/ios/452/shrek.png'); 
      background-size: cover;
    }
    
    .form-control {
      background-color: #f5f5f5; 
      color: #495057; 
    }
    
    .btn-outline-success {
      color: #000000; 
      border-color: #ffffff; 
    }
    
    .btn-outline-success:hover {
      color: #ffffff; 
      background-color: #495057; 
    }


    .footer {
      background-color: #7ba05b; 
      color: #ffffff; 
      text-align: center; 
      padding: 10px; 
      position: fixed; 
      left: 0; 
      bottom: 0; 
      width: 100%; 
    }
  </style>

<body>


<?php
// PHP code to handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect form data
    $ime = $_POST['validationCustom01'] ?? null;
    $prezime = $_POST['validationCustom02'] ?? null;
    $sigurnosni_kod = $_POST['validationCustomUsername'] ?? null;
    $broj_kartice = $_POST['validationCustom03'] ?? null;
    $valid_thru = $_POST['validationCustom04'] ?? null;
    $adresa = $_POST['validationCustom05'] ?? null;

    // Validate collected data
    if (empty($ime) || empty($prezime) || empty($sigurnosni_kod) || empty($broj_kartice) || empty($valid_thru) || empty($adresa)) {
        echo '<div class="alert alert-danger" role="alert">Please fill all required fields.</div>';
    } else {
        // Prepare data to be saved
        $data = [
            'ime' => $ime,
            'prezime' => $prezime,
            'sigurnosni_kod' => $sigurnosni_kod,
            'broj_kartice' => $broj_kartice,
            'valid_thru' => $valid_thru,
            'adresa' => $adresa
        ];

        // Read existing data from JSON file
        $file_path = 'podatci.json';
        if (file_exists($file_path)) {
            $json_data = file_get_contents($file_path);
            $arr_data = json_decode($json_data, true);
        } else {
            $arr_data = [];
        }

        // Append new data
        $arr_data[] = $data;

        // Save updated data back to JSON file
        if (file_put_contents($file_path, json_encode($arr_data, JSON_PRETTY_PRINT))) {
            echo '<div class="alert alert-success" role="alert">Data successfully saved.</div>';
        } else {
            echo '<div class="alert alert-danger" role="alert">Error saving data.</div>';
        }
    }
}
?>

<header>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">SHREK FAN SITE</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="index.php">CEO Borna Rendulić</a>
        </li>
        <li class="nav-item">

        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Dropdown
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">shrek</a></li>
            <li><a class="dropdown-item" href="#">shrek</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">shrek</a></li>
          </ul>
        </li>
        <li class="nav-item">
         
        </li>
      </ul>
      <form class="d-flex" role="search">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
    </div>
  </div>
</nav>
</header>




<link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
<script>
        (function () {
            'use strict';
            var forms = document.querySelectorAll('.needs-validation');
            Array.prototype.slice.call(forms)
                .forEach(function (form) {
                    form.addEventListener('submit', function (event) {
                        if (!form.checkValidity()) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
        })();
    </script>





<div style="width: 80%; margin: 0 auto;">
<p class="text-muted mt-3">* Potrebno je popuniti sve obavezne informacije za slanje obrasca.</p>
<form class="row g-3 needs-validation" action="" method="POST" novalidate>
            <div class="col-md-4">
                <label for="validationCustom01" class="form-label">Ime</label>
                <input type="text" class="form-control" id="validationCustom01" name="validationCustom01" required>
                <div class="valid-feedback">Looks good!</div>
            </div>
            <div class="col-md-4">
                <label for="validationCustom02" class="form-label">Prezime</label>
                <input type="text" class="form-control" id="validationCustom02" name="validationCustom02" required>
                <div class="valid-feedback">Looks good!</div>
            </div>
            <div class="col-md-4">
                <label for="validationCustomUsername" class="form-label">SIGURNOSNI KOD</label>
                <div class="input-group has-validation">
                    <span class="input-group-text" id="inputGroupPrepend">?</span>
                    <input type="text" class="form-control" id="validationCustomUsername" name="validationCustomUsername" aria-describedby="inputGroupPrepend" required>
                    <div class="invalid-feedback">Please choose a security code.</div>
                </div>
            </div>
            <div class="col-md-6">
                <label for="validationCustom03" class="form-label">BROJ KARTICE</label>
                <input type="text" class="form-control" id="validationCustom03" name="validationCustom03" required>
                <div class="invalid-feedback">MOLIM VAS BROJ KARTICE</div>
            </div>
            <div class="col-md-3">
                <label for="validationCustom04" class="form-label">VALID THRU</label>
                <select class="form-select" id="validationCustom04" name="validationCustom04" required>
                    <option selected disabled value="">Choose...</option>
                    <option>01/23</option>
                    <option>02/24</option>
                    <option>03/25</option>
                </select>
                <div class="invalid-feedback">Please select a valid date.</div>
            </div>
            <div class="col-md-3">
                <label for="validationCustom05" class="form-label">ADRESA</label>
                <input type="text" class="form-control" id="validationCustom05" name="validationCustom05" required>
                <div class="invalid-feedback">Please provide a valid address.</div>
            </div>
            <div class="col-12">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="invalidCheck" required>
                    <label class="form-check-label" for="invalidCheck">Agree to terms and conditions</label>
                    <div class="invalid-feedback">You must agree before submitting.</div>
                </div>
            </div>
            <div class="col-12">
                <button class="btn btn-primary" type="submit">Submit form</button>
            </div>
        </form>
</div>






<div id="carouselExample" class="carousel slide">
  <div class="carousel-inner">
    <?php foreach($carousel_items as $index => $item) { ?>
      <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
        <img src="<?php echo htmlspecialchars($item['image_url']); ?>" class="d-block w-100" alt="<?php echo htmlspecialchars($item['alt_text']); ?>">
      </div>
    <?php } ?>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>




<div class="container mt-5">
    <h2>Shrek</h2>
    <table class="table">
      <thead>
        <tr>
        <th scope="col">Image</th>
          <th scope="col">Character</th>
          <th scope="col">Release Date</th>
          <th scope="col">Scene</th>
          <th scope="col">Quote</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($quotes as $quote) { ?>
        <tr>
        <td><img src="<?php echo htmlspecialchars($quote['image_url']); ?>" alt="<?php echo htmlspecialchars($quote['character']); ?>" style="width:50px;height:50px;"></td>
          <td><?php echo htmlspecialchars($quote['character']); ?></td>
          <td><?php echo htmlspecialchars($quote['release_date']); ?></td>
          <td><?php echo htmlspecialchars($quote['scene']); ?></td>
          <td><?php echo htmlspecialchars($quote['quote']); ?></td>
        </tr>
        <?php } ?>
      </tbody>
    </table>



    <h2>Shrek Movies List</h2>

    <table border="1">
    <thead>
        <tr>
            <th>Title</th>
            <th>Year</th>
            <th>Director(s)</th>
            <th>Rating</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($xml->movie as $movie) : ?>
            <tr>
                <td><?php echo $movie->title; ?></td>
                <td><?php echo $movie->year; ?></td>
                <td><?php echo $movie->director; ?></td>
                <td><?php echo $movie->rating; ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
       
</table>


<footer class="footer">
    Borna Rendulić
  </footer>
 

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>



<div class="container mt-5">


  
        <form method="post" action="index.php">
            <div class="mb-3">
                <label for="editTitle" class="form-label">Select Movie Title to Edit:</label>
                <select class="form-control" id="editTitle" name="editTitle">
                    <?php
                  
                    $xml = simplexml_load_file('shrek_movies.xml');

                    
                    foreach ($xml->movie as $movie) {
                        echo "<option value='{$movie->title}'>{$movie->title}</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary" name="edit">Edit Movie</button>
        </form>
<?php
   
        

   if (isset($movie)) : ?>
    <div class="row mt-3">
        <div class="col">
            <h3>Edit Movie: <?php echo $movie->title; ?></h3>
            <form action="index.php" method="post">
                <input type="hidden" name="title" value="<?php echo $movie->title; ?>" />
                <div class="mb-3">
                    <label for="year" class="form-label">Year</label>
                    <input type="text" class="form-control" id="year" name="year"
                        value="<?php echo $movie->year; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="directors" class="form-label">Director(s)</label>
                    <input type="text" class="form-control" id="directors" name="directors"
                        value="<?php echo $movie->director; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="rating" class="form-label">Rating</label>
                    <input type="text" class="form-control" id="rating" name="rating"
                        value="<?php echo $movie->rating; ?>" required>
                </div>
                <button type="submit" class="btn btn-primary" name="update">Update Movie</button>
            </form>
        </div>
    </div>
<?php endif; ?>
</div>

<div class="centered1">
        <img src="cool.jpg" alt="Centered Image">
</div>

<div class="centered">
        <img src="megacool.jpg" alt="Centered Image">
</div>

</div>
<div style="height: 200px;">
  <p>O___O</p>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
integrity="sha384-ENjd..."></script>
</body>

</html>  