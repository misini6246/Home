/**
 * Created by Administrator on 2016/1/26.
 */
function lastPage(){
    var lastPage = $('#lastPage').val();
    var currentPage = $('#currentPage').val();
    if(parseInt(currentPage)>parseInt(lastPage)){
        alert('你要访问的页码不存在!');
        return false;
    }
}