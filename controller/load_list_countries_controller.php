
<?php
error_reporting(E_ERROR | E_PARSE);

// session_start();

require_once dirname(__FILE__, 2) . "/model/action.php";
require_once dirname(__FILE__, 2) . "/model/load_countries_action.php";

class load_list_countries
{
  public $list_countries = [];

  /**
   * Class constructor.
   */
  public function __construct($getting_vaccination_data = false, $raw_data_vaccinations = null)
  {
    if (!$getting_vaccination_data) {
      $this->action = new load_countries_action();
      $countries_list = $this->action->get_countries_list('https://www.worldometers.info/coronavirus/#countries');
      foreach ($countries_list as $k => $country) {
        array_push($this->list_countries, $country);
      }
    } else {
      $countries_list = [];
      $data_vaccinations = json_decode($raw_data_vaccinations, true);
      // var_dump($raw_data_vaccinations);
      foreach ($data_vaccinations as $k => $vaccination_by_country) {
        array_push($countries_list, $vaccination_by_country["country"]);
      }
      $this->list_countries = $countries_list;
    }
  }
}
