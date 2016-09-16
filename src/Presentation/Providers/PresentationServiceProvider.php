<?php
namespace Schweppesale\Module\Access\Presentation\Providers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\ServiceProvider;
use Schweppesale\Module\Core\Exceptions\EntityNotFoundException;
use Schweppesale\Module\Core\Exceptions\ModuleExceptionHandler;

class PresentationServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerExceptionHandlers();
    }

    /**
     * @return ModuleExceptionHandler
     */
    public function getExceptionHandler(): ModuleExceptionHandler
    {
        return $this->app->make(\Illuminate\Contracts\Debug\ExceptionHandler::class);
    }

    /**
     * @return void
     */
    public function registerExceptionHandlers()
    {
        $this->getExceptionHandler()->addModuleExceptionHandler(
            EntityNotFoundException::class,
            function(Request $request, EntityNotFoundException $exception, Response $response) {
               return $response->setStatusCode(404)->setContent(['error' => $exception->getMessage()]);
            }
        );
    }
}