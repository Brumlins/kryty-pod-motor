<?php
namespace Application;

use Laminas\ModuleManager\Feature\ConfigProviderInterface;
use Laminas\Mvc\MvcEvent;

class Module implements ConfigProviderInterface
{
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
    
    public function onBootstrap(MvcEvent $e)
    {
        $serviceManager = $e->getApplication()->getServiceManager();
        $eventManager = $e->getApplication()->getEventManager();
        
        // Nastavení formátu pro CSV export
        $eventManager->attach(MvcEvent::EVENT_DISPATCH, function($e) {
            $request = $e->getRequest();
            $format = $request->getQuery('format');
            
            if ($format === 'csv') {
                $controller = $e->getTarget();
                $controller->getEvent()->setParam('action', 'csv');
                $e->stopPropagation(true);
                return $controller->dispatch($request);
            }
        }, 100);
    }
}
