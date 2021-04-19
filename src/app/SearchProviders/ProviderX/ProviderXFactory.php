<?php
namespace App\SearchProviders\ProviderX;

use App\SearchProviders\AbstractProviderFactory;
use Illuminate\Support\Collection;

class ProviderXFactory implements AbstractProviderFactory
{
    private array $request;
    private array $data;
    private string $fileName = 'DataProviderX.json';
    private Collection $result;

    public function __construct(array $request)
    {
        $this->request = $request;
    }

	/**
	 * Get Data from File 
	 *
	 *
	 * @return void
	 */
	public function loadFile() {

        $this->data = json_decode(file_get_contents(app_path() . '/Data/' . $this->fileName), true);
    }

    /**
     * Listing Process
     *
     * @return array
     */
    public function list(): void
    {
        $data = collect($this->data);
        
        $this->result = $this->applyFilters($data, $this->request);
    }
    
    
    /**
     * Apply Filters on Data
     *
     * @return array
     */
    public function applyFilters(Collection $collection, array $request): Collection
    {
        $data = $collection;
        
        if (isset($request['statusCode']) && !empty($request['statusCode'])) {
            
            $data = $data->where('statusCode', $this->handleStatusCode($request['statusCode']));
        }

        if (isset($request['currency']) && !empty($request['currency'])) {
            $data = $data->where('Currency', $request['currency']);
        }

        if (isset($request['balanceMin']) && !empty($request['balanceMin'])) {
            $data = $data->where('parentAmount', '>=', $request['balanceMin']);
        }
        
        if (isset($request['balanceMax']) && !empty($request['balanceMax'])) {
            $data = $data->where('parentAmount', '<=', $request['balanceMax']);
        }

        return $data;
        
    }
    

    /**
     * @param string $status
     * 
     * @return int
     */
    public function handleStatusCode(string $status)
    {
        if ($status == 'authorised') {
            return 1;
        } elseif ($status == 'decline') {
            return 2;
        } else {
            return 3;
        }
    }

    /**
     * Get Response after Format
     *
     * @return mixed $jsonData
     */
    public function formateResult()
    {
        $result = collect();
        // loop through result and reformat it
        $this->result->map(function($item) use ($result){
            $itemData = [
                "amount" => $item['parentAmount'],
                "currency" => $item['Currency'],
                "email" => $item['parentEmail'],
                "status_code" => $item['statusCode'],
                "date" => $item['registerationDate'],
                "id" => $item['parentIdentification'],
            ];
            $result->push($itemData);
        });

        return $result;
    }
}
