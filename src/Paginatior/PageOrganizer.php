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

    private static PageOrganizer $po;
    private Paginator $paginator;
    private int $pagination;
    private array $pieces;
    private int $current;
    private int $per;

    public static function paginate(Paginator $doctrinePaginator, int $pageNum, int $avg) {
        if (self::$po == null) {
            self::$po = new PageOrganizer();
            self::$po->paginator = $doctrinePaginator;
            self::$po->current = $pageNum - 1;
            self::$po->per = $avg;
            self::$po->setPagination();
            self::$po->setPieces();
        }
        return self::$po->setCurrentPage();
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
        return self::$po->pagination;
    }

    private function setPagination(): void {
        $max = self::$po->paginator->count();
        self::$po->pagination = $max / self::$po->per;
    }

    function getPieces(): array {
        return self::$po->pieces;
    }

    /**
     * 对查询结果进行分页。
     * 
     * @param Paginator $paginator
     * @param int $per
     * @return array 返回分页后的数组数据；
     */
    private function setPieces() {
        $all = iterator_to_array(self::$po->paginator);
        self::$po->pieces = array_chunk($all, self::$po->per);
    }

    /**
     * 返回一页（当前页）数据
     * 
     * @param int $current
     * @return array
     */
    private function setCurrentPage() {
        if ((self::$po->current >= 0) && (self::$po->current < (self::$po->pagination - 1))) {
            return self::$po->pieces[self::$po->current];
        } else {
            return self::$po->pieces[0];
        }
    }

    /**
     * 返回一页（当前页）数据
     * @param int $currentPage
     * @return array
     */
    public function getCurrentPage(int $currentPage) {
        if (($currentPage >= 1) < ($currentPage < self::$po->pagination)) {
            return self::$po->pieces[$currentPage];
        } else {
            return PageOrganizer::$po->pieces[0];
        }
    }

}
