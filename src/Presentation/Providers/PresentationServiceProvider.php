<?php
namespace Schweppesale\Module\Access\Presentation\Providers;

use Hateoas\HateoasBuilder;
use Hateoas\UrlGenerator\CallableUrlGenerator;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use JMS\Serializer\SerializerBuilder;
use JMS\Serializer\SerializerInterface;
use Schweppesale\Module\Access\Domain\Exceptions\UnauthorizedException;
use Schweppesale\Module\Core\Exceptions\EntityNotFoundException;
use Schweppesale\Module\Core\Providers\Laravel\ServiceProvider;

class PresentationServiceProvider extends ServiceProvider
{

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
        $this->app->bind(SerializerInterface::class, function () {
            $metadata = realpath(__DIR__ . '/../Serializers/Hateoaes');
            $serializer = SerializerBuilder::create()->addMetadataDir($metadata);
            return HateoasBuilder::create($serializer)
                ->addMetadataDir($metadata)
                ->setDebug(env('APP_DEBUG', false))
//                ->setCacheDir(storage_path())
                ->setUrlGenerator(null, new CallableUrlGenerator(function ($route, array $parameters, $absolute) {
                    return route($route, $parameters, $absolute);
                }))
                ->build();
        });

        $this->registerExceptionHandlers();
    }

    /**
     * @return void
     */
    public function registerExceptionHandlers()
    {
        $this->getExceptionHandler()->addModuleExceptionHandler(
            EntityNotFoundException::class,
            function (Request $request, EntityNotFoundException $exception, Response $response) {
                return $response->setStatusCode(404)->setContent(['error' => $exception->getMessage()]);
            }
        );

        $this->getExceptionHandler()->addModuleExceptionHandler(
            UnauthorizedException::class,
            function (Request $request, UnauthorizedException $exception, Response $response) {
                return $response->setStatusCode(404)->setContent(['error' => $exception->getMessage()]);
            }
        );
    }
}