<?php

	class CookieShell
	{
		public function set($name, $value, $time)
		{
			// устанавливает куки
			// $time задает время в сек, через сколько кука умрет
			setcookie($name, $value, time() + $time);
			$_COOKIE[$name] = $value; // принудительно запишем в массив
		}
		
		public function get($name)
		{
			// получает куки
			if(isset($_COOKIE[$name])){
				return $_COOKIE[$name];
			} else {
				return null;
			}
			
		}
		
		public function del($name)
		{
			// удаляет куки
			if (isset($_COOKIE[$name])) {
				setcookie($name, '', time());
				unset($_COOKIE[$name]);
			}
		}
		
		public function exists($name)
		{
			// проверяет наличие куки
			if (isset($_COOKIE[$name])) {
				return true;
			} else {
				return false;
			}
		}
	}
?>