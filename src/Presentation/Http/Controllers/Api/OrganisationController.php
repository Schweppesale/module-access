<?php
namespace Schweppesale\Module\Access\Presentation\Http\Controllers\Api;

use Hateoas\HateoasBuilder;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use JMS\Serializer\SerializerInterface;
use Schweppesale\Module\Access\Application\Services\Organisations\OrganisationService;
use Schweppesale\Module\Core\Http\Controller;

/**
 * Class OrganisationController
 *
 * @package Schweppesale\Module\Access\Presentation\Http\Controllers\Api\Access\Organisation
 */
class OrganisationController extends Controller
{

    /**
     * @var OrganisationService
     */
    private $organisationService;

    /**
     * @var Response
     */
    private $response;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * OrganisationController constructor.
     * @param Response $response
     * @param SerializerInterface $serializer
     * @param OrganisationService $organisationService
     */
    public function __construct(Response $response, SerializerInterface $serializer, OrganisationService $organisationService)
    {
        $this->response = $response;
        $this->serializer = $serializer;
        $this->organisationService = $organisationService;
    }

    /**
     * @return mixed
     */
    public function index()
    {
        return $this->response->header('Content-Type', 'application/json')->setContent(
            $this->serializer->serialize($this->organisationService->findAll(), 'json')
        );
    }

    /**
     * @param $organisationId
     * @return mixed
     */
    public function show($organisationId)
    {
        return $this->response->header('Content-Type', 'application/json')->setContent(
            $this->serializer->serialize($this->organisationService->getById($organisationId), 'json')
        );
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $organisationName = $request->get('name');
        $description = $request->get('description');
        $hateoas = HateoasBuilder::create()->build();
        return $this->response->header('Content-Type', 'application/json')->setContent(
            $hateoas->serialize($this->organisationService->create($organisationName, $description), 'json')
        );
    }

    /**
     * @param $organisationId
     * @param Request $request
     * @param OrganisationService $organisationService
     * @return mixed
     */
    public function update($organisationId, Request $request)
    {
        $organisationName = $request->get('name');
        $description = $request->get('description');
        return $this->response->header('Content-Type', 'application/json')->setContent(
            $this->serializer->serialize(
                $this->organisationService->update(
                    $organisationId,
                    $organisationName,
                    $description
                ), 'json'
            )
        );
    }
}
