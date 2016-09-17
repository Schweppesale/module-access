<?php
namespace Schweppesale\Module\Access\Presentation\Providers;

use Doctrine\Common\Annotations\AnnotationRegistry;
use Hateoas\Hateoas;
use Hateoas\HateoasBuilder;
use Hateoas\Serializer\JMSSerializerMetadataAwareInterface;
use Hateoas\UrlGenerator\CallableUrlGenerator;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use JMS\Serializer\SerializerBuilder;
use Schweppesale\Module\Core\Exceptions\EntityNotFoundException;
use Schweppesale\Module\Core\Exceptions\ModuleExceptionHandler;
use Schweppesale\Module\Core\Providers\Laravel\ServiceProvider;
use Metadata\Driver\FileLocator;
use Hateoas\Configuration\Metadata\Driver\YamlDriver;

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
        $this->app->bind(\JMS\Serializer\SerializerInterface::class, function() {
            $metadata = realpath(__DIR__ . '/../Serializers/Hateoaes');
            $serializer = SerializerBuilder::create()->addMetadataDir($metadata);
            return HateoasBuilder::create($serializer)
                ->addMetadataDir($metadata)
                ->setDebug(env('DEBUG_MODE', false))
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
    }
}