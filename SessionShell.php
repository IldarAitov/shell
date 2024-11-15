<?php

	class SessionShell
	{
			// Удобно стартуем сессию в конструкторе класса:
			public function __construct(){

				if (!isset($_SESSION)) {
					session_start();
				}
			}
			
			public function set($name, $value){
				// устанавливает переменную сессии
				$_SESSION[$name] = $value;
			}
			
			public function get($name){
				// получает переменную сессии
				if(isset($_SESSION[$name])){
					return $_SESSION[$name];
				} else {
					return null;
				}
			}
			
			public function del($name){
				// удаляет переменную сессии
				unset($_SESSION[$name]);
			}
			
			public function exists($name){
				// проверяет переменную сессии
				if(isset($_SESSION[$name])){
					return true;
				} else {
					return null;
				}
			}
			
			public function destroy(){
				// разрушает сессию
				session_destroy();
			}
	}
?>