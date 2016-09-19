<?php
namespace Schweppesale\Module\Access\Presentation\Services\Api;

use Illuminate\Http\Request as LaravelRequest;
use Illuminate\Http\Response as LaravelResponse;
use JMS\Serializer\SerializerInterface;

/**
 * Class Response
 * @package Schweppesale\Module\Access\Presentation\Services\Api
 */
class Response
{

    /**
     * @var LaravelRequest
     */
    private $request;
    /**
     * @var LaravelResponse
     */
    private $response;
    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * Response constructor.
     * @param SerializerInterface $serializer
     * @param LaravelRequest $request
     * @param LaravelResponse $response
     */
    public function __construct(SerializerInterface $serializer, LaravelRequest $request, LaravelResponse $response)
    {
        $this->serializer = $serializer;
        $this->response = $response;
        $this->request = $request;
    }

    /**
     * @param $payload
     * @return LaravelResponse
     */
    public function format($payload)
    {
        if ($this->request->accepts('application/json')) {
            $contentType = 'application/json';
            $format = 'json';
        } else {
            $contentType = 'application/xml';
            $format = 'xml';
        }

        return $this->response->header('Content-Type', $contentType)->setContent(
            $this->serializer->serialize($payload, $format)
        );
    }
}