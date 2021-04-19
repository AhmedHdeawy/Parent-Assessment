<?php
namespace App\Repositories\V1;

use App\SearchProviders\AbstractProviderFactory;
use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator;
use App\SearchProviders\SearchProvider;
use Illuminate\Pagination\LengthAwarePaginator;
use App\SearchProviders\ProviderX\ProviderXFactory;
use App\SearchProviders\ProviderY\ProviderYFactory;

class UserRepository
{
    /**
     * Search for hotels in many providers
     *
     * @return \Illuminate\Http\Response;
     */
    public function list($request)
    {
        // I Used Abstarct Factory Pattern to Allow us to add another Provider

        // Instaniate Pattern
        $provider = new SearchProvider();
        
        if (isset($request['provider']) && !empty($request['provider'])) {
            // Get Data from One Provider
            $data = $this->handleOneProvider($provider, $request['provider'], $request);
            
        } else {

            $data = $this->handleAllProvider($provider, $request);
            
        }

        return $this->paginate($data);
    }

    /**
     * @param mixed $provider
     * @param string $providerName
     * @param array $request
     * 
     * @return [type]
     */
    private function handleOneProvider($provider, $providerName, $request)
    {
        if (($providerName == 'DataProviderX')) {
            $provider->setFactory(new ProviderXFactory($request));
            return $provider->listUsers();

        } elseif ($providerName == 'DataProviderY') {

            // Call Provider Y
            $provider->setFactory(new ProviderYFactory(($request)));
            return $provider->listUsers();
        }

        return null;
    }
    
    
    /**
     * @param mixed $provider
     * @param string $providerName
     * @param array $request
     * 
     * @return [type]
     */
    private function handleAllProvider($provider, $request)
    {
        // Call Provider X
        $provider->setFactory(new ProviderXFactory($request));
        $providerX = $provider->listUsers();

        // Call Provider Y
        $provider->setFactory(new ProviderYFactory(($request)));
        $providerY = $provider->listUsers();

        // Finally merge data from all providers
        return $this->mergeResults($providerX, $providerY);
    }

    /**
     * @param mixed $results
     * 
     * @return Collection $response
     */
    private function mergeResults(...$results)
    {
        $response = collect();
        foreach ($results as $result) {
            $response = $response->merge($result);
        }
        
        return $response;
    }

    /**
     * @param mixed $items
     * @param int $perPage
     * @param null $page
     * @param array $options
     * 
     * @return LengthAwarePaginator
     */
    private function paginate($items, $perPage = 10, $page = null, $options = [])
    {
        $options['path'] = config('app.url');
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);

        $items = $items instanceof Collection ? $items : Collection::make($items);

        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

}