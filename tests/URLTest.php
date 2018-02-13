<?php
use PHPUnit\Framework\TestCase;

class URLTest extends TestCase
{
	public function testOutsidePath()
	{
		$url = 'http://www.google.cl';
		
		$this->assertEquals($url, url($url));
	}
	public function testOutsideFile()
	{
		$url = 'http://www.google.cl/file.php';
		$this->assertEquals($url, url($url));
	}
	public function testAbsoluteFile()
	{
		$url = 'http://test.example.com/page.php';
		$this->assertEquals($url, url($url));
	}
	public function testRelativeFile()
	{
		$url = 'page.php';
		$result = 'http://test.example.com/testing/page.php';
		
		$this->assertEquals($result, url($url));
	}
	public function testUpperRelativeFile()
	{
		$url = 'data/../page.php';
		$result = 'http://test.example.com/testing/page.php';
		
		$this->assertEquals($result, url($url));
	}
	public function testMaxUpperRelativeFile()
	{
		$url = '/data/../../../../../page.php';
		$result = 'http://example.com/page.php';
		$this->assertEquals($result, url($url));
	}
	public function testRelativePath()
	{
		$url = '/data';
		$result = 'http://test.example.com/data';
		$this->assertEquals($result, url($url));
	}
	public function testQuery()
	{
		$url = '';
		$query = ['p' => 'page', 'o' => 'options'];
		$output = 'http://test.example.com/testing/?p=page&o=options';
		$result = url($url, $query);
		$this->assertEquals($output, $result);
	}
	public function testDifferentServer()
	{
		$_SERVER['SCRIPT_NAME'] = 'test.example.com/testing/index.php';
		
		$url = 'page.php';
		$output = 'http://test.example.com/testing/page.php';
		$result = url($url);
		$this->assertEquals($output, $result);
	}
}
?>