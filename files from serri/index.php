<?php
require 'dbconnect.php';
// here i can choose how many result i want to see every page
$resultppage=5;

// i select the query that i want to see how many result i have 
$sql = "SELECT * FROM page " ;

// run the query 
$res = mysqli_query($conn,$sql);

// i save the result in a variable as an array
$row0 = $res->fetch_all(MYSQLI_ASSOC);

// here i am checking if i dont have in GET any value it will be the page number one and if i have a value in GET i will save it in a variable $page and i will say if it's 0 i want it to be page number 1 coz i don't want to have page number 0 and else it will take the value from GET and put it inside a variable $page
if (!isset($_GET['page'])) {
  $page = 1;
} else {
  $page = $_GET['page'];
  if($page === 0) {
    $page = 1;
  } else {
    $page = $_GET['page'];
  }
}


// Pagination

// If number of pages is less than one then set it to 1, otherwise set it accordingly
// here i want to know how many row i have in my result from the last query i have 
$number_of_results0 = count($row0);
$number_of_pages = ceil($number_of_results0/$resultppage);
if($number_of_pages <= 1 ) {
  $number_of_pages = 1;
}


// to select the page that i work in to use limit i want the page for the first result and how many result i want to see 
$this_page_first_result = ($page-1)*$resultppage;

$sql2="SELECT * FROM page ORDER BY id ASC LIMIT " . $this_page_first_result . ", " . $resultppage . ";";

// i run the query
$res = mysqli_query($conn,$sql2);

// i save the result in a variable $row2
$row2 = $res->fetch_all(MYSQLI_ASSOC);

?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<!-- i need a bootstrap to use Pagination -->
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</head>
<body>
	<div class="text-left page" id="page">
    <?php 
    // Visible part of pagination
      for ($page = 1; $page<=$number_of_pages; $page++) {
        echo "<a class='paginationPages btn btn-default'  href='index.php?page=" . $page . "'>" . $page . "</a>"; 
      }
      //  END of Visible part of pagination
      if (!isset($_GET['page'])) {
        $curPage = 1;
      } else {
        $curPage = $_GET['page'];
      }
      echo "<p style='float:left; padding-right:15px;'>Page " . $curPage . " out of " . $number_of_pages . "</p>";
    ?>

  </div>

<?php 
          foreach ($row2 as $value) {

          echo "<br><p>" .$value['id'] . "</p><p>".$value['name']. "</p><br>";

          }
        ?>
</body>
</html>