var timer=setInterval("hello()",2000);  
var mylist=document.getElementById("mylist");  
var num=document.getElementById("mylist").getElementsByTagName("li");  
var now=0;  
var left=0;  
function hello(){  
    // body...  
    // document.write("ddd"+now);  
    if (left<=-(num.length-1)*430) {  
        now=0;  
        left=-now*430;  
        mylist.style.left=left+"px";  
        now=now+1;  
    }else{  
        left=-now*430;  
        mylist.style.left=left+"px";  
        now=now+1;  
    };  
      
}  
//移动的位置  
function toCover(now1){  
    now=now1;  
    left=-now*430;  
    mylist.style.left=left+"px";  
    clearInterval(timer);  
      
}  
var numli=document.getElementById("underNum").getElementsByTagName("li");  
for (var i = 0; i <=numli.length - 1; i++) {  
    numli[i].index=i;  
    numli[i].onmouseover=function(){  
        //alert(this.index);  
        toCover(this.index);      
    };  
    numli[i].onmouseout=function(){  
        //alert(this.index);  
        timer=setInterval("hello()",1000);  
    };  
};  
