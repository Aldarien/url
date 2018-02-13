<?php
namespace App\Service;

use League\Uri\Http;
use League\Uri\Components\Host;
use League\Uri\Components\HierarchicalPath;
use League\Uri\Factory;

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
		$uri = Http::createFromString($_SERVER['HTTP_HOST']);
		$host = new Host($uri->getHost());
		if ($host->isAbsolute()) {
			return $host->getRegistrableDomain();
		}
		return $host . '';
	}
	protected function findRelative()
	{
		$uri = Http::createFromString($_SERVER['SCRIPT_NAME']);
		$normalized = (new HierarchicalPath($uri->getPath()))->withoutLeadingSlash()->withoutTrailingSlash()->withoutDotSegments()->withoutEmptySegments();
		if ($normalized->getDirname() == '.') {
			return '';
		}
		return $normalized->getDirname();
	}
	
	
	public function url($path = '', $variables = null)
	{
		$uri = Http::createFromString($path);
		if ($uri->getHost() != $this->root and $uri->getHost() != '') {
			return $path;
		}
		
		$url = $this->getRelativePath($path);
		if ($variables != null) {
			$url = $url . '?' . http_build_query($variables);			
		}
		
		return $url . '';
	}
	protected function getBaseUrl()
	{
		$url = 'http://' . trim($this->root . '/' . $this->relative, '/');
		return $url;
	}
	protected function getRelativePath($path = '')
	{
		if (trim($path, '/') == '') {
			return Http::createFromString('http://' . $this->root . '/' . $this->relative);
		}
		$uri = Http::createFromString($path);
		$normalized = (new HierarchicalPath($uri->getPath()))->withoutTrailingSlash()->withoutEmptySegments();
		
		$factory = new Factory();
		$uri = $factory->create($normalized . '', $this->getBaseUrl());
		
		return $uri;
	}
}
?>