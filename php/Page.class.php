<?php
include_once 'BUtils.php';

if (isset($_GET['pagesize'])) {
    setPageSize($_GET['pagename'],$_GET['pagesize']);
    $backUrl = $_GET['backurl'];
    header('Location:'.$backUrl);
    exit;
}

function setPageSize($pageName,$size){
    if(!session_id())session_start();
    $_SESSION['PageSize_'.$pageName] = $size;
}

function getPageSize($pageName){
    if(isset($_SESSION['PageSize_'.$pageName])) {
        return $_SESSION['PageSize_'.$pageName];
    }
    return 20;
}



class Page{

    public $pageSize;
    public $currPageNum;
    public $pageStart;
    public $pageCount;

    function Page($pageParam,$pageSize = 20){
        $this->currPageNum = (empty($_GET[$pageParam])||$_GET[$pageParam]=='undefined')?1:$_GET[$pageParam];
        $this->pageStart = ($this->currPageNum-1)*$this->pageSize;
        $this->pageSize = $pageSize;
    }

    function setPageCountQuery($conn,$sql) {
        $result = mysqli_query($conn->conn,$sql);
        if ($result) {
            $this->pageCount = ceil($result->num_rows / $this->pageSize);
            if($this->currPageNum > $this->pageCount){
                $this->currPageNum = $this->pageCount;
            }
            $this->pageStart = ($this->currPageNum-1)*$this->pageSize;
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

    function echoPageSizeInput(){
        echo '<span style="font-size:15px">';
        echo '
            <script type="text/javascript">
                function setPageSize(backURL){
                    var pageSize = document.getElementById("pageSize").value;
                    location.href="/cloudar/admin/btools/php/Page.php?pagesize="+pageSize+"&backurl="+backURL;
                }
            </script>
            ';
        echo '每页数量 <input id="pageSize" type="text" value="' . getPageSize(BTool::getCurrPageName()) . '" style="text-align:center" size="3" />';
        $fullURL = BTool::getFullURL().'&pagename='.BTool::getCurrPageName();
        echo  ' <button id="'.$fullURL.'" onclick="setPageSize(this.id)">确定</button>';
        echo '</span>';
    }

    function echoPageBtns(){
        echo '共'.$this->pageCount.'页';
        if($this->pageCount>1){
            for($i = 1;$i<=$this->pageCount;$i++){
                if($i == $this->currPageNum){
                    echo ' <a href="javascript:null" style="color:#000000;font-weight:bold;">' .$i.'</a> ';
                }else{
                    $fullUrl = BTool::getFullURLWithoutParams();
                    $params = BTool::getParamsFromUrl();
                    $newParamsWithoutPage = '';
                    if(!empty($params)) {
                        $paramsArr = explode('&', $params);
                        if(count($paramsArr)>0){

                            for($j=0;$j<count($paramsArr);$j++){
                                if(!BTool::containsStr($paramsArr[$j],'page=')){
                                    $newParamsWithoutPage = $newParamsWithoutPage.'&'.$paramsArr[$j];
                                }
                            }
                        }
                    }
                    $fullUrl = $fullUrl.'?page='.$i.$newParamsWithoutPage;
                    echo  ' <a href="'.$fullUrl.'" style="color:#999999;">'.$i.'</a> ';
                }
            }
        }
    }

}