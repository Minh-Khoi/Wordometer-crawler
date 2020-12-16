<h2>
  To load the data of Covid-19 by Nation, you must copy the nation 's name arcodding to the list below:
</h2>
<?php
error_reporting(E_ERROR | E_PARSE);

session_start();

require_once dirname(__FILE__, 2) . "/model/action.php";
require_once dirname(__FILE__, 2) . "/model/load_countries_action.php";

$action = new load_countries_action();

$countries_list = $action->get_countries_list('https://www.worldometers.info/coronavirus/#countries');

foreach ($countries_list as $k => $country) {
  echo "<b>" . $country . "</b><br/>";
}