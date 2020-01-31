function get_other() {
    $.ajax({
        url: '/zdtjp',
        type: 'get',
        dataType: 'json',
        success: function (msg) {
            if (msg) {
                var html = "";
                for (var i = 0; i < msg.length; i++) {
                    html += "<li>";
                    html += "<div style='text-align:center'>";
                    html += "<a href='" + msg[i]['goods_url'] + "'><img src='" + msg[i]['goods_thumb'] + "' alt=''/></a>";
                    html += "<p>  <a href='" + msg[i]['goods_url'] + "'>" + msg[i]['goods_name'] + "</a></p>";
                    html += "<p><a>" + msg[i]['spgg'] + "</a></p>";
                    html += "<p class='price'><span class='linshoujia'>" + msg[i]['real_price_format'] + "</span></p>";
                    html += "</div>";
                    html += "</li>";
                }
                $(".zhongdiantj-list").html(html);
            }
        }
    })
}