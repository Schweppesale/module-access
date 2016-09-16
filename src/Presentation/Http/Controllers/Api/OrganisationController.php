<?php
namespace Schweppesale\Module\Access\Presentation\Http\Controllers\Api;

use Schweppesale\Module\Core\Http\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Schweppesale\Module\Access\Application\Services\Organisations\OrganisationService;

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
     * OrganisationController constructor.
     * @param Response $response
     * @param OrganisationService $organisationService
     */
    public function __construct(Response $response, OrganisationService $organisationService)
    {
        $this->response = $response;
        $this->organisationService = $organisationService;
    }

    /**
     * @return mixed
     */
    public function index()
    {
        return $this->response->setContent($this->organisationService->findAll());
    }

    /**
     * @param $organisationId
     * @return mixed
     */
    public function show($organisationId)
    {
        return $this->response->setContent($this->organisationService->getById($organisationId));
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $organisationName = $request->get('name');
        $description = $request->get('description');
        return $this->response->setContent($this->organisationService->create($organisationName, $description));
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
        return $this->response->setContent($this->organisationService->update($organisationId, $organisationName, $description));
    }
}
