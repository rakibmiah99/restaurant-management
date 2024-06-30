<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Container\Container;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

class Helper
{


    public int $perpage = 1;
    /**
     * Create a new class instance.
     */
    public function __construct()
    {

    }

    static public function ConvertTo12HourFormat($time24) {
        return  date('h:i A', strtotime($time24));
    }

    public static function Paginate(Collection $results, $showPerPage)
    {
        $pageNumber = Paginator::resolveCurrentPage('page');

        $totalPageNumber = $results->count();

        return self::paginator($results->forPage($pageNumber, $showPerPage), $totalPageNumber, $showPerPage, $pageNumber, [
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => 'page',
        ]);

    }

    /**
     * Create a new length-aware paginator instance.
     *
     * @param \Illuminate\Support\Collection $items
     * @param int $total
     * @param int $perPage
     * @param int $currentPage
     * @param array $options
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    protected static function Paginator($items, $total, $perPage, $currentPage, $options)
    {
        return Container::getInstance()->makeWith(LengthAwarePaginator::class, compact(
            'items', 'total', 'perPage', 'currentPage', 'options'
        ));
    }


    /**
     * Calculates the growth percentage between two values.
     *
     * If $old_value is not zero, computes the percentage growth from $old_value to $new_value.
     * If $old_value is zero, returns $new_value.
     *
     * @param float $new_value The new value (current value).
     * @param float $old_value The old value (previous value).
     * @return float|int The growth percentage if $old_value is not zero, otherwise returns $new_value.
     */

    public static function GetGrowth($new_value, $old_value)
    {
        /** law of two year percentage change
         *
         *
         *      new value - old value
         *    ------------------------ *  100
         *          old value
         *
         *
         */

        return $old_value ? (($new_value - $old_value) / $old_value ) * 100 : $new_value;
    }


    public static function GenerateFileName($name, $extension): string
    {
        return $name."_".Carbon::now()->format('Y_m_d_H_i').".".$extension;
    }

    public static function PerPage()
    {
        return request()->perpage ?? config('page.per_page_view');
    }

    public static function PageIndex()
    {
        $page_number = request()->page ?? 1;
        $index = ($page_number - 1)  *  self::PerPage();
        return $index+1;
    }


    public static function CreatedSuccessFully($name = null): string
    {
        return $name." ".__('page.created_successfully');
    }
    public static function UpdatedSuccessFully($name = null): string
    {
        return $name." ".__('page.updated_successfully');
    }

    public static function DeletedSuccessFully($name = null): string
    {
        return $name." ".__('page.deleted_successfully');
    }

    public static function StatusChangedSuccessFully($name = null): string
    {
        return $name." ".__('page.status_change_successfully');
    }

}
