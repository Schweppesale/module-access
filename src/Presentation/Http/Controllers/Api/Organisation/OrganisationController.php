<?php
namespace Schweppesale\Module\Access\Presentation\Http\Controllers\Api\Organisation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Schweppesale\Module\Access\Application\Services\Organisations\OrganisationService;
use Schweppesale\Module\Access\Domain\Repositories\OrganisationRepository;

/**
 * Class OrganisationController
 *
 * @package Schweppesale\Module\Access\Presentation\Http\Controllers\Api\Access\Organisation
 */
class OrganisationController extends Controller
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('access::backend.companies.create');
    }

    /**
     * @param $organisationId
     * @param OrganisationRepository $organisations
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($organisationId, OrganisationRepository $organisations)
    {
        $organisation = $organisations->getById($organisationId);
        return view('access::backend.companies.edit', [
            'company' => $organisation
        ]);
    }

    /**
     * @param OrganisationRepository $organisations
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(OrganisationRepository $organisations)
    {
        return view('access::backend.companies.index', [
            'companies' => $organisations->fetchAll()
        ]);
    }

    /**
     * @param $organisationId
     * @param OrganisationRepository $organisations
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($organisationId, OrganisationRepository $organisations)
    {
        $organisation = $organisations->getById($organisationId);
        return view('access::backend.companies.show', [
            'company' => $organisation
        ]);
    }

    /**
     * @param Request $request
     * @param OrganisationService $organisationService
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request, OrganisationService $organisationService)
    {
        $organisationName = $request->get('name');
        $description = $request->get('description');
        $organisation = $organisationService->create($organisationName, $description);
        return redirect(route('admin.access.companies.show', ['companyId' => $organisation->getId()]))
            ->withFlashSuccess('Company Created Successfully!');
    }

    /**
     * @param $organisationId
     * @param Request $request
     * @param OrganisationService $organisationService
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($organisationId, Request $request, OrganisationService $organisationService)
    {
        $organisationName = $request->get('name');
        $description = $request->get('description');
        $organisation = $organisationService->update($organisationId, $organisationName, $description);
        return redirect(route('admin.access.companies.show', ['companyId' => $organisation->getId()]))
            ->withFlashSuccess('Company Updated Successfully!');
    }
}
