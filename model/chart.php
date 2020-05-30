<?php
session_start();

/** THis is for data crawled from chart */
class chart
{
  public $title, $array;

  /**
   * chart Class constructor.
   */
  public function __construct($title, $xAxis, $data)
  {
    $this->title = $title;
    $this->array = array();
    for ($i = 0; $i < count($xAxis); $i++) {
      array_push($this->array, array($xAxis[$i] => $data[$i]));
    }
  }
}
