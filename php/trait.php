<?php


class A{
	use Two;
	use One;

	public function aaa($value='')
	{
		var_dump($this->a);
	}
}


Trait One{
	private $a = 'aaaaa';
	private static $b = [
		1,2,4
	];
}

Trait Two{

	public function getTwo($value='')
	{
		var_dump($this->a);
		var_dump(A::$b);
	}
}

class B{
	use Two;
}

(new A)->getTwo();

