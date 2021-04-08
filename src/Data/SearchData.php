<?php


namespace App\Data;


use App\Entity\Categorie;

class SearchData
{

    /**
     * @var int
     */

    public $page = 1;
    /**
     * @var string
     */
    public $keyword = '';

    /**
     * @var Categorie[]
     */
    public $categories = [];

    /**
     * @var null|integer
     */
    public $max_price;

    /**
     * @var null|integer
     */
    public $min_price;

}