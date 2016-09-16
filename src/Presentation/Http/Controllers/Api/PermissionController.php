<?php namespace Schweppesale\Module\Access\Presentation\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Schweppesale\Module\Access\Application\Services\Permissions\PermissionService;

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
}
