<?php

/**
*  Corresponding Class to test ApiConnect class
*
*  @author Nvenne
*/
class ApiConnectTest extends PHPUnit_Framework_TestCase{

  /**
  * Just check if the ApiConnect has no syntax error
  *
  * This is just a simple check to make sure your library has no syntax error.
  *
  */
  public function testIsThereAnySyntaxError(){
	$var = new NvenneLU\LuApiphp\ApiConnect(getenv('API_KEY'), getenv('API_HOST'));
	$this->assertTrue(is_object($var));
	unset($var);
  }

  /**
  * Just checks if the setMethod does not run into an exception
  *
  */
  public function testSetMethod(){
		$var = new NvenneLU\LuApiphp\ApiConnect(getenv('API_KEY'), getenv('API_HOST'));
		$this->assertNull($var->setMethod("GET"));
		unset($var);
  }

	/**
  * Just checks if the bind does not run into an exception
  *
  */
	public function testBind(){
		$var = new NvenneLU\LuApiphp\ApiConnect(getenv('API_KEY'), getenv('API_HOST'));
		$this->assertNull($var->bind(array("limit" => 10)));
		unset($var);
  }

	/**
  * Just checks if call() returns an object, if it does then it has executed properly
  *
  */
	public function testCall(){
		$var = new Nvenne\LuApiphp\ApiConnect(getenv('API_KEY'), getenv('API_HOST'));
		$var->setMethod("GET");
		$this->assertTrue(is_object($var->call("permissions")));
		unset($var);
  }

}
