var start = 5;

window.addEventListener('scroll', function(e){
    if (window.scrollY == document.body.scrollHeight - window.innerHeight)
    {
        this.console.log(start);
        if (this.window.XMLHttpRequest)
            var myReq = new XMLHttpRequest();
        else
            var myReq = new ActiveXObject("Microsoft.XMLHTTP");
        myReq.open("POST", "home.php?action=getdata", true);
        myReq.setRequestHeader("content-type", "application/x-www-form-urlencoded");
        myReq.send("start=" + start);
        myReq.onreadystatechange=function()
        {
            var myResponseDiv = document.getElementById("result");
            if (myReq.status == 200 && myReq.readyState == 4)
            {
                var div = document.createElement("div");
                div.innerHTML = myReq.responseText;
                myResponseDiv.appendChild(div);
            }
            else if (myReq.status == 200 && myReq.readyState < 4)
                myResponseDiv.apend= "loading ...";
            else
                myResponseDiv.innerHTML= "error";
        }
        start = start + 2;
    }
});