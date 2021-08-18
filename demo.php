<?
error_reporting(E_ERROR);
require_once dirname(__FILE__) . "/controller/controller.php";
require_once dirname(__FILE__) . "/controller/load_list_countries_controller.php";
// require_once dirname(__FILE__) . "/model/load_countries_action.php";

$data = file_get_contents("https://raw.githubusercontent.com/owid/covid-19-data/master/public/data/vaccinations/vaccinations.json");


$controller = new controller("Argentina", $data);
