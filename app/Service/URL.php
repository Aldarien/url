<?php
namespace App\Service;

use League\Uri\Http;
use League\Uri\Components\Host;
use League\Uri\Components\HierarchicalPath;

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
		$uri = Http::createFromString($_SERVER['SCRIPT_NAME']);
		$host = new Host($uri->getHost());
		if ($host->isAbsolute()) {
			return $host->getRegistrableDomain();
		}
		return $uri->getScheme() . '://' . $host;
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
		
		$uri = \Sabre\Uri\resolve($this->getBaseUrl(), $path);
		$host = new Host(Http::createFromString($uri)->getHost());
		$base = new Host(Http::createFromString($this->root)->getHost());
		if ($host . '' != $base . '') {
			$host = new Host(Http::createFromString($this->root)->getHost());
			$page = str_replace($this->root, '', $uri);
			$uri = \Sabre\Uri\resolve(Http::createFromString($this->root)->getScheme() . '://' . $host->getRegistrableDomain(). '/', $page);
		}
		
		if ($variables != null) {
			$uri = \Sabre\Uri\resolve($uri, '?' . http_build_query($variables));
		}
		$uri = \Sabre\Uri\normalize($uri);
		
		return $uri;
	}
	protected function getBaseUrl()
	{
		$url = \Sabre\Uri\normalize(trim($this->root . '/' . $this->relative, '/') . '/');
		return $url;
	}
}
?>