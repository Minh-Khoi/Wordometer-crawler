<?php
session_start();

/** THis class handle datas crawled from chart (on worldometer website) */
class chart
{
  public $title, $array;

  /**
   * chart Class constructor.
   * create an object chart with attribute $title (cases, new cases, active cases, deaths, new death)
   * and attribute $data is the number which are changing after each day
   */
  public function __construct($title, $xAxis, $data)
  {
    $this->title = $title;
    $this->array = array();
    // var_dump($xAxis);
    for ($i = 0; $i < count($xAxis); $i++) {
      array_push($this->array, array($xAxis[$i] => $data[$i]));
    }
  }
}
