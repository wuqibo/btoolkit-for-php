<?php
class Page{

    public $pageSize;
    public $currPageNum;
    public $pageStart;
    public $pageCount;

    function Page($pageSize,$pageParamName){
		$this->pageSize = $pageSize;
        $this->currPageNum = empty($_GET[$pageParamName])?1:$_GET[$pageParamName];
        $this->pageStart = ($this->currPageNum-1)*$this->pageSize;
    }

    function setPageCount($sql) {
        $result = DB::query($sql);
        if ($result) {
            $this->pageCount = ceil($result->rowCount() / $this->pageSize);
        }
    }

    function getPreviousPage(){
        $this->currPageNum = $this->currPageNum - 1;
        if($this->currPageNum < 1){
            $this->currPageNum = 1;
        }
        return $this->currPageNum;
    }

    function getNextPage(){
        $this->currPageNum = $this->currPageNum + 1;
        if($this->currPageNum > $this->pageCount){
            $this->currPageNum = $this->pageCount;
        }
        return $this->currPageNum;
    }

}