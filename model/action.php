<?php
session_start();
require_once dirname(__FILE__, 1) . "/country.php";
require_once dirname(__FILE__, 2) . "/dependencies/simple_html_dom.php";

class action
{
  private $data_ncov, $html_entities, $countries_list;
  /**
   * action Class constructor.
   */
  public function __construct($url)
  {
    // This attribute is an JSON object which is loaded as a result 
    $this->data_ncov = new country();
    $this->html_entities = htmlentities(file_get_contents($url));
    if (strpos($this->html_entities, "the requested webpage was not found")) {
      die("Wrong Nation! Data not found");
    }

    $this->set_basic_info($url);
    $this->set_chart_case();
    $this->set_chart_new_case();
    $this->set_chart_active_case();
    $this->set_chart_deaths();
    $this->set_chart_new_deaths();
    // print_r('<pre>');
    // // var_dump($this->data_ncov);
    // echo (json_encode($this->data_ncov));
    // print_r('</pre>');
  }

  public function get_data_ncov()
  {
    return $this->data_ncov;
  }

  private function set_basic_info($url)
  {
    $html_raw = file_get_html($url);
    if (!$html_raw->find(".maincounter-number span")) {
      die("Data not found");
    }
    $this->data_ncov->cases = $html_raw->find(".maincounter-number span")[0]->innertext();
    $this->data_ncov->death = $html_raw->find(".maincounter-number span")[1]->innertext();
    $this->data_ncov->recovered = $html_raw->find(".maincounter-number span")[2]->innertext();
    $this->data_ncov->date = date("Y/m/d - h:i:sa");
  }

  /** set chart data for case */
  private function set_chart_case()
  {
    $title = "total cases";
    $index_chart_begin = strpos($this->html_entities, "Highcharts.chart('coronavirus-cases-linear'");
    $index_xAxis_begin = strpos($this->html_entities, "xAxis", $index_chart_begin);
    $xAxis_index_bracket_open = strpos($this->html_entities, '[', $index_xAxis_begin);
    $xAxis_index_bracket_close = strpos($this->html_entities, ']', $xAxis_index_bracket_open);
    $string_xAxis = substr($this->html_entities, $xAxis_index_bracket_open + 1, $xAxis_index_bracket_close - $xAxis_index_bracket_open - 1);
    $string_xAxis = str_replace('&quot;', '', $string_xAxis);
    $array_xAxis = explode(',', $string_xAxis);

    $index_data_begin = strpos($this->html_entities, "data", $index_chart_begin);
    $data_index_bracket_open = strpos($this->html_entities, '[', $index_data_begin);
    $data_index_bracket_close = strpos($this->html_entities, ']', $data_index_bracket_open);
    $string_data = substr($this->html_entities, $data_index_bracket_open + 1, $data_index_bracket_close - $data_index_bracket_open - 1);
    $array_data = explode(',', $string_data);

    $chart = new chart($title, $array_xAxis, $array_data);
    $this->data_ncov->chart_case = $chart;
    // print_r('<pre>');
    // // var_dump($chart);
    // echo (json_encode($chart));
    // print_r('</pre>');
  }

  /** set chart data for new case */
  private function set_chart_new_case()
  {
    $title = "new cases";
    $index_chart_begin = strpos($this->html_entities, "Highcharts.chart('graph-cases-daily'");
    $index_xAxis_begin = strpos($this->html_entities, "xAxis", $index_chart_begin);
    $xAxis_index_bracket_open = strpos($this->html_entities, '[', $index_xAxis_begin);
    $xAxis_index_bracket_close = strpos($this->html_entities, ']', $xAxis_index_bracket_open);
    $string_xAxis = substr($this->html_entities, $xAxis_index_bracket_open + 1, $xAxis_index_bracket_close - $xAxis_index_bracket_open - 1);
    $string_xAxis = str_replace('&quot;', '', $string_xAxis);
    $array_xAxis = explode(',', $string_xAxis);

    $index_data_begin = strpos($this->html_entities, "data", $index_chart_begin);
    $data_index_bracket_open = strpos($this->html_entities, '[', $index_data_begin);
    $data_index_bracket_close = strpos($this->html_entities, ']', $data_index_bracket_open);
    $string_data = substr($this->html_entities, $data_index_bracket_open + 1, $data_index_bracket_close - $data_index_bracket_open - 1);
    $array_data = explode(',', $string_data);

    $chart = new chart($title, $array_xAxis, $array_data);
    $this->data_ncov->chart_new_case = $chart;
    // print_r('<pre>');
    // var_dump($chart);
    // // echo (json_encode($chart));
    // print_r('</pre>');
  }

  /** set chart data for active case */
  private function set_chart_active_case()
  {
    $title = "active cases";
    $index_chart_begin = strpos($this->html_entities, "Highcharts.chart('graph-active-cases-total'");
    $index_xAxis_begin = strpos($this->html_entities, "xAxis", $index_chart_begin);
    $xAxis_index_bracket_open = strpos($this->html_entities, '[', $index_xAxis_begin);
    $xAxis_index_bracket_close = strpos($this->html_entities, ']', $xAxis_index_bracket_open);
    $string_xAxis = substr($this->html_entities, $xAxis_index_bracket_open + 1, $xAxis_index_bracket_close - $xAxis_index_bracket_open - 1);
    $string_xAxis = str_replace('&quot;', '', $string_xAxis);
    $array_xAxis = explode(',', $string_xAxis);

    $index_data_begin = strpos($this->html_entities, "data", $index_chart_begin);
    $data_index_bracket_open = strpos($this->html_entities, '[', $index_data_begin);
    $data_index_bracket_close = strpos($this->html_entities, ']', $data_index_bracket_open);
    $string_data = substr($this->html_entities, $data_index_bracket_open + 1, $data_index_bracket_close - $data_index_bracket_open - 1);
    $array_data = explode(',', $string_data);

    $chart = new chart($title, $array_xAxis, $array_data);
    $this->data_ncov->chart_active_case = $chart;
    // print_r('<pre>');
    // var_dump($chart);
    // // echo (json_encode($chart));
    // print_r('</pre>');
  }

  /** set chart data for deaths*/
  private function set_chart_deaths()
  {
    $title = "total deaths";
    $index_chart_begin = strpos($this->html_entities, "Highcharts.chart('coronavirus-deaths-linear'");
    $index_xAxis_begin = strpos($this->html_entities, "xAxis", $index_chart_begin);
    $xAxis_index_bracket_open = strpos($this->html_entities, '[', $index_xAxis_begin);
    $xAxis_index_bracket_close = strpos($this->html_entities, ']', $xAxis_index_bracket_open);
    $string_xAxis = substr($this->html_entities, $xAxis_index_bracket_open + 1, $xAxis_index_bracket_close - $xAxis_index_bracket_open - 1);
    $string_xAxis = str_replace('&quot;', '', $string_xAxis);
    $array_xAxis = explode(',', $string_xAxis);

    $index_data_begin = strpos($this->html_entities, "data", $index_chart_begin);
    $data_index_bracket_open = strpos($this->html_entities, '[', $index_data_begin);
    $data_index_bracket_close = strpos($this->html_entities, ']', $data_index_bracket_open);
    $string_data = substr($this->html_entities, $data_index_bracket_open + 1, $data_index_bracket_close - $data_index_bracket_open - 1);
    $array_data = explode(',', $string_data);

    $chart = new chart($title, $array_xAxis, $array_data);
    $this->data_ncov->chart_death = $chart;
    // print_r('<pre>');
    // var_dump($chart);
    // // echo (json_encode($chart));
    // print_r('</pre>');
  }

  /** set chart data for new deaths*/
  private function set_chart_new_deaths()
  {
    $title = "new daily deaths";
    $index_chart_begin = strpos($this->html_entities, "Highcharts.chart('graph-deaths-daily'");
    $index_xAxis_begin = strpos($this->html_entities, "xAxis", $index_chart_begin);
    $xAxis_index_bracket_open = strpos($this->html_entities, '[', $index_xAxis_begin);
    $xAxis_index_bracket_close = strpos($this->html_entities, ']', $xAxis_index_bracket_open);
    $string_xAxis = substr($this->html_entities, $xAxis_index_bracket_open + 1, $xAxis_index_bracket_close - $xAxis_index_bracket_open - 1);
    $string_xAxis = str_replace('&quot;', '', $string_xAxis);
    $array_xAxis = explode(',', $string_xAxis);

    $index_data_begin = strpos($this->html_entities, "data", $index_chart_begin);
    $data_index_bracket_open = strpos($this->html_entities, '[', $index_data_begin);
    $data_index_bracket_close = strpos($this->html_entities, ']', $data_index_bracket_open);
    $string_data = substr($this->html_entities, $data_index_bracket_open + 1, $data_index_bracket_close - $data_index_bracket_open - 1);
    $array_data = explode(',', $string_data);

    $chart = new chart($title, $array_xAxis, $array_data);
    $this->data_ncov->chart_new_death = $chart;
    // print_r('<pre>');
    // var_dump($chart);
    // // echo (json_encode($chart));
    // print_r('</pre>');
  }
}