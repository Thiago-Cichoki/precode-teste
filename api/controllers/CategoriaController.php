<?php

namespace api\controllers;

use api\model\Categoria;

use util\Util;
use Curl;

class CategoriaController extends CrudController
{
	public function __construct()
	{
		parent::CrudController(new Categoria());
	}

}
