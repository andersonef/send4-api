<?php namespace App\Classes;

use Illuminate\Database\Eloquent\Builder;
use App\Http\Requests\ListRequest;


class ListQueryBuilder 
{

    const MAXIMO_RESULTADOS_POR_REQUEST = 50;
    
    protected $query;
    protected $listRequest;
    protected $searchFields;

    public function usingQuery(Builder $query)
    {
        $this->query = $query;
        return $this;
    }

    public function readRequest(ListRequest $listRequest)
    {
        $this->listRequest = $listRequest;
        return $this;
    }

    public function searchFields(array $fields)
    {
        $this->searchFields = $fields;
        return $this;
    }


    public function process()
    {
        if ($this->listRequest->has('q')) {
            $stringBusca = '%' . $this->listRequest->get('q') . '%';
            $campos = $this->searchFields;
            $this->query->where(function($query) use ($stringBusca, $campos) {
                foreach($campos as $i => $campo) {
                    if ($i === 0) {
                        $query->where($campo, 'like', $stringBusca);
                        continue;
                    }
                    $query->orWhere($campo, 'like', $stringBusca);
                }
            });
        }
        if (!$this->listRequest->has('limit')) {
            $this->listRequest->merge(['limit' => self::MAXIMO_RESULTADOS_POR_REQUEST]);
        }
        if (!$this->listRequest->has('offset')) {
            $this->listRequest->merge(['offset' => 0]);
        }
        $this
            ->query
            ->limit($this->listRequest->get('limit'))
            ->offset($this->listRequest->get('offset'));
        return $this->query;
    }
}
