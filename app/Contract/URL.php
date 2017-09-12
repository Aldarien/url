<?php
namespace App\Contract;

use App\Definition\Contract;
use App\Service\URL as URLService;

class URL
{
	use Contract;
	
	protected static function newInstance()
	{
		return new URLService();
	}
	public static function url($path = '', $variables = null)
	{
		$instance = self::getInstance();
		return $instance->url($path, $variables);
	}
}
?>