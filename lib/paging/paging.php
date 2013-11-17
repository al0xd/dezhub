<?php
	class paging{
		var $iRecordPerpage;
		var $iTotalRecord;
		var $iCurrentPage;
		var $sPagingPath;
		var $iNumberPageShow = 5;	
		
		
		function paging( $iRecordPerpage, $iTotalRecord, $iCurrentPage, $sPagingPath ){
			$this -> iRecordPerpage = $iRecordPerpage;
			$this -> iTotalRecord = $iTotalRecord;
			$this -> iCurrentPage = $iCurrentPage;
			$this -> sPagingPath = $sPagingPath;
		}
		
		function getStringPaging( $iType = 1)
		{
			//var $sPaging = "";
			
			
			if($this -> iTotalRecord <= 0){
				return $sPaging; 
			}else{				
				$iNumberPage = ceil($this -> iTotalRecord / $this -> iRecordPerpage);
				if( $iNumberPage < 2){
					return  $sPaging;
				}else{
				
					if( $this -> iCurrentPage <= 0 ) $this -> iCurrentPage = 1;
					if ($this -> iCurrentPage > $iNumberPage ) $this -> iCurrentPage = $iNumberPage;
					
					if( $iType == 1){
						// get first, pre page
						if( $this -> iCurrentPage > $this -> iNumberPageShow){
							$sFirstPage = "<li><a  href='". str_replace('{i}', 1, $this -> sPagingPath)."'>1</a></li>";
							$sFirstPage .= "<li><a  href='". str_replace('{i}', 2, $this -> sPagingPath)."'>2</a></li>";
							$iTemp = $this -> iCurrentPage - $this -> iNumberPageShow - (($this -> iCurrentPage - 1) % $this -> iNumberPageShow);							
							$sFirstPage .= "<li><a  href='". str_replace('{i}', $iTemp, $this -> sPagingPath)."'>...</a></li>";						
						}
						
							$sPrePage = "<li class=\"prev\"><a  href='". str_replace('{i}', $this -> iCurrentPage -1 , $this -> sPagingPath)."'>Trang trước</a></li>";
						
						// get next, last page
						if( ceil($this -> iCurrentPage / $this -> iNumberPageShow) < ceil($iNumberPage/$this -> iNumberPageShow)){
							$iTemp = $this -> iCurrentPage + $this -> iNumberPageShow - (($this -> iCurrentPage - 1) % $this -> iNumberPageShow);
							$sLastPage = "<li><a  href='". str_replace('{i}', $iTemp, $this -> sPagingPath)."'>...</a></li>";
							if( $iTemp < $iNumberPage-1)
								$sLastPage .= "<li><a  href='". str_replace('{i}', $iNumberPage-1, $this -> sPagingPath)."'>".($iNumberPage -1)."</a></li>";						
							$sLastPage .= "<li><a   href='". str_replace('{i}', $iNumberPage, $this -> sPagingPath)."'>{$iNumberPage}</a></li>";							
						}
						
							$sNextPage .= "<li  class=\"next\"><a  href='". str_replace('{i}', $this -> iCurrentPage + 1, $this -> sPagingPath)."'>Trang sau</a></li>";
						
						// get current page
						
						$iStart = $this -> iCurrentPage -(($this -> iCurrentPage - 1) % $this -> iNumberPageShow);
						for ( $i = $iStart; $i< $iStart + $this -> iNumberPageShow; $i ++){
							if( $i > $iNumberPage){ 							
								break;
							}
							elseif( $this -> iCurrentPage == $i){
								$sPaging .= "<li class=\"active\"><a>{$i}</a></li>";
							}else{
								$sPaging .= "<li><a  href ='". str_replace('{i}', $i, $this -> sPagingPath)."'>{$i}</a></li>";
							}
						}
						
						$sStringPaging =  $sPrePage .$sFirstPage ."". $sPaging.$sLastPage. $sNextPage;
					}else{
						// get pre page
						if( $this -> iCurrentPage > 1){							
							$sPrePage = "<li><a  href='". str_replace('{i}', $this -> iCurrentPage -1 , $this -> sPagingPath)."'>&laquo;</a></li><li><a  href='". str_replace('{i}', $this -> iCurrentPage -1 , $this -> sPagingPath)."'>Prev</a></li>";											
						}
						
						// get next
						if( $this -> iCurrentPage < $iNumberPage){
							$sNextPage .= "<li><a  href='". str_replace('{i}', $this -> iCurrentPage + 1, $this -> sPagingPath)."'>Next</a></li><li><a href='". str_replace('{i}', $this -> iCurrentPage + 1, $this -> sPagingPath)."'>&raquo;</a></li>";
						}
						
						$sPaging = "<label style=\"font-weight:normal\">Page</label> <label id=\"p_current_page\">{$this->iCurrentPage}</label> <label style=\"font-weight:normal\">of</label> {$iNumberPage}";
						
						$sStringPaging =  $sPrePage ."". $sPaging."". $sNextPage;
					}
					
				}
			}
			
			return '<ul class="pagination pagination-centered">'.$sStringPaging."</ul>";
		}		
		
	}
?>
