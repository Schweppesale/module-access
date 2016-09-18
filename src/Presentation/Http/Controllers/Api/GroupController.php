<?php namespace Schweppesale\Module\Access\Presentation\Http\Controllers\Api;

use Hateoas\HateoasBuilder;
use Illuminate\Http\Response;
use JMS\Serializer\SerializerInterface;
use Schweppesale\Module\Access\Application\Services\Permissions\GroupService;
use Schweppesale\Module\Access\Presentation\Http\Requests\Backend\Permission\Group\DeleteGroupRequest;
use Schweppesale\Module\Access\Presentation\Http\Requests\Backend\Permission\Group\StoreGroupRequest;
use Schweppesale\Module\Access\Presentation\Http\Requests\Backend\Permission\Group\UpdateGroupRequest;
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
     * @var SerializerInterface
     */
    private $serlalizer;

    /**
     * GroupController constructor.
     * @param Response $response
     * @param SerializerInterface $serializer
     * @param GroupService $groupService
     */
    public function __construct(Response $response, SerializerInterface $serializer, GroupService $groupService)
    {
        $this->response = $response;
        $this->serlalizer = $serializer;
        $this->groupService = $groupService;
    }

    public function index()
    {
        return $this->response->header('Content-Type', 'application/json')->setContent(
            $this->serlalizer->serialize($this->groupService->findAll(), 'json')
        );
    }

    public function show($id)
    {
        return $this->response->header('Content-Type', 'application/json')->setContent(
            $this->serlalizer->serialize($this->groupService->getById($id), 'json')
        );
    }

    /**
     * @param $id
     * @param DeleteGroupRequest $request
     * @return mixed
     */
    public function destroy($id, DeleteGroupRequest $request)
    {
        return $this->response->header('Content-Type', 'application/json')->setContent(
            $this->serlalizer->serialize($this->groupService->delete($id), 'json')
        );
    }

    /**
     * @param StoreGroupRequest $request
     * @return mixed
     */
    public function store(StoreGroupRequest $request)
    {
        return $this->response->header('Content-Type', 'application/json')->setContent(
            $this->serlalizer->serialize(
                $this->groupService->create($request->get('name'))
                , 'json'
            )
        );
    }

    /**
     * @param $id
     * @param UpdateGroupRequest $request
     * @return mixed
     */
    public function update($id, UpdateGroupRequest $request)
    {
        return $this->response->header('Content-Type', 'application/json')->setContent(
            $this->serlalizer->serialize($this->groupService->update($id, $request->get('name')), 'json')
        );
    }
}
