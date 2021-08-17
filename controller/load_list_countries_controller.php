<h2>
  Choose the RIGHT name of Nation, in the text form
</h2>
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
  public function __construct()
  {
    $this->action = new load_countries_action();
    $countries_list = $this->action->get_countries_list('https://www.worldometers.info/coronavirus/#countries');

    foreach ($countries_list as $k => $country) {
      array_push($this->list_countries, $country);
    }
  }
}
