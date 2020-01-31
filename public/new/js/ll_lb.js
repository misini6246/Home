/**
 * Created by Administrator on 2017-03-24.
 */

var k = 0;

function move_pic(id) {
    var pic = $('#pic' + id);
    var old_pic = $('#pic' + k);
    var tip = $('#tip' + id);
    var old_tip = $('#tip' + k);
    var bgc = $('#bgc' + id);
    var old_bgc = $('#bgc' + k);
    k = id;
    old_pic.fadeOut(1000);
    old_bgc.fadeOut(1000);
    old_tip.css('opacity', 0.8);
    pic.fadeIn(2000);
    bgc.fadeIn(2000);
    tip.css('opacity', 1)

}