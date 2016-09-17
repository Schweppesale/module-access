<?php namespace Schweppesale\Module\Access\Presentation\Http\Controllers\Api;

use Hateoas\HateoasBuilder;
use Illuminate\Http\Response;
use JMS\Serializer\SerializerInterface;
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
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * PermissionController constructor.
     * @param Response $response
     * @param SerializerInterface $serializer
     * @param PermissionService $permissionService
     */
    public function __construct(Response $response, SerializerInterface $serializer, PermissionService $permissionService)
    {
        $this->response = $response;
        $this->serializer = $serializer;
        $this->permissionService = $permissionService;
    }

    /**
     * @return mixed
     */
    public function index()
    {
        return $this->response->header('Content-Type', 'application/json')->setContent(
            $this->serializer->serialize($this->permissionService->findAll(), 'json')
        );
    }

    public function show($id)
    {
        return $this->response->header('Content-Type', 'application/json')->setContent(
            $this->serializer->serialize($this->permissionService->getById($id), 'json')
        );
    }

    public function dependencies($id)
    {
        return $this->response->header('Content-Type', 'application/json')->setContent(
            $this->serializer->serialize($this->permissionService->getById($id)->getDependencies(), 'json')
        );
    }

    public function store(Request $request)
    {
        $hateoas = HateoasBuilder::create()->build();
        return $this->response->header('Content-Type', 'application/json')->setContent(
            $this->serializer->serialize(
                $this->permissionService->create(
                    $request->get('name'),
                    $request->get('label'),
                    $request->get('groupId'),
                    $request->get('sort'),
                    explode(',', $request->get('dependencyIds')),
                    (bool)$request->get('system')
                ), 'json'
            )
        );
    }

    public function update($id)
    {

    }
}
