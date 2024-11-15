<?php

	class DatabaseShell{

		private const OPTIONS = [
			PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
			PDO::ATTR_EMULATE_PREPARES   => false,
		];

		
		private $user;
		private $password;
		private $dsn;
		private $pdo;


		
		public function __construct($host, $user, $password, $dbname){

			$this->user = $user;
			$this->password = $password;
			$this->dsn = "mysql:host=$host;dbname=$dbname";

			$this->connect();

			
		}

		public function queryAll($query, $data = []){

			//выполняет запрос $query.  возвращает несколько записей
			
			$res = $this->pdo->prepare($query);
			//$res->bindValue('id', $id, PDO::PARAM_INT);
			$res->execute($data);

			return $res->fetchAll();
			

		}

		public function query($query, $data = []){

			//выполняет запрос $query. возвращает одну запись
			
			$res = $this->pdo->prepare($query);
			//$res->bindValue('id', $id, PDO::PARAM_INT);
			$res->execute($data);

			return $res->fetch();
			

		}
		
		public function save($table, $data){

			// сохраняет запись в базу

			$keys = array_keys($data); //поля таблицы


			//формируем запрос с посощью вспомогательной функции
			$query = 'INSERT INTO '.$table.' SET '.$this->pdoSet($keys);
			//var_dump($data);
			$stmt = $this->pdo->prepare($query);
			$stmt->execute($data); //сохраняем измененния

		}
		
		public function del($table, $id){
			// удаляет запись по ее id
			$query = 'DELETE FROM '.$table.' WHERE id=:id';

			$res = $this->pdo->prepare($query);
			$res->bindValue('id', $id, PDO::PARAM_INT);
			$res->execute();

		}
		
		public function delAll($table, $ids){
			// удаляет записи по их id
			
			$query = 'DELETE FROM '.$table.' WHERE id=:id';

			$res = $this->pdo->prepare($query);

			foreach($ids as $id){
				$res->bindValue('id', $id, PDO::PARAM_INT);
				$res->execute();
			}

			
		}
		
		public function get($table, $id){
			// получает одну запись по ее id
			
			$query = 'SELECT * FROM '.$table.' WHERE id=:id';

			$res = $this->pdo->prepare($query);

			$res->bindValue('id', $id, PDO::PARAM_INT);
			$res->execute();

			return $res->fetch();


		}
		
		public function getAll($table, $ids){
			// получает массив записей по их id
			$query = 'SELECT * FROM '.$table.' WHERE id=:id';
			$arr = [];

			$res = $this->pdo->prepare($query);

			foreach($ids as $id){
				$res->bindValue('id', $id, PDO::PARAM_INT);
				$res->execute();
				array_push($arr, $res->fetch());
			}

			return $arr;

		}


		public function where($table, $condition){

			// получает массив записей по условию
			$arr = $this->condQuery($condition); //формируем запрос с помощью всп. функции
			$mean = $arr['mean'];   //получаем значение неекотороо условия
			
			$query = 'SELECT * FROM '.$table.' WHERE '.$arr['field'];   //формируем запрос по условию

			$res = $this->pdo->prepare($query);
			
			$res->execute(array('mean' => $mean));

			return $res->fetchAll();
			

		}


		private function connect(){

			$this->pdo = new PDO($this->dsn, $this->user, $this->password, self::OPTIONS);
		}


		private function pdoSet($keys){
			$set = '';
  			
  			foreach ($keys as $key) {
    			$set.="`".str_replace("`","``",$key)."`". "=:$key, ";
  			}
  			return substr($set, 0, -2);;
		}

		private function condQuery($condition){
			//разбиваем условие на части
			$arr = explode(' ', $condition);

			$res['field'] = $arr[0].$arr[1].':mean';
			$res['mean'] = $arr[2];

			return $res; //возвр. именованный массив

		}


	}
?>