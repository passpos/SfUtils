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

    private static Paginator $paginator;
    private static int $pagination;
    private static array $pieces;
    private static int $current;
    private static int $per;

    public function paginate(Paginator $doctrinePaginator, int $pageNum, int $avg) {
        if (self::$paginator == null) {
            self::$paginator = $doctrinePaginator;
            self::$current = $pageNum - 1;
            self::$per = $avg;
            self::setPagination();
            self::setPieces();
        }
        return self::setCurrentPage();
    }

    /**
     * 返回总页数
     * return num of pages.
     * 
     * @param Paginator $paginator
     * @param int $avg
     * @return int 
     */
    public static function getPagination() {
        return self::$pagination;
    }

    private static function setPagination(): void {
        $max = self::$paginator->count();
        self::$pagination = $max / self::$per;
    }

    static function getPieces(): array {
        return self::$pieces;
    }

    /**
     * 对查询结果进行分页。
     * 
     * @param Paginator $paginator
     * @param int $per
     * @return array 返回分页后的数组数据；
     */
    private static function setPieces() {
        $all = iterator_to_array(self::$paginator);
        self::$pieces = array_chunk($all, self::$per);
    }

    /**
     * 返回一页（当前页）数据
     * 
     * @param int $current
     * @return array
     */
    private static function setCurrentPage() {
        if ((self::current >= 0) && (self::$current < (self::$pagination - 1))) {
            return self::$pieces[$current];
        } else {
            return self::$pieces[0];
        }
    }

    /**
     * 返回一页（当前页）数据
     * @param int $currentPage
     * @return array
     */
    public static function getCurrentPage(int $currentPage) {
        if (($currentPage >= 1) < ($currentPage < self::$pagination)) {
            return self::$pieces[$currentPage];
        } else {
            return self::$pieces[0];
        }
    }

}
