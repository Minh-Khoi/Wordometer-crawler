<?php
session_start();

require_once dirname(__FILE__, 2) . "/model/action.php";

/** This class will handle request from index.php (view) */
class controller
{
  private $datas;

  public function __construct($nation_name)
  {
    // echo "https://www.worldometers.info/coronavirus/country/" . $nation_name . "/";
    $action = (new action("https://www.worldometers.info/coronavirus/country/" . $nation_name . "/"));
    $_SESSION['nation_name'] = $nation_name;
    $this->datas = $action->get_data_ncov();
  }

  public function get_datas()
  {
    return $this->datas;
  }

  public function generate_json_file()
  {

    $fp = fopen(dirname(__FILE__, 2) . '/json_datas/' . $_SESSION['nation_name'] . '.json', 'w');
    fwrite($fp, json_encode($this->datas));
    fclose($fp);
  }
}