<?php

class TextInput
{
    public $String= '';
    public function add($input)
    {
        $this->String=$this->String.$input;
        return $this->String;
    }
    public function getValue()
    {
        return $this->String;
        
    }
}

class NumericInput extends TextInput
{
    function add($input)
    {

        if( preg_match('/^\d+$/',$input)){
        $this->String=$this->String.$input;    
        }
        

    }
}

$input = new NumericInput();
$input->add('1');
$input->add('a');
$input->add('0');
echo $input->getValue();


class Thesaurus
{
    private $thesaurus;

    function Thesaurus($thesaurus)
    {
        $this->thesaurus = $thesaurus;
    }

    public function getSynonyms($word)
    {
        $ret=array();
        foreach($this->thesaurus as $key=>$value)
        {
            if($key==$word)
            {

                $myjson = array(
                    "word"=>$word,
                    "synonyms"=>$value
                 );
                
             $ret = array_merge($ret,$myjson);
            }
            
        }
        if(count($ret)>0)
        {
            return json_encode($ret);
        }
        else
        {
            $myjson = array(
                "word"=>$word,
                 "synonyms"=>array(),
             );
            return json_encode($myjson);
        }
    }
}

$thesaurus = new Thesaurus(
    array 
        (
            "buy" => array("purchase"),
            "big" => array("great", "large")
        )); 

echo $thesaurus->getSynonyms("big");
echo "\n";
echo $thesaurus->getSynonyms("agelast");


class Pipeline
{
    public static function make_pipeline()
    {
        
        $args       =   func_get_args();
        
        $function   =   function($arg) use ($args)
        {
           
            foreach($args as $function) {
                
                if(!isset($value))
                    $value  =   $function($arg);
               
                else
                    $value  =   $function($value);
            }
            
            return $value;
        };
        
        return $function;
    }
}

$fun = Pipeline::make_pipeline(function($x) { return $x * 3; }, function($x) { return $x + 1; },
                          function($x) { return $x / 2; });
echo $fun(3);


class Path  {
    
    public $currentPath;
        function __construct($path) {
            $this->currentPath = $path;
        } 
    public function cd($newPath)
        {
            $dir = explode('/', $this->currentPath);
            $cd  = explode('/', $newPath);
            $count = 0;
            foreach($cd as $key => $value){
                if($value == '..'){
                    $count += 1;
                    unset($cd[$key]);
                }
            }
            
            $result = '';
            for($i=0; $i<= (count($dir)-1-$count); $i++){
                $result .= $dir[$i].(($i == (count($dir)-1-$count)) ? '' : '/'); 
            }
            
            $tmp_cd = implode('/',$cd);
            $this->currentPath = $result.(strlen($tmp_cd)>0 ? '/'.$tmp_cd : '');
    
            return $this;
        }
    }
    $path = new Path('/a/b/c/d');
    $path->cd('../x');
    echo $path->currentPath;


    class Palindrome
{
    public static function isPalindrome($word)
    {
        
        $palindrome =  strrev($word);
    
    if(strcasecmp($palindrome, $word) == 0){

        return True;

    } else {

        return False; 

    }
    }
}

echo Palindrome::isPalindrome('Deleveled');


class MergeNames
{
    public static function unique_names($array1, $array2)
    {
    	$result=array_unique(array_merge($array1,$array2));
        return $result;
    }
}

$names = MergeNames::unique_names(['Ava', 'Emma', 'Olivia'], ['Olivia', 'Sophia', 'Emma']);
echo join(', ', $names); 


class LeagueTable
{
	public function __construct($players)
    {
		$this->standings = array();
		foreach($players as $index=>$p)
        {
        	$this->standings[$p] = array
            (
                'index' => $index,
                'name' => $p,               
                'games_played' => 0, 
                'score' => 0
            );
        }
        
	}
		
	public function recordResult($player, $score)
    {
		$this->standings[$player]['games_played']++;
		$this->standings[$player]['score'] += $score;
	}
	
	public function playerRank($rank)
    {
       usort($this->standings, function($a,$b){
       	
       	$r = $b['score'] - $a['score'];
       	if(! $r) {
       		$r = $a['games_played'] - $b['games_played'];
       			}
       	if(! $r) {
    		$r = $a['index'] - $b['index'];
  				}
  		return $r;

       });

       return $this->standings[$rank-1]['name'];
       	
	}
}
      
$table = new LeagueTable(array('Mike', 'Chris', 'Arnold'));
$table->recordResult('Mike', 2);
$table->recordResult('Mike', 3);
$table->recordResult('Arnold', 5);
$table->recordResult('Chris', 5);
echo $table->playerRank(1);

class FileOwners
{
    public static function groupByOwners($files)
    {
        $result=array();
        foreach($files as $key=>$value)
        {
            $result[$value][]=$key;
        }
        return $result;
    }
}

$files = array
(
    "Input.txt" => "Randy",
    "Code.py" => "Stan",
    "Output.txt" => "Randy"
);
var_dump(FileOwners::groupByOwners($files));

