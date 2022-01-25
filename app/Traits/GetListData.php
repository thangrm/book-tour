<?php

namespace App\Traits;

/**
 * Trait get list for model
 *
 */
trait GetListData
{
    /**
     * Get list latest
     *
     * @return mixed
     */
    public function getLatest()
    {
        return $this->latest()->get();
    }

    /**
     * Get list active
     *
     * @return mixed
     */
    public function getByStatus(int $status = 1, int $limit = 0)
    {
        $query = $this->where('status', $status)->latest();
        if ($limit != 0) {
            $query->limit($limit);
        }

        return $query->get();
    }

    /**
     * Get list order by title
     *
     * @return mixed
     */
    public function getOrderByTitle($sort = 'asc')
    {
        return $this->orderBy('name', $sort)->get();
    }
}
