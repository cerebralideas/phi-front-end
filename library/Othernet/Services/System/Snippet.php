<?php
class Othernet_Services_System_Snippet {
	public static function Snippet($text,$length=40,$tail="...") 
	{
		/* get rid of white space */
		$text = stripcslashes(trim($text));
		
		/* if we are already at or below text length, then lets just return */
		if(strlen($text) <= $length)
		{
			return $text;
		}
		
		if(strpos($text, " ") !== false)
		{
			/* explode on spaces */
			$textParts = explode(" ", $text);
			$delimiter = " ";
		}
		else if(strpos($text, "+") !== false)
		{
			/* explode on spaces */
			$textParts = explode("+", $text);
			$delimiter = " ";
		}
		else if(strpos($text, "_") !== false)
		{
			/* explode on spaces */
			$textParts = explode("+", $text);
			$delimiter = " ";
		}
		else if(strpos($text, "-") !== false)
		{
			/* explode on spaces */
			$textParts = explode("+", $text);
			$delimiter = " ";
		}
		
		
		if(count($textParts) == 1)
		{
			return substr($text, 0, $length).$tail;
		}
		
		/* get our return vars ready */
	    $returnTextLine = "";
	    
	    /* loop over every text part */
	    $finish = false;
	    foreach($textParts as $key => $item)
	    {
	    	if(strlen($returnTextLine) + strlen($item) < $length)
	    	{
	    		/* keep adding items */
				if($returnTextLine != '')
				{
	    			$returnTextLine .= $delimiter.$item;
				}
				else 
				{
					$returnTextLine = $item;
				}
	    	}
	    	else
	    	{
	    		$finish = true;
	    	}
	    	
	    	/* if we are over length, then we can add it to the return with a line break */
	    	if(strlen($returnTextLine) >= $length || $finish)
	    	{
	    		return Othernet_Services_System_Snippet::_cleanEnding($returnTextLine).$tail;
	    	}
	    }
	    return trim($returnTextLine);
	}
	
	public static function AddLineBreak($text,$break = "\n", $length=40) 
	{
	    /* get rid of white space */
		$text = trim($text);
	    
		/* explode on spaces */
		$textParts = explode(" ", $text);
		
		/* get our return vars ready */
	    $returnText = "";
	    $returnTextLine = "";
	    
	    /* loop over every text part */
	    foreach($textParts as $key => $item)
	    {
	    	/* keep adding items */
	    	$returnTextLine .= " ".$item;
	    	
	    	/* if we are over length, then we can add it to the return with a line break */
	    	if(strlen($returnTextLine) >= $length)
	    	{
	    		$returnText .= trim($returnTextLine)." ".$break;
	    		$returnTextLine = "";
	    	}
	    }
	    
	    /* get the last line */
	    $returnText .= trim($returnTextLine);
	    
	    /* send back the text */
	    return trim($returnText);
	}
	
	public static function formatPhone($phone, $ext = false)
	{
		$phone = preg_replace("/[^0-9]/", "", $phone);
		if(strlen($phone) == 7)
			$phone = preg_replace("/([0-9]{3})([0-9]{4})/", "$1-$2", $phone);
		elseif(strlen($phone) == 10)
			$phone = preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4})/", "($1) $2-$3", $phone);
		
		$phone = trim($phone);
		if($phone != '' && $ext)
		{
			$phone .= ' Ext: '.$ext;
		}
		
		return $phone;
	}
	
	public static function formatAccountDisplay($account)
	{
		
		return
			preg_replace("/[a-z0-9]/", "#", substr($account, 0, -4))
			.substr($account, -4);
	}
	
	public static function convertFieldToCamel($field)
	{
		if(strpos($field, "_") !== false)
		{
			$fieldParts = explode("_", $field);
			foreach($fieldParts as $key => $item)
			{
				if($key != 0)
				$fieldParts[$key] = ucfirst($item);
			}
			$field = implode($fieldParts);
		}
		
		return $field;
	}
	
	public static function convertFieldToUnderScore($field)
	{
		if(strpos($field, "_") === false && strlen($field) > 0)
		{
			$counter = 0;
			while(preg_match('/([a-z_]+)([A-Z]+)([^\s]*)/', $field))
			{
				$counter++;
				$field = preg_replace('/([a-z_]+)([A-Z]+)([^\s]*)/e', 'strtolower("$1_$2")."$3";', $field);
				if($counter >= 20)
				{
					throw new Exception("Recrusive loop trying to convert [".$field."] to lowercase", E_ERROR);
				}
			}
		}
		return $field;
	}
	
	private static function _cleanEnding($text)
	{
		return trim(preg_replace("/[^a-z0-9]$/i", '', $text));
	}
}