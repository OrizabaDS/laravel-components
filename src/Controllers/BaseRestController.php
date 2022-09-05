<?php

namespace Orizaba\LaravelComponents\Controllers;


use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Orizaba\LaravelComponents\Support\Enums\HttpResponseCodesEnum;


abstract class BaseRestController extends Controller
{
    protected                            $headers = [];
    protected HttpResponseCodesEnum|null $status  = null;



    public function __construct()
    {
        // TODO: Implement support for Validations

        $this->headers = [];
    }


    /**
     * @return int|null
     */
    protected function getStatus()
    {
        return $this?->status?->value ?? null;
    }


    /**
     * @param HttpResponseCodesEnum $status
     *
     * @return $this
     */
    protected function setStatus(HttpResponseCodesEnum $status)
    {
        $this->status = $status;

        return $this;
    }


    /**
     * @param $message
     * @param mixed $data
     *
     * @return JsonResponse
     */
    private function respond($message, mixed $data = []): JsonResponse
    {
        // TODO: Implement support for <Access Logging>
        // TODO: Implement support for <Pagination>

        $payload = [
            'message' => $message,
            'data'    => $data
        ];

        return response()->json($payload, $this->getStatus(), $this->headers);
    }


    /**
     * @param $message
     * @param mixed $data
     *
     * @return JsonResponse
     */
    public function respondSuccess($message, mixed $data = [])
    {
        return $this->setStatus(HttpResponseCodesEnum::OK)->respond($message, $data);
    }


    public function respondAccepted($message, $data = [])
    {
        return $this->setStatus(HttpResponseCodesEnum::ACCEPTED)->respond($message, $data);
    }


    public function respondNoData($message = 'No record(s) found!', $data = [])
    {
        return $this->setStatus(HttpResponseCodesEnum::NO_CONTENT)->respond($message, $data ?? []);
    }


    public function respondBadRequest($message = 'Invalid request!')
    {
        // TODO: Implement support for Validations

        return $this->setStatus(HttpResponseCodesEnum::BAD_REQUEST)->respond($message);
    }


    public function respondNotFound($message = 'Resource not found!', $data = [])
    {
        return $this->setStatus(HttpResponseCodesEnum::NOT_FOUND)->respond($message, $data);
    }


    public function respondMethodNotAllowed()
    {
        return $this->setStatus(HttpResponseCodesEnum::METHOD_NOT_ALLOWED)->respond('Method not allowed!');
    }


    public function respondConflict($message = 'Payload invalid!', $data = [])
    {
        // TODO: Implement support for Validations

        return $this->setStatus(HttpResponseCodesEnum::CONFLICT)->respond($message, $data);
    }


    public function respondServerError($message = 'Your request could not be executed!')
    {
        return $this->setStatus(HttpResponseCodesEnum::INTERNAL_SERVER_ERROR)->respond($message);
    }


    /**
     * If <filePath> exists, open a File Stream.
     * Return 404 otherwise.
     *
     * @param $filePath
     *
     * @return JsonResponse|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function streamFile($filePath)
    {

        return $this->respondNotFound("File {$filePath} not found!");
    }
}