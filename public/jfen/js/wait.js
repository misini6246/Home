/**
 * Created by wang on 14-10-10.
 */
function wait(parent){
    var html="<div class='change_black'></div>";
    parent.append(html);
    $(".change_black").css({width: parent.css("width"),height: parent.css("height")});
    parent.css({position: "relative"});
}
function remove_wait(){
    $(".change_black").remove();
    parent.css({position: "static"});
}