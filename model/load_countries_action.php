<?php
session_start();
require_once dirname(__FILE__, 1) . "/country.php";
require_once dirname(__FILE__, 2) . "/dependencies/simple_html_dom.php";

class load_countries_action
{

  public function get_countries_list($url)
  {
    $html_raw = file_get_html($url);
    $countries_list = null;
    $html_countries_elements = $html_raw->find('#main_table_countries_today tbody tr td a.mt_a');
    foreach ($html_countries_elements as $k => $elements) {
      $countries_list[$elements->innertext()] = $this->pick_nation_name_from_href($elements->href);
    }
    return $countries_list;
  }

  private function pick_nation_name_from_href(string $href)
  {
    $temp_result = str_replace("country/", "", $href);
    $result = str_replace("/", "", $temp_result);
    return $result;
  }
}