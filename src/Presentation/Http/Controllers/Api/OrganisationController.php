<?php
namespace Schweppesale\Module\Access\Presentation\Http\Controllers\Api;

use Illuminate\Http\Request;
use Schweppesale\Module\Access\Application\Services\Organisations\OrganisationService;
use Schweppesale\Module\Access\Presentation\Services\Api\Response;
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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->response->format($this->organisationService->findAll());
    }

    /**
     * @param $organisationId
     * @return \Illuminate\Http\Response
     */
    public function show($organisationId)
    {
        return $this->response->format($this->organisationService->getById($organisationId));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $organisationName = $request->get('name');
        $description = $request->get('description');
        return $this->response->format($this->organisationService->create($organisationName, $description));
    }

    /**
     * @param $organisationId
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function update($organisationId, Request $request)
    {
        $organisationName = $request->get('name');
        $description = $request->get('description');
        return $this->response->format(
            $this->organisationService->update(
                $organisationId,
                $organisationName,
                $description
            )
        );
    }
}
