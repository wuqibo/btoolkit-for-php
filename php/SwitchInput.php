<?php
class SwitchInput{

    static function setCallbackPage($pageName){
        if(!session_id())session_start();
        $_SESSION['CallbackPage'] = $pageName;
    }

    static function getCallbackPage(){
        if(isset($_SESSION['CallbackPage'])) {
            return $_SESSION['CallbackPage'];
        }
        return '';
    }

    static function echoSwitchInput($currPageName, $currInput, $currPage){
        SwitchInput::setCallbackPage($currPageName);
        echo '<span style="font-size:15px">';
        echo '
            <script type="text/javascript">
                function showByUserId(pageNum){
                    var checkUserId = document.getElementById("checkUserId").value;
                    if(checkUserId == "" || checkUserId == "我的云图" || checkUserId == "全部会员"){
                        alert("请输入要查看的账号");
                        return;
                    }
                    location.href="iframe_complete.php?page="+pageNum+"&manageuserid="+checkUserId;
                }
                function showMine(pageNum){
                    document.getElementById("checkUserId").value = "";
                    location.href="iframe_complete.php?page="+pageNum+"&manageuserid=mine";
                }
                function showAll(pageNum){
                    document.getElementById("checkUserId").value = "";
                    location.href="iframe_complete.php?page="+pageNum+"&manageuserid=all";
                }
            </script>
            ';
        if($currInput == 'all'){
            $currInput = '全部会员';
        }else if($currInput == ''){
            $currInput = '我的云图';
        }
        echo '会员云图：<input id="checkUserId" type="text" value="' . $currInput . '" style="text-align:center" size="10" />';
        echo  ' <button onclick="showByUserId('.$currPage.')" style="background-color:#dddddd">指定账号</button>';
        echo  ' <button onclick="showMine('.$currPage.')" style="background-color:#dddddd">我的云图</button>';
        echo  ' <button onclick="showAll('.$currPage.')" style="background-color:#dddddd">全部会员</button>';
        echo '</span>';
    }
}