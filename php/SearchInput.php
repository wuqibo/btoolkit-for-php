<?php

if(isset($_GET['keywords'])){
    $keywords = $_GET['keywords'];
    $backUrl = $_GET['backUrl'];
    SearchInput::setCurrKeywords($keywords);
    header('location:'.$backUrl);
    exit;
}

class SearchInput{

    static function setCurrKeywords($keywords){
        if(!session_id())session_start();
        $_SESSION['CurrKeywords'] = $keywords;
    }

    static function getCurrKeywords(){
        if(isset($_SESSION['CurrKeywords'])) {
            return $_SESSION['CurrKeywords'];
        }
        return '';
    }

    static function echoSearchInput(){
        echo '<span style="font-size:15px">';
        echo '
            <script type="text/javascript">
                function onKeyDown(){
                    if (event.keyCode == 13) {
                        search();
                    }
                }
                function search(){
                    var keywords = document.getElementById("keywords").value;
                    var backUrl = document.getElementById("valueHolder").value;
                    location.href="btools/php/SearchInput.php?keywords="+keywords+"&backUrl="+backUrl;
                }
            </script>
            ';
        $currFullUrl = BTool::getFullURL();
        echo '<input id="valueHolder" type="hidden" value="'.$currFullUrl.'" />';
        echo '<input id="keywords" type="text" value="' . SearchInput::getCurrKeywords() . '" style="text-align:center" size="15" onkeypress="onKeyDown()" />';
        echo  ' <button onclick="search()" style="background-color:#dddddd">搜索</button>';
        echo '</span>';
    }
}