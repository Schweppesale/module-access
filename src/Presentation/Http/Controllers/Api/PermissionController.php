<?php namespace Schweppesale\Module\Access\Presentation\Http\Controllers\Api;

use Illuminate\Http\Response;
use Schweppesale\Module\Access\Application\Services\Permissions\PermissionService;
use Schweppesale\Module\Core\Http\Controller;
use Schweppesale\Module\Core\Http\Laravel\Request;

/**
 * Class PermissionController
 *
 * @package App\Http\Controllers\Access
 */
class PermissionController extends Controller
{

    /**
     * @var PermissionService
     */
    private $permissionService;

    /**
     * @var Response
     */
    private $response;

    /**
     * PermissionController constructor.
     * @param Response $response
     * @param PermissionService $permissionService
     */
    public function __construct(Response $response, PermissionService $permissionService)
    {
        $this->response = $response;
        $this->permissionService = $permissionService;
    }

    /**
     * @return mixed
     */
    public function index()
    {
        return $this->response->setContent($this->permissionService->findAll());
    }

    public function show($id)
    {
        return $this->response->setContent($this->permissionService->getById($id));
    }

    public function store(Request $request)
    {
        return $this->response->setContent($this->permissionService->create(
            $request->get('name'),
            $request->get('label'),
            $request->get('groupId'),
            $request->get('sort'),
            explode(',', $request->get('dependencyIds')),
            (bool)$request->get('system')
        ));
    }

    public function update($id)
    {

    }
}
