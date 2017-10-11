<?php
namespace App\Service;

class URL
{
	protected $root;
	protected $relative;
	
	public function __construct()
	{
		$this->root = $this->findRoot();
		$this->relative = $this->findRelative();
	}
	
	protected function findRoot()
	{
		$name = explode('/', $_SERVER['SCRIPT_NAME']);
		if (trim($name[0]) == '') {
			array_shift($name);
		}
		$name = array_shift($name);
		$root = explode(DIRECTORY_SEPARATOR, root());
		foreach ($root as $seg) {
			if ($name == $seg) {
				return $name;
			}
		}
		return $_SERVER['HTTP_HOST'];
	}
	protected function findRelative()
	{
		$name = explode('/', $_SERVER['SCRIPT_NAME']);
		if (trim($name[0]) == '') {
			array_shift($name);
		}
		array_pop($name);
		
		return implode('/', $name);
	}
	
	
	public function url($path = '', $variables = null)
	{
		if (strpos($path, '//') !== false) {
			return $path;
		}
		
		$url = '/' . $this->getRelativePath($path);
		if ($variables != null) {
			$url .= '?' . http_build_query($variables);
		}
		
		return $url;
	}
	protected function getBaseUrl()
	{
		$url = trim($this->root . '/' . $this->relative, '/');
		return $url;
	}
	protected function getRelativePath($path = '')
	{
		if (trim($path, '/') == '') {
			return '/' . $this->root . '/' . $this->relative;
		}
		$path = explode('/', str_replace('\\', '/', $path));
		$url = explode('/', $this->getBaseUrl());
		foreach ($path as $seg) {
			if ($seg == '..') {
				array_pop($url);
			} else {
				if (trim($seg) == '') {
					continue;
				}
				$url []= $seg;
			}
		}
		
		return implode('/', $url);
	}
}
?>