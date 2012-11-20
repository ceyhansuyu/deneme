<?php
class pagination{
/*
Script Name: *Digg Style Paginator Class
Script URI: http://www.mis-algoritmos.com/2007/05/27/digg-style-pagination-class/
Description: Class in PHP that allows to use a pagination like a digg or sabrosus style.
Script Version: 0.4
Author: Victor De la Rocha
Author URI: http://www.mis-algoritmos.com
*/
		/*Default values*/
		var $total_sayfas = -1;//items
		var $limit = null;
		var $target = ""; 
		var $sayfa = 1;
		var $adjacents = 2;
		var $showCounter = false;
		var $className = "pagination";
		var $parameterName = "sayfa";
		var $urlF = false;//urlFriendly

		/*Buttons next and previous*/
		var $nextT = "Sonraki";
		var $nextI = "&#187;"; //&#9658;
		var $prevT = "Önceki";
		var $prevI = "&#171;"; //&#9668;

		/*****/
		var $calculate = false;
		
		#Total items
		function items($value){$this->total_sayfas = (int) $value;}
		
		#how many items to show per sayfa
		function limit($value){$this->limit = (int) $value;}
		
		#sayfa to sent the sayfa value
		function target($value){$this->target = $value;}
		
		#Current sayfa
		function currentsayfa($value){$this->sayfa = (int) $value;}
		
		#How many adjacent sayfas should be shown on each side of the current sayfa?
		function adjacents($value){$this->adjacents = (int) $value;}
		
		#show counter?
		function showCounter($value=""){$this->showCounter=($value===true)?true:false;}

		#to change the class name of the pagination div
		function changeClass($value=""){$this->className=$value;}

		function nextLabel($value){$this->nextT = $value;}
		function nextIcon($value){$this->nextI = $value;}
		function prevLabel($value){$this->prevT = $value;}
		function prevIcon($value){$this->prevI = $value;}

		#to change the class name of the pagination div
		function parameterName($value=""){$this->parameterName=$value;}

		#to change urlFriendly
		function urlFriendly($value="%"){
				if(eregi('^ *$',$value)){
						$this->urlF=false;
						return false;
					}
				$this->urlF=$value;
			}
		
		var $pagination;

		function pagination(){}
		function show(){
				if(!$this->calculate)
					if($this->calculate())
						$RETURN = "<span class=\"$this->className\">$this->pagination</span>\n";
						return $RETURN;
			}
		function getOutput(){
				if(!$this->calculate)
					if($this->calculate())
						return "<span class=\"$this->className\">$this->pagination</span>\n";
			}
		function get_sayfanum_link($id){
				if(strpos($this->target,'?')===false)
						if($this->urlF)
								return str_replace($this->urlF,$id,$this->target);
							else
								return "$this->target?$this->parameterName=$id";
					else
						return "$this->target&$this->parameterName=$id";
			}
		
		function calculate(){
				$this->pagination = "";
				$this->calculate == true;
				$error = false;
				if($this->urlF and $this->urlF != '%' and strpos($this->target,$this->urlF)===false){
						//Es necesario especificar el comodin para sustituir
						echo "Especificaste un wildcard para sustituir, pero no existe en el target<br />";
						$error = true;
					}elseif($this->urlF and $this->urlF == '%' and strpos($this->target,$this->urlF)===false){
						echo "Es necesario especificar en el target el comodin % para sustituir el número de página<br />";
						$error = true;
					}

				if($this->total_sayfas < 0){
						echo "It is necessary to specify the <strong>number of sayfas</strong> (\$class->items(1000))<br />";
						$error = true;
					}
				if($this->limit == null){
						echo "It is necessary to specify the <strong>limit of items</strong> to show per sayfa (\$class->limit(10))<br />";
						$error = true;
					}
				if($error)return false;
				
				$n = trim($this->nextT.' '.$this->nextI);
				$p = trim($this->prevI.' '.$this->prevT);
				
				/* Setup vars for query. */
				if($this->sayfa) 
					$start = ($this->sayfa - 1) * $this->limit;             //first item to display on this sayfa
				else
					$start = 0;                                //if no sayfa var is given, set start to 0
			
				/* Setup sayfa vars for display. */
				$prev = $this->sayfa - 1;                            //previous sayfa is sayfa - 1
				$next = $this->sayfa + 1;                            //next sayfa is sayfa + 1
				$lastsayfa = ceil($this->total_sayfas/$this->limit);        //lastsayfa is = total sayfas / items per sayfa, rounded up.
				$lpm1 = $lastsayfa - 1;                        //last sayfa minus 1
				
				/* 
					Now we apply our rules and draw the pagination object. 
					We're actually saving the code to a variable in case we want to draw it more than once.
				*/
				
				if($lastsayfa > 1){
						if($this->sayfa){
								//anterior button
								if($this->sayfa > 1)
										$this->pagination .= "<a href=\"".$this->get_sayfanum_link($prev)."\" class=\"prev\">$p</a>";
									else
										$this->pagination .= "<span class=\"disabled\">$p</span>";
							}
						//sayfas	
						if ($lastsayfa < 7 + ($this->adjacents * 2)){//not enough sayfas to bother breaking it up
								for ($counter = 1; $counter <= $lastsayfa; $counter++){
										if ($counter == $this->sayfa)
												$this->pagination .= "<span class=\"current\">$counter</span>";
											else
												$this->pagination .= "<a href=\"".$this->get_sayfanum_link($counter)."\">$counter</a>";
									}
							}
						elseif($lastsayfa > 5 + ($this->adjacents * 2)){//enough sayfas to hide some
								//close to beginning; only hide later sayfas
								if($this->sayfa < 1 + ($this->adjacents * 2)){
										for ($counter = 1; $counter < 4 + ($this->adjacents * 2); $counter++){
												if ($counter == $this->sayfa)
														$this->pagination .= "<span class=\"current\">$counter</span>";
													else
														$this->pagination .= "<a href=\"".$this->get_sayfanum_link($counter)."\">$counter</a>";
											}
										$this->pagination .= "...";
										$this->pagination .= "<a href=\"".$this->get_sayfanum_link($lpm1)."\">$lpm1</a>";
										$this->pagination .= "<a href=\"".$this->get_sayfanum_link($lastsayfa)."\">$lastsayfa</a>";
									}
								//in middle; hide some front and some back
								elseif($lastsayfa - ($this->adjacents * 2) > $this->sayfa && $this->sayfa > ($this->adjacents * 2)){
										$this->pagination .= "<a href=\"".$this->get_sayfanum_link(1)."\">1</a>";
										$this->pagination .= "<a href=\"".$this->get_sayfanum_link(2)."\">2</a>";
										$this->pagination .= "...";
										for ($counter = $this->sayfa - $this->adjacents; $counter <= $this->sayfa + $this->adjacents; $counter++)
											if ($counter == $this->sayfa)
													$this->pagination .= "<span class=\"current\">$counter</span>";
												else
													$this->pagination .= "<a href=\"".$this->get_sayfanum_link($counter)."\">$counter</a>";
										$this->pagination .= "...";
										$this->pagination .= "<a href=\"".$this->get_sayfanum_link($lpm1)."\">$lpm1</a>";
										$this->pagination .= "<a href=\"".$this->get_sayfanum_link($lastsayfa)."\">$lastsayfa</a>";
									}
								//close to end; only hide early sayfas
								else{
										$this->pagination .= "<a href=\"".$this->get_sayfanum_link(1)."\">1</a>";
										$this->pagination .= "<a href=\"".$this->get_sayfanum_link(2)."\">2</a>";
										$this->pagination .= "...";
										for ($counter = $lastsayfa - (2 + ($this->adjacents * 2)); $counter <= $lastsayfa; $counter++)
											if ($counter == $this->sayfa)
													$this->pagination .= "<span class=\"current\">$counter</span>";
												else
													$this->pagination .= "<a href=\"".$this->get_sayfanum_link($counter)."\">$counter</a>";
									}
							}
						if($this->sayfa){
								//siguiente button
								if ($this->sayfa < $counter - 1)
										$this->pagination .= "<a href=\"".$this->get_sayfanum_link($next)."\" class=\"next\">$n</a>";
									else
										$this->pagination .= "<span class=\"disabled\">$n</span>";
									if($this->showCounter)$this->pagination .= "<span class=\"pagination_data\">($this->total_sayfas sayfas)</span>";
							}
					}

				return true;
			}
	}
?>