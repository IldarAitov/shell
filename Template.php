<?php

	class Template
	{

		private $values = array();
		private $html;
		
		//функция устанавливает переменные
		public function set_value($key, $val){
			$key = '{{ '.$key.' }}';
			$this->values[$key] = $val;
		}
		
		//функция принимает переменные в виде массива
		public function set_values_arr($arr){
			foreach($arr as $key => $val){
				$this->set_value($key, $val);
			}
		}


		//функция загрузки шаблона
		public function set_tpl($tpl_name){
			if(empty($tpl_name) || !file_exists($tpl_name)){
				return false;
			} else {
				$this->html = file_get_contents($tpl_name);
				//$this->html = join('', file($tpl_name));
			};
		}

		
		//функция вывода шаблона
		public function get_html(){
			return $this->html;
		}
		
		//заменяет переменные в шаблоне
		public function tpl_parse(){
			foreach($this->values as $find => $replace){
				$this->html = str_replace($find, $replace, $this->html);
			};
		}
	}
?>