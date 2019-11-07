<?php namespace App\Classes;


use Illuminate\Http\JsonResponse;

class ApiResponse extends JsonResponse
{
    public function __construct($data = null, $success = true, array $headers = [], $options = 0)
    {
        $newData = [
            'status'    => ($success) ? 'success' : 'error',
            'data'      => $data,
        ];
        if (!$success && is_string($data)) {
            $newData['message'] = $data;
            //$newData['stacktrace'] = $stackTrace;//
        }
        $statusCode = ($newData['status'] === 'success') ? 200 : 422;
        parent::__construct($newData, $statusCode, $headers, $options);
    }


    protected $success = true;

    public function error() {
        $this->success = false;

        return $this;
    }

    public function success() {
        $this->success = true;
        return $this;
    }


}