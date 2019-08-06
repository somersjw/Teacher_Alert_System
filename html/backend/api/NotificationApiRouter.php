<?
namespace LAZ\objects\shared\api;

use LAZ\objects\library\Router\ControllerRouter;

class NotificationApiRouter extends ControllerRouter{
    public function __construct() {
        parent::__construct(NotificationApiController::class, '/notifications');
    }

    protected function registerRoutes() {
        $this->get('/messages', 'getUserNotifications');
        $this->post('/viewed', 'markAsViewed');
    }
}