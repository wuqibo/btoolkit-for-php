//清除html代码标识符，返回纯文本
function delHtmlTag(str) {
    return str.replace(/<[^>]+>/g,"");
}

//判断字符串里是否存在某个字符串
function containsStr(strAll,strSub){
    return strAll.contains(strSub);
}

//判断元素是否在数组里。最后参数为是否区分大小写
function containsArr(obj, arr, matchCase) {
    var i = arr.length;
    while (i--) {
        if (matchCase) {
            if (arr[i] === obj) {
                return true;
            }
        } else {
            if (arr[i].toLowerCase() == obj.toLowerCase()) {
                return true;
            }
        }
    }
    return false;
}

//从Input输入框里获取图片尺寸
function getImgSize(input,callback){
    var f = input.files[0];
    var reader = new FileReader();
    reader.onload = function (e) {
        var data = e.target.result;
        //加载图片获取图片真实宽度和高度
        var image = new Image();
        image.onload=function(){
            if(callback!=null) {
                callback(input, image.width, image.height);
            }
        };
        image.src= data;
    };
    reader.readAsDataURL(f);
}

//获取图片时检查尺寸和格式
function checkImgTypeAndSize(input,limitKB,readSizeCallback){
    if (input.value != '') {
        //检查后缀名
        var suffixs = ['jpg','jpeg','png','gif'];
        var inputValue = input.value;
        var strArr = inputValue.split('.');
        var suffix = strArr[strArr.length - 1];
        if (!containsArr(suffix, suffixs, false)) {
            var suffixsStr = '';
            for (var i = 0; i < suffixs.length; i++) {
                suffixsStr += ' .' + suffixs[i];
            }
            input.value = '';
            alert('只能选择' + suffixsStr + ' 格式');
            input.value = "";
        }
        //检查尺寸
        getImgSize(input,readSizeCallback);
        //检查文件大小
        var file = input.files[0];
        if(file.size>limitKB*1024){
            alert('图片大小不能超过'+limitKB+'KB');
            input.value = "";
        }
    }
}

//ajax异步处理页面
function ajax(url,callback){
    var xhr = new XMLHttpRequest();
    xhr.open("GET", url, true);
    xhr.setRequestHeader("Content-Type", "application/json");
    xhr.onload = function () {
        if (xhr.status == 200) {
            if(callback!=null) {
                callback(xhr.responseText);
            }
        }
    }
    xhr.send();
}