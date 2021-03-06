<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace SfUtils\Paginatior;

use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\ORM\Query;

/**
 * Description of PageOrganizer
 *
 * @author passpos <passpos@outlook.com>
 */
class PageOrganizer {

    private static $po = null;
    private $query = null;
    private $paginator = null;
    private $pagination = 0;
    private $pieces = [];
    private $current = 0;
    private $per = 10;

    /**
     * 
     * @param Query $query
     * @param int $pageNum
     * @param int $avg
     * @param bool $fetchJoinCollection
     * @return PageOrganizer
     */
    public static function getPageOrganizer(Query $query, int $pageNum, int $avg, bool $fetchJoinCollection): PageOrganizer {
        if (self::$po == null) {
            self::$po = new PageOrganizer();
            self::$po->query = $query;
            self::$po->paginator = new Paginator($query, $fetchJoinCollection);
            self::$po->current = $pageNum;
            self::$po->per = $avg;
            self::$po->setPagination();
            self::$po->setPieces();
        }
        return self::$po;
    }

    /**
     * 返回一页（当前页）数据
     * @return array
     */
    public function paginate() {
        if ($this->pieces == null) {
            return;
        }
        // 正常情况下，得到的current总是在 1 - $pagination 之间；
        if (($this->current >= 1) && ($this->current <= ($this->pagination))) {
            return $this->pieces[$this->current - 1];
        } else {
            return $this->pieces[0];
        }
    }

    /**
     * 返回总页数
     * return num of pages.
     * 
     * @param Paginator $paginator
     * @param int $avg
     * @return int 
     */
    public function getPagination(): int {
        return $this->pagination;
    }

    /**
     * 计算页数并返回。
     * 在包含数据的情况下，返回值总是大于等于1的整数；
     * @return void
     */
    private function setPagination(): void {
        $max = $this->paginator->count();
        $this->pagination = ceil($max / $this->per);
    }

    public function getPieces(): array {
        return $this->pieces;
    }

    /**
     * 对查询结果进行分页，并返回分页后的数组数据。
     * 注意：这个结果数组的索引是从0开始的；
     * 
     * @param Paginator $paginator
     * @param int $per
     * @return array 返回分页后的数组数据；
     */
    private function setPieces() {
        $all = iterator_to_array($this->paginator);
        $this->pieces = array_chunk($all, $this->per);
    }

}
