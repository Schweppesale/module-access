<?php namespace Schweppesale\Module\Access\Presentation\Http\Controllers\Api;

use Illuminate\Http\Request;
use Schweppesale\Module\Access\Application\Services\Permissions\GroupService;
use Schweppesale\Module\Access\Presentation\Http\Requests\Api\Group\DeleteGroupRequest;
use Schweppesale\Module\Access\Presentation\Http\Requests\Api\Group\StoreGroupRequest;
use Schweppesale\Module\Access\Presentation\Http\Requests\Api\Group\UpdateGroupRequest;
use Schweppesale\Module\Access\Presentation\Services\Api\Response;
use Schweppesale\Module\Core\Http\Controller;

/**
 * Class GroupController
 * @package Schweppesale\Module\Access\Presentation\Http\Controllers\Api
 */
class GroupController extends Controller
{

    /**
     * @var GroupService
     */
    private $groupService;

    /**
     * @var Response
     */
    private $response;

    /**
     * GroupController constructor.
     * @param Response $response
     * @param GroupService $groupService
     */
    public function __construct(Response $response, GroupService $groupService)
    {
        $this->response = $response;
        $this->groupService = $groupService;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $expand = explode(',', $request->get('expand', 'permissionIds'));
        return $this->response->format($this->groupService->findAll(['expand' => $expand]));
    }

    /**
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->response->format($this->groupService->getById($id));
    }

    /**
     * @param $id
     * @param DeleteGroupRequest $request
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, DeleteGroupRequest $request)
    {
        return $this->response->format($this->groupService->delete($id));
    }

    /**
     * @param StoreGroupRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGroupRequest $request)
    {
        return $this->response->format($this->groupService->create($request->get('name')));
    }

    /**
     * @param $id
     * @param UpdateGroupRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update($id, UpdateGroupRequest $request)
    {
        return $this->response->format($this->groupService->update($id, $request->get('name')));
    }
}
