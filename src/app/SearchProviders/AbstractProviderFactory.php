<?php
namespace App\SearchProviders;

use Illuminate\Support\Collection;

interface AbstractProviderFactory
{
    /**
     * Call Provider API
     *
     * @return void $response
     */
    public function loadFile();

    /**
     * Listing Process
     *
     * @return void
     */
    public function list() : void;

    /**
     * Handle Status Code
     * 
     * @param string $status
     * 
     * @return int
     */
    public function handleStatusCode(string $status);

    /**
     * Apply filters
     * 
     * @param Collection $collection
     * @param array $request
     * 
     * @return Collection
     */
    public function applyFilters(Collection $collection, array $request) : Collection;

    /**
     * format Response
     *
     * @return array $result
     */
    public function formateResult();
}
