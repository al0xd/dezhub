<?php
	class Paging{
		var $iRecordPerpage;
		var $iTotalRecord;
		var $iCurrentPage;
		var $sPagingPath;
		var $title;
		var $iNumberPageShow = 5;	
		
		
		function Paging( $iRecordPerpage, $iTotalRecord, $iCurrentPage, $sPagingPath ){
			$this -> iRecordPerpage = $iRecordPerpage;
			$this -> iTotalRecord = $iTotalRecord;
			$this -> iCurrentPage = $iCurrentPage;
			$this -> sPagingPath = $sPagingPath;
			$this -> title = "Trang {i}";
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
							$sFirstPage = "<li><a title='".str_replace('{i}',1,$this->title)."' href='". str_replace('{i}', 1, $this -> sPagingPath)."'>1</a></li>";
							$sFirstPage .= "<li><a title='".str_replace('{i}',2,$this->title)."'  href='". str_replace('{i}', 2, $this -> sPagingPath)."'>2</a></li>";
							$iTemp = $this -> iCurrentPage - $this -> iNumberPageShow - (($this -> iCurrentPage - 1) % $this -> iNumberPageShow);							
							$sFirstPage .= "<li><a title='".str_replace('{i}',$iTemp,$this->title)."' href='". str_replace('{i}', $iTemp, $this -> sPagingPath)."'>...</a></li>";						
						}
						if($this->iCurrentPage<=1)
							$disabled="disabled";
							
						$sPrePage = "<li class='{$disabled}'><a title='Trang đầu' href='". str_replace('{i}', $this -> iCurrentPage -1 , $this -> sPagingPath)."'>&laquo;</a></li>";
						
						// get next, last page
						if( ceil($this -> iCurrentPage / $this -> iNumberPageShow) < ceil($iNumberPage/$this -> iNumberPageShow)){
							$iTemp = $this -> iCurrentPage + $this -> iNumberPageShow - (($this -> iCurrentPage - 1) % $this -> iNumberPageShow);
							$sLastPage = "<li><a title='".str_replace('{i}',$iTemp,$this->title)."' href='". str_replace('{i}', $iTemp, $this -> sPagingPath)."'>...</a></li>";
							if( $iTemp < $iNumberPage-1)
								$sLastPage .= "<li><a title='".str_replace('{i}',$iNumberPage-1,$this->title)."' href='". str_replace('{i}', $iNumberPage-1, $this -> sPagingPath)."'>".($iNumberPage -1)."</a></li>";						
								$sLastPage .= "<li><a title='".str_replace('{i}',$iNumberPage,$this->title)."' href='". str_replace('{i}', $iNumberPage, $this -> sPagingPath)."'>{$iNumberPage}</a></li>";							
						}
						$disabled="";
						if($this->iCurrentPage >= $iNumberPage)
							$disabled="disabled";
						$sNextPage .= "<li class='{$disabled}'><a title='Trang cuối' href='". str_replace('{i}', $this -> iCurrentPage + 1, $this -> sPagingPath)."'>&raquo;</a></li>";
						
						// get current page
						
						$iStart = $this -> iCurrentPage -(($this -> iCurrentPage - 1) % $this -> iNumberPageShow);
						for ( $i = $iStart; $i< $iStart + $this -> iNumberPageShow; $i ++){
							if( $i > $iNumberPage){ 							
								break;
							}
							elseif( $this -> iCurrentPage == $i){
								$sPaging .= "<li class=\"active\"><a>{$i}</a></li>";
							}else{
								$sPaging .= "<li><a title='".str_replace('{i}',$i,$this->title)."' href ='". str_replace('{i}', $i, $this -> sPagingPath)."'>{$i}</a></li>";
							}
						}
						
						$sStringPaging =  $sPrePage .$sFirstPage ."". $sPaging.$sLastPage. $sNextPage;
						return '<ul class="pagination">'.$sStringPaging."</ul>";
					}else{
						// get pre page
						if( $this -> iCurrentPage <=1){	
							$css_precss=  "disabled";	
						}else
							$title="title='". str_replace('{i}', $this -> iCurrentPage -1 , $this -> title)."'";					
						
						$sPrePage = "<li class=\"".$css_precss."\">
						<a title='Trang đầu' href='". str_replace('{i}', $this -> iCurrentPage -1 , $this -> sPagingPath)."'>&laquo;</a></li>
						<li  class=\"".$css_precss."\"><a {$title}  href='". str_replace('{i}', $this -> iCurrentPage -1 , $this -> sPagingPath)."'>Trang sau</a></li>";											
						
						// get next
						$title="";
						if( $this -> iCurrentPage == $iNumberPage){
							$css_nextcss=  "disabled";						
						}else
							$title="title='". str_replace('{i}', $this -> iCurrentPage+1 , $this -> title)."'";					
						
						$sNextPage .= "<li class='{$css_nextcss}'>
						<a {$title}  href='". str_replace('{i}', $this -> iCurrentPage + 1, $this -> sPagingPath)."'>Trang tiếp</a></li>
						<li class='{$css_nextcss}'><a title='Trang cuối' href='". str_replace('{i}', $this -> iCurrentPage + 1, $this -> sPagingPath)."'>&raquo;</a></li>";
						
					//	$sPaging = "<label style=\"font-weight:normal\">Page</label> <label id=\"p_current_page\">{$this->iCurrentPage}</label> <label style=\"font-weight:normal\">of</label> {$iNumberPage}";
						
						$sStringPaging =  $sPrePage ."". $sPaging."". $sNextPage;
						return '<ul class="pager">'.$sStringPaging."</ul>";
					}
					
				}
			}
			
		}		
		
	}
?>
