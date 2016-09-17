<?php namespace Schweppesale\Module\Access\Presentation\Http\Controllers\Api;

use Hateoas\HateoasBuilder;
use Illuminate\Http\Response;
use JMS\Serializer\SerializerInterface;
use Schweppesale\Module\Access\Application\Services\Permissions\PermissionGroupService;
use Schweppesale\Module\Access\Presentation\Http\Requests\Backend\Permission\Group\DeletePermissionGroupRequest;
use Schweppesale\Module\Access\Presentation\Http\Requests\Backend\Permission\Group\StorePermissionGroupRequest;
use Schweppesale\Module\Access\Presentation\Http\Requests\Backend\Permission\Group\UpdatePermissionGroupRequest;
use Schweppesale\Module\Core\Http\Controller;

/**
 * Class PermissionGroupController
 * @package Schweppesale\Module\Access\Presentation\Http\Controllers\Api
 */
class PermissionGroupController extends Controller
{

    /**
     * @var PermissionGroupService
     */
    private $permissionGroupService;

    /**
     * @var Response
     */
    private $response;

    /**
     * @var SerializerInterface
     */
    private $serlalizer;

    /**
     * PermissionGroupController constructor.
     * @param Response $response
     * @param SerializerInterface $serializer
     * @param PermissionGroupService $permissionGroupService
     */
    public function __construct(Response $response, SerializerInterface $serializer, PermissionGroupService $permissionGroupService)
    {
        $this->response = $response;
        $this->serlalizer = $serializer;
        $this->permissionGroupService = $permissionGroupService;
    }

    public function index()
    {
        return $this->response->header('Content-Type', 'application/json')->setContent(
            $this->serlalizer->serialize($this->permissionGroupService->findAll(), 'json')
        );
    }

    public function show($id)
    {
        return $this->response->header('Content-Type', 'application/json')->setContent(
            $this->serlalizer->serialize($this->permissionGroupService->getById($id), 'json')
        );
    }

    /**
     * @param $id
     * @param DeletePermissionGroupRequest $request
     * @return mixed
     */
    public function destroy($id, DeletePermissionGroupRequest $request)
    {
        return $this->response->header('Content-Type', 'application/json')->setContent(
            $this->serlalizer->serialize($this->permissionGroupService->delete($id), 'json')
        );
    }

    /**
     * @param StorePermissionGroupRequest $request
     * @return mixed
     */
    public function store(StorePermissionGroupRequest $request)
    {
        return $this->response->header('Content-Type', 'application/json')->setContent(
            $this->serlalizer->serialize(
                $this->permissionGroupService->create($request->get('name'))
                , 'json'
            )
        );
    }

    /**
     * @param $id
     * @param UpdatePermissionGroupRequest $request
     * @return mixed
     */
    public function update($id, UpdatePermissionGroupRequest $request)
    {
        return $this->response->header('Content-Type', 'application/json')->setContent(
            $this->serlalizer->serialize($this->permissionGroupService->update($id, $request->get('name')), 'json')
        );
    }
}
