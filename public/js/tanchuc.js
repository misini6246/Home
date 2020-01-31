/**
 * Created by Administrator on 2016/12/2.
 */
function add_tanchuc(str){
    $('#tanchuc').remove();
    $('#body').append("<div id='tanchuc'>" +
    "</div>");
    $('#tanchuc').append(str);
}
