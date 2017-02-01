function tweetPost()
{
    var tweet = $("#tweet").val();
    $.ajax({
        type:'POST',
        url:'tweetPost.php',
        data: {
            tweet: tweet
        },
        success:function(result){
            $("#resultTweet").html(result)
        }
    })
};

function follow() {

var user_id = $(this).attr("id");
 $.ajax({
   type: "POST",
   url: "follow.php",
   data: datastring,
   success: function(html){}
 });
    $("#follow").hide();
    $("#remove").show();
    return false;
};


//remove class
function unfollow()
{
var user_id = $(this).attr("id");
 $.ajax({
   type: "POST",
   url: "unfollow.php",
   data: datastring,
   success: function(html){}
 });
   $("#remove").hide();
   $("#follow").show();
    return false;
};
