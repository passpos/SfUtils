<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace SfUtils\Paginatior;

use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * Description of PageOrganizer
 *
 * @author passpos <paiap@outlook.com>
 */
class PageOrganizer {

    private Paginator $paginator;
    private int $pagination;
    private array $pieces;
    private int $current;
    private int $per;

    public function paginate(Paginator $doctrinePaginator, int $pageNum, int $avg) {
        if ($this->paginator == null) {
            $this->paginator = $doctrinePaginator;
            $this->current = $pageNum - 1;
            $this->per = $avg;
            $this->setPagination();
            $this->setPieces();
        }
        return $this->setCurrentPage();
    }

    /**
     * 返回总页数
     * return num of pages.
     * 
     * @param Paginator $paginator
     * @param int $avg
     * @return int 
     */
    public function getPagination() {
        return $this->pagination;
    }

    private function setPagination(): void {
        $max = $this->paginator->count();
        $this->pagination = $max / $this->per;
    }

    function getPieces(): array {
        return $this->pieces;
    }

    /**
     * 对查询结果进行分页。
     * 
     * @param Paginator $paginator
     * @param int $per
     * @return array 返回分页后的数组数据；
     */
    private function setPieces() {
        $all = iterator_to_array($this->paginator);
        $this->pieces = array_chunk($all, $this->per);
    }

    /**
     * 返回一页（当前页）数据
     * 
     * @param int $current
     * @return array
     */
    private function setCurrentPage() {
        if (($this->current >= 0) && ($this->current < ($this->pagination - 1))) {
            return $this->pieces[$this->current];
        } else {
            return $this->pieces[0];
        }
    }

    /**
     * 返回一页（当前页）数据
     * @param int $currentPage
     * @return array
     */
    public function getCurrentPage(int $currentPage) {
        if (($currentPage >= 1) < ($currentPage < $this->pagination)) {
            return $this->pieces[$currentPage];
        } else {
            return $this->pieces[0];
        }
    }

}
