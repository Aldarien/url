<?php
use PHPUnit\Framework\TestCase;

class URLTest extends TestCase
{
	public function testOutsidePath()
	{
		$url = 'http://www.google.cl';
		
		$this->assertEquals($url, url($url));
	}
	public function testAbsoluteFile()
	{
		$url = 'http://localhost/index.php';
		
		$this->assertEquals($url, url($url));
	}
	public function testRelativeFile()
	{
		$url = 'index.php';
		
		$result = '/../phpunit/phpunit/index.php';
		
		$this->assertEquals($result, url($url));
	}
	public function testUpperRelativeFile()
	{
		$url = '../index.php';
		$result = '/../phpunit/index.php';
		
		$this->assertEquals($result, url($url));
	}
	public function testMaxUpperRelativeFile()
	{
		$url = '../../../../../index.php';
		$result = '/index.php';
		$this->assertEquals($result, url($url));
	}
	public function testRelativePath()
	{
		$url = '/';
		$result = '/';
		$this->assertEquals($result, url($url));
	}
}
?>