<?php
namespace LAZ\objects\admin2\alertSystem\api;

use LAZ\objects\library\Router\ControllerRouter;


class AlertSystemApiRouter extends ControllerRouter {

    public function __construct() {
        parent::__construct(AlertSystemApiController::class, '/alert-system');
    }

    protected function registerRoutes() {
        $tokens = ['alertId' => '\d+'];

        $this->get('/pending', 'getPendingAlerts');
        $this->get('/alert/{alertId}', 'getAlertById', $tokens);
        $this->get('/sites', 'getSites');
        $this->post('/alert', 'createAlert');
        $this->patch('/alert', 'editAlert');
        $this->delete('/alert/{alertId}', 'deleteAlert', $tokens);
    }
}