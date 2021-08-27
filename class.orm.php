<?
class ORM
{

	public static function checkProps($className)
	{
		$pdo=DBConnection::get();

		foreach($className::PERSISTED as $persistedProperty)
		{
			$tableColumns    = $pdo->query("SELECT column_name FROM information_schema.columns WHERE table_name = '".$className::TABLE."' AND table_schema = 'r2ratnic_agg_test'")->fetchAll(PDO::FETCH_COLUMN);			
			$classProperties = get_class_vars($className);

			if(!in_array        ($persistedProperty, $tableColumns))    throw new exception ("Property {$persistedProperty} is in PERSISTED array, but not amongst table fields of ".$className::TABLE);
			if(!array_key_exists($persistedProperty, $classProperties)) throw new exception ("Property {$persistedProperty} is in PERSISTED array, but not amongst class properties of ".$className);
		}
	}



	public static function load($className, $where) :array
	{
		// self::checkProps($className);

		$objects=[];

		$pdo=DBConnection::get();
		$stmt=$pdo->query("select * from `".$className::TABLE."` {$where}");
		while($row=$stmt->fetch())
		{
			// create object
			$Object=new $className;

			// get flat properties			
			foreach($Object::PERSISTED as $persistedProperty)
			{
				$Object->$persistedProperty = $row[$persistedProperty];
			}

			// get pivot properties, if any
			if(defined("{$className}::PIVOTS"))
			{
				foreach($Object::PIVOTS as $pivot)
				{					
					$stmt2=$pdo->prepare("SELECT {$pivot['propertyField']} from {$pivot['table']} where {$pivot['linkingField']}=?");
					$stmt2->execute([$Object->id]);
					while($row=$stmt2->fetch())
					{
						$Object->{$pivot['propertyName']}[]=$row[$pivot['propertyField']];
					}
				}
			}

			// save Object to array
			$objects[]=$Object;
		}

		return $objects; // всегда возвращает массив, так что если знаем, что результат один, можно без перебора, просто добавив [0]
	}




	public static function save(object $Object)
	{
		// self::checkProps($className);

		$debugMode = false;

		$pdo = DBConnection::get();
		$className = get_class($Object);		
		$table = $className::TABLE;
		// $map   = $className::MAP; //чтобы не разрывать стринги запросов
		
		// тело запроса, одинаковое для insert и update
		$queryBase="`{$table}` set ";
		foreach($className::PERSISTED as $persistedProperty)
		{
			$queryBase .= "`{$persistedProperty}`=?, ";
			$dataSet[]  = $Object->$persistedProperty;
		}
		$queryBase = substr($queryBase, 0, -2);

		$insertQuery = "INSERT into {$queryBase}";
		$updateQuery =      "UPDATE {$queryBase} where id=?";

		// update
		if($Object->id > 0)
		{
        	$dataSet[] = $Object->id;
			if($debugMode) { echo $updateQuery.'<br>'; print_r($dataSet); }
			else
			{                
				$stmt = $pdo->prepare($updateQuery);
				$stmt->execute($dataSet);				
			}
		}
		// insert
		else
		{			
			if($debugMode) { echo $insertQuery.'<br>'; print_r($dataSet); }
			else
			{
				$stmt = $pdo->prepare($insertQuery);
				$stmt->execute($dataSet);
				$Object->id = $pdo->lastInsertId();
			}
		}

		// свойства из pivot-таблиц (если у модели вообще есть такие)
		if(defined("{$className}::PIVOTS"))
		{
			$pivotQueries = [];

			// создать запросы для пивот-таблиц: сначала всё удалить (на всякий случай), потом вписать новые
			foreach($Object::PIVOTS as $pivot)
			{
				if(!empty($Object->{$pivot['propertyName']})) // ничего не делать, если пусто в пивот-свойстве
				{
					$pivotQueries[]="DELETE from {$pivot['table']} where {$pivot['linkingField']} = {$Object->id}"; // без prepared statements пока, и так сложно
					foreach($Object->{$pivot['propertyName']} as $pivotPropertyId)
					{
						$pivotQueries[]="INSERT into {$pivot['table']} set {$pivot['linkingField']} = {$Object->id}, {$pivot['propertyField']} = {$pivotPropertyId}";
					}
				}
			}

			// выполнить запросы, если хоть один получился вообще
			if(!empty($pivotQueries))
			{
				if($debugMode) echo '<pre>'.print_r($pivotQueries, true).'</pre>';
				else
				{
					foreach($pivotQueries as $pivotQuery)
					{
						$pdo->query($pivotQuery);
					}
				}
			}

		}
		
		

		return $Object;
	}






	public static function delete(string $className, int $id)
	{
		$pdo = DBConnection::get();
		$stmt = $pdo->prepare("DELETE from ".$className::TABLE." where id=?");		
		$stmt->execute([$id]);

	}




}
?>