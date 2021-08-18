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
  public function __construct($nation_name, $vaccination_data = null)
  {
    // var_dump(!$vaccination_data);
    if ($vaccination_data == null) {
      $action = (new action("https://www.worldometers.info/coronavirus/country/" . $nation_name . "/"));
      $this->datas = $action->get_data_ncov();
    } else {
      $data_decoded = json_decode($vaccination_data, true);
      $data_decoded_of_nation = array_filter($data_decoded, function ($sub_data) use ($nation_name) {
        return $sub_data["country"] == $nation_name;
      });
      // var_dump($data_decoded_of_nation);
      $this->datas = array_values($data_decoded_of_nation)[0];
    }
    $_SESSION['nation_name'] = $nation_name;
    // var_dump($this->datas);
  }


  public function get_datas()
  {
    return $this->datas;
  }

  /** Generate file <nation_name>.json. The file will be used to be seen on browser of downloaded*/
  public function generate_json_file($getting_vaccinations_data = false)
  {
    $path = dirname(__FILE__, 2) . '/json_datas/' . $_SESSION['nation_name'] .
      (($getting_vaccinations_data) ? "_vaccination" : "") . '.json';
    $fp = fopen($path, 'w');
    fwrite($fp, json_encode($this->datas));
    fclose($fp);
  }
}
