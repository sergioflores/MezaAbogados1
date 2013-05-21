<?php


class XMLMapping{
	
	static function getEntity($nameEntity){
		
//		echo $_SERVER['HTTP_REFERER'] . "/domain/mapping.xml";
		$xml = simplexml_load_file ( "../domain/mapping.xml" );

		foreach ( $xml->entity as $entity ) {
			
			foreach ( $entity->attributes () as $name => $value ) {
				if($name == "name" && $value == $nameEntity)
					return $entity;
				}
			}
			
			return false;
	}
	
	
	static function getTypeProperty($entity, $nameProperty){
		
		
		foreach ($entity->children() as $child){
			
			$attributes = $child->attributes();
			
			if( $attributes['name'] == $nameProperty){
				return $attributes['type'];
			}
		}
		
		return false;
		
		
	}
}

?>