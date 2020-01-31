<?php
/**
 * Created by PhpStorm.
 * User: chunyang
 * Date: 2017-05-31
 * Time: 16:56
 */

namespace App\Common;


trait Page
{

    public $result;

    public $currentPage;

    public $lastPage;

    public $num1;
    public $num2;

    /*
 * 分页视图
 */
    public function pagesView($num1 = 3, $num2 = 3)
    {
        $this->num1        = $num1;
        $this->num2        = $num2;
        $this->currentPage = $this->result->currentPage();
        $this->lastPage    = $this->result->lastPage();
        $pagesForm         = $this->pagesForm();//当前页面后面所显示的页码数
        $pages             = $this->pages();
        $pages             = '
    <div class="listPageDiv">
        <div class="pageList">
            ' . $pages . '
        </div>
        ' . $pagesForm . '
    </div>
    <div style="clear: both;"></div>';
        return $pages;
    }

    /*
     * 分页-跳转页面form
     */
    public function pagesForm()
    {
        $input = '';
        if ($this->lastPage > 1) {
            foreach ($this->result->params as $k => $v) {
                if ($k !== 'page') {
                    $input .= '<input value="' . $v . '" name="' . $k . '" type="hidden">';
                }
            }
            $input = '<form action="' . $this->result->url(1) . '" type="get" class="submit_input" onsubmit="return last_page(\'' . $this->result->url(1) . '\',' . $this->lastPage . ')">
        <span>共' . $this->lastPage . '页</span>
        <span>到第<input name="page" class="page_inout" value="' . $this->currentPage . '" type="text" id="currentPage">页</span>
        <input value="确定" class="submit" type="submit">
        ' . $input . '
    </form>';
        } else {
            $input = '<span>共' . $this->lastPage . '页</span>';
        }
        return $input;
    }

    /*
     * 分页-主体
     */
    public function pages()
    {
        $pages = '';
        if ($this->lastPage > 1) {
            if ($this->currentPage - $this->num1 > 1) {//不能看到第一页 显示第一页
                $pages .= '<span class="p1"><a href="' . $this->result->url(1) . '">第一页</a></span>';
            }

            if ($this->currentPage > 1) {//当前不是第一页 显示上一页
                $pages .= '<span class="p1"><a href="' . $this->result->url($this->currentPage - 1) . '">上一页</a></span>';
            }
            if ($this->currentPage > $this->lastPage - $this->num2) {
                for ($i = $this->currentPage - $this->num1 - ($this->currentPage - $this->lastPage + $this->num2); $i < $this->currentPage; $i++) {
                    if ($i > 0) {
                        $pages .= '<span class="p1"><a href="' . $this->result->url($i) . '">' . $i . '</a></span>';
                    }
                }
            } else {
                for ($i = $this->currentPage - $this->num1; $i < $this->currentPage; $i++) {
                    if ($i > 0) {
                        $pages .= '<span class="p1"><a href="' . $this->result->url($i) . '">' . $i . '</a></span>';
                    }
                }
            }
            $pages .= '<span class="p1 p_ok">' . $this->currentPage . '</span>';
            if ($this->currentPage < $this->num2 + 1) {
                for ($i = $this->currentPage + 1; $i < $this->num1 + $this->num2 + 2; $i++) {
                    if ($i <= $this->lastPage) {
                        $pages .= ' <span class="p1"><a href="' . $this->result->url($i) . '">' . $i . '</a></span>';
                    }
                }
            } else {
                for ($i = $this->currentPage + 1; $i < $this->currentPage + $this->num2 + 1; $i++) {
                    if ($i <= $this->lastPage) {
                        $pages .= '<span class="p1"><a href="' . $this->result->url($i) . '">' . $i . '</a></span>';
                    }
                }
            }
            if ($this->currentPage < $this->lastPage) {//当前不是最末页 显示下一页
                $pages .= '<span class="p1"><a href="' . $this->result->url($this->currentPage + 1) . '">下一页</a></span>';
            }
            if ($this->currentPage + $this->num2 < $this->lastPage) {//不能看到最末页 显示最末页
                $pages .= '<span class="p1"><a href="' . $this->result->url($this->lastPage) . '">最末页</a></span>';
            }
        }
        return $pages;
    }
}