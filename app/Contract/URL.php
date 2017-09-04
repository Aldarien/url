<?php
namespace App\Contract;

use App\Definition\Contract;
use App\Service\URL;

class URL
{
	use Contract;
	
	protected function newInstance()
	{
		return new URL();
	}
	public function url($path = '', $variables = null)
	{
		$instance = self::getInstance();
		return $instance->url($path, $variables);
	}
}
?>