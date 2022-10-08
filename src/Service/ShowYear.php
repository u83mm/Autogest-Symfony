<?php
	namespace App\Service;
	
	class ShowYear
	{
		private $year;
		
		public function showYear(): string {
			$this->year = date("d-m-Y");
			
			return $this->year;
		}
	}
?>
