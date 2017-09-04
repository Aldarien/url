<?php
use PHPUnit\Framework\TestCase;

class URLTest extends TestCase
{
	public function testOutsidePath()
	{
		$url = 'http://www.google.cl';
		
		$this->assertEquals($url, url($url));
	}
	public function testAbsolutePath()
	{
		$url = 'http://localhost/index.php';
		
		$this->assertEquals($url, url($url));
	}
	public function testRelativePath()
	{
		$url = 'index.php';
		
		$result = '/../phpunit/phpunit/index.php';
		
		$this->assertEquals($result, url($url));
	}
}
?>