<?php namespace Schweppesale\Module\Access\Presentation\Http\Controllers\Api;

use Illuminate\Http\Request;
use Schweppesale\Module\Access\Application\Services\Permissions\PermissionService;
use Schweppesale\Module\Access\Presentation\Services\Api\Response;
use Schweppesale\Module\Core\Http\Controller;

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
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $expand = explode(',', $request->get('expand', 'dependencyIds'));
        return $this->response->format($this->permissionService->findAll(['expand' => $expand]));
    }

    /**
     * @param Request $request
     * @param $groupId
     * @return \Illuminate\Http\Response
     */
    public function indexByGroup(Request $request, $groupId)
    {
        $expand = explode(',', $request->get('expand', 'dependencyIds'));
        return $this->response->format($this->permissionService->findByGroupId($groupId, ['expand' => $expand]));
    }

    /**
     * @param Request $request
     * @param $roleId
     * @return \Illuminate\Http\Response
     */
    public function indexByRole(Request $request, $roleId)
    {
        $expand = explode(',', $request->get('expand', 'dependencyIds'));
        return $this->response->format($this->permissionService->findByRoleId($roleId, ['expand' => $expand]));
    }

    /**
     * @param Request $request
     * @param $userId
     * @return \Illuminate\Http\Response
     */
    public function indexByUser(Request $request, $userId)
    {
        $expand = explode(',', $request->get('expand', 'dependencyIds'));
        return $this->response->format($this->permissionService->findByUserId($userId, ['expand' => $expand]));
    }

    /**
     * @param $permissionId
     * @return \Illuminate\Http\Response
     */
    public function indexDependencies($permissionId)
    {
        return $this->response->format($this->permissionService->findDependenciesById($permissionId));
    }

    /**
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->response->format($this->permissionService->getById($id));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $this->response->format(
            $this->permissionService->create(
                $request->get('name'),
                $request->get('label'),
                $request->get('groupId'),
                $request->get('sort'),
                explode(',', $request->get('dependencyIds')),
                (bool)$request->get('system')
            )
        );
    }

    public function update($id)
    {

    }
}
