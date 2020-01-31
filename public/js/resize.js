window.onload = function() {
	adjust();
	window.onresize = function() {
		adjust();
	};
}

//获取MAP中元素属性
function adjust() {
	var maps = $('map');
	for(var i = 1; i <= maps.length; i++) {
		var map = $('#map' + i).children('area');
		for(var j = 0; j < map.length; j++) {
			var old_coords = map.eq(j).data('coords');
			var ow = old_coords.w;
			var oh = old_coords.h;
			var w = $('#img' + i).width();
			var h = $('#img' + i).height();
			var bili_w = w / ow;
			var bili_h = h / oh;
			var x1 = old_coords.x1 * bili_w;
			var y1 = old_coords.y1 * bili_h;
			var x2 = old_coords.x2 * bili_w;
			var y2 = old_coords.y2 * bili_h;
			map.eq(j).attr('coords', x1 + ',' + y1 + ',' + x2 + ',' + y2);
		}
	}
}