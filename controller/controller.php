<?php
session_start();

require_once dirname(__FILE__, 2) . "/model/action.php";

/** This class will handle request from index.php (view) */
class controller
{
  private $datas;

  /** 
   * construction will get the nation name and push it into url link, 
   * which is passed as param to action construction
   */
  public function __construct($nation_name)
  {
    $action = (new action("https://www.worldometers.info/coronavirus/country/" . $nation_name . "/"));
    $_SESSION['nation_name'] = $nation_name;
    $this->datas = $action->get_data_ncov();
  }


  public function get_datas()
  {
    return $this->datas;
  }

  /** Generate file <nation_name>.json. The file will be used to be seen on browser of downloaded*/
  public function generate_json_file()
  {
    $path = dirname(__FILE__, 2) . '/json_datas/' . $_SESSION['nation_name'] . '.json';
    $fp = fopen($path, 'w');
    fwrite($fp, json_encode($this->datas));
    fclose($fp);
  }
}
