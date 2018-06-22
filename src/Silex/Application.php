<?php

namespace B3none\Irrel\Silex;

use Symfony\Component\Debug\Debug;
use App\Twig\Extension\AppExtension;
use Aptoma\JsonErrorHandler;
use Aptoma\Silex\Provider\ExtendedLoggerServiceProvider;
use Silex\Application as BaseApplication;
use Silex\Provider\MonologServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;
use Symfony\Component\HttpFoundation\Request;

class Application extends BaseApplication
{
    protected $defaultValues = [
        'timer.threshold_info' => 1000,
        'timer.threshold_warning' => 5000,
    ];

    public function __construct(array $values = [])
    {
        if ($values['debug']) {
            Debug::enable();
        }

        $values = array_merge($this->defaultValues, $values);

        parent::__construct($values);

        $errorHandler = new JsonErrorHandler($this);
        $this->error([$errorHandler, 'handle']);

        $this->registerTwig();
        $this->register(new ServiceControllerServiceProvider());
        $this->register(new UrlGeneratorServiceProvider());

        // Register timer function
        $this->finish([$this, 'logExecTime']);
    }

    // This is now a stub to stop the app erroring!
    public function logExecTime(Request $request)
    {
    }

    /**
     * @param Application $app
     * @return void
     */
    protected function registerLogger(Application $app)
    {
        if (!$app->offsetExists('monolog.name')) {
            return;
        }
        $app->register(
            new MonologServiceProvider(),
            [
                'monolog.name' => $app['monolog.name'],
                'monolog.level' => $app['monolog.level'],
                'monolog.logfile' => $app['monolog.logfile'],
            ]
        );
        $this->register(new ExtendedLoggerServiceProvider());
    }

    /**
     * @return void
     */
    protected function registerTwig()
    {
        if (!$this->offsetExists('twig.path')) {
            return;
        }
        $this->register(
            new TwigServiceProvider(),
            [
                'twig.path' => $this['twig.path'],
                'twig.options' => $this['twig.options']
            ]
        );

        // TODO I don't think this works. AppExtension should implement an interface
        if (class_exists('\App\Twig\Extension\AppExtension')) {
            $app = $this;
            $app['twig'] = $this->share(
                $this->extend(
                    'twig',
                    function (\Twig_Environment $twig) use ($app) {
                        $twig->addExtension(new AppExtension($app));

                        return $twig;
                    }
                )
            );
        }
    }
}
