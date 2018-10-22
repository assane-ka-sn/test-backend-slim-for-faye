<?php

namespace App;


use Slim\Container;


class Controller {

  protected $db;

  public function __construct(Container $c) {
      $this->db = $c->get('db');
  }

}
