<?php
session_start();
require_once dirname(__FILE__, 1) . '/chart.php';

/** Each class 's instance present infomation of a specified nation */
class country
{
  public $cases, $death, $recovered, $date;
  public $chart_case, $chart_new_case, $chart_active_case, $chart_death, $chart_new_death;

  /**
   * country Class constructor.
   */
  public function __construct()
  { }
}