<?php



	class Validator
	{
		public function isEmail($str)
		{
			// проверяет строку на то, что она корректный email
			if(filter_var($str, FILTER_VALIDATE_EMAIL)){
				return true;
			} else {
				return false;
			}
		}
		
		public function inRange($num, $from, $to)
		{
			// проверяет число на то, что оно входит в диапазон
			return in_array($num, range($from, $to));
		}
		
		public function inLength($str, $from, $to)
		{
			// проверяет строку на то, что ее длина входит в диапазон
			$lenStr = strlen($str);

			return $this->inRange($lenStr, $from, $to);

		}
	}
?>