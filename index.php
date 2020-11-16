<?php
header("Access-Control-Allow-Origin: *");

error_reporting(E_ERROR | E_PARSE);
if (session_id() != null) session_id(session_id());
session_start();

require_once dirname(__FILE__, 1) . "/controller/controller.php";
require_once dirname(__FILE__, 1) . "/model/action.php";


if (isset($_POST['nation'])) {
  // var_dump($_POST["nation"]);
  $controller = new controller($_POST["nation"]);
  $controller->generate_json_file();
  header("Location: http://localhost:7777/json_datas/" . $_SESSION['nation_name'] . ".json");
}

?>

<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js">
<!--<![endif]-->

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Worldometer Crawler</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="">
</head>

<body>
  <!--[if lt IE 7]>
      <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="#">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->

  <h1>CHoose a nation</h1>
  <form action="" method="POST">
    <input type="text" name="nation" id="nation" />
    <button>submit</button>

    <!-- <? echo phpinfo(); ?> -->
  </form>

  <h3>Click the button below to see the name of Nations, then copy one of them and paste to the form</h3>
  <a href="controller/load_list_countries_controller.php">
    <button>See Nations</button>
  </a>

  <script src="" async defer></script>
</body>

</html>


<?php
// $data = (new action("https://www.worldometers.info/coronavirus/country/us/"));
// echo $data->data_ncov;