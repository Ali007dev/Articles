<?php

namespace App\Services;

class FilterService
{
    /**
     * Create a new class instance.
     */


    public function filterDate($result, $date, $fieldName)
    {
        if ($date) {
            $year = substr($date, 0, 4);
            $month = substr($date, 5, 2);
            $day = substr($date, 8, 2);

            if ($day) {
                $result->whereDate($fieldName, $date);
            } elseif ($month) {
                $result->whereYear($fieldName, $year)
                    ->whereMonth($fieldName, $month);
            } else {
                $result->whereYear($fieldName, $year);
            }
        }

        return $result;
    }


    public function filterBySubCategory($query, $subCategoryId)
    {
        return $query->where('sub_category_id', $subCategoryId);
    }

    public function filterBySource($query, $sourceId)
    {
        return $query->where('source_id', $sourceId);
    }

    public function filterByAuthor($query, $authorId)
    {
        return $query->where('author_id', $authorId);
    }
}
