<?php
namespace Schweppesale\Access\Presentation\Http\Controllers\Backend\Organisation\Logo;

use Schweppesale\Access\Application\Services\Companies\Companies as CompanyService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * Class CompanyLogoController
 *
 * @package Schweppesale\Access\Presentation\Http\Controllers\Backend\Access\Organisation
 */
class CompanyLogoController extends Controller
{

    /**
     * @param $organisationid
     */
    public function store($organisationid, Request $request, CompanyService $organisationService)
    {
        $logo = $request->file('file');
        return json_encode($organisationService->attachLogo($organisationid, $logo));
    }
}
