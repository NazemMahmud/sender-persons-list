<?php

namespace App\Traits;

trait DataTableTrait
{
    /** Per page how many data */
    public int $pageOffset = 20;

    /** Current page while pagination */
    public int $currentPage = 1;

    /** Total data exist according to the query */
    public int $total = 0;

    /**
     * Set Paginate info & return paginated data from collection
     *
     * @param mixed $data
     * @param array $params
     * @return mixed
     */
    public function paginate(mixed $data, array $params): mixed
    {
        $result = $this->getPaginationInfo($data,  count($data), $params);

        $this->total = $result['total'];
        $this->pageOffset = (int)$result['pageOffset'];
        $this->currentPage = (int)$result['page'];

        return $result['data'];
    }

    /**
     * Return paginated data wih pagination info
     *
     * @param mixed $data
     * @param int $total
     * @param array $params
     * @return array
     */
    public function getPaginationInfo(mixed $data, int $total, array $params): array
    {
        $offset = $params['pageOffset'] ?? 20;
        $pageNumber = $params['page'] ?? 1;
        $startIndex = ($pageNumber - 1) * $offset;

        return [
            'data' => array_slice($data, $startIndex, $offset),
            'pageOffset' => $offset,
            'page' => $pageNumber,
            'total' => $total
        ];
    }

    /**
     * Format paginated data with the pagination info
     *
     * @param mixed $data
     * @return array
     */
    public function formatPaginationInfo(mixed $data): array
    {
        return [
            'data' => $data,
            'per_page' => $this->pageOffset,
            'current_page' => $this->currentPage,
            'total' => $this->total,
            'status' => 'success',
        ];
    }

}
