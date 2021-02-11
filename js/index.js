




function sendChat(){

    var msg = $("#chat").val();
    var receiver = $("#receiver").val();

    if(msg != ""){
        if(receiver != ""){
            $.post("include/chat.php",
            {
                chat: msg,
                receiver: receiver,
            },
            function(data, status){
                $("#chat").val('');
                loginActiveChat();
                scrollDown();

            });

        }else{
            alert("specify your receiver");
        }
    }else{
        alert("Enter your chat message");
    }

}


//var AutoScroll;
var AutoScroll = setInterval(function(){
    scrollDown();
}, 1000);


    function stoppedScroll(){
        setInterval(function(){
            scrollDown();
        }, 1000);
    }

    function stopAutoScroll(){
        clearInterval(AutoScroll);   
    }


 var loadChatOnly = setInterval(function(){
    loginActiveChat();
}, 1000);



function loginActiveChat(){
    $.get("chat-log.php", function(data, status){
        $("#table-active-log").html(data);
    });
}







function scrollDown(){
    var newscrollHeight = $(".chat-log-table")[0].scrollHeight;
 //   console.log(newscrollHeight);
    $(".chat-log-table").animate({ scrollTop: newscrollHeight }, 'normal'); //Autoscroll to bottom of div
}



function convertTimestamptoTime(unix) { 
    const unixTime = unix;
    const date = new Date(unixTime*1000);
    var current = date.toLocaleTimeString();
    var onlyTimeDigit = current.substr(0, 4);
    var onlyTimeLetter = current.substr(7, 8);
    var updateLetter = onlyTimeLetter.toLowerCase();
    var completeTime = onlyTimeDigit + updateLetter;
    return completeTime;
} 