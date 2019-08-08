<?php
declare(strict_types=1);
namespace backend\api;
require_once 'backend/services/AlertSystemService.php';


use LAZ\objects\admin2\sites\services\SiteService;
use LAZ\objects\library\Router\Resource;
use Psr\Http\Message\ServerRequestInterface;
use backend\services\AlertSystemService;
use LAZ\objects\admin2\alertSystem\businessObjects\AlertSite;
use LAZ\objects\library\SiteHelper;

class AlertSystemApiController {
    /**
     * @var AlertSystemService
     */
    private $alertService;
    public function __construct() {
        $this->alertService = new AlertSystemService();
    }

    public function createAlert($request) {
        return $this->alertService->createAlert($request);
    }

    public function getSites() {
        return $this->alertService->getSites();
    }

    public function deleteAlert(int $alertId) {
        return $this->alertService->deleteAlert($alertId);
    }

    public function editAlert($request) {
        return $this->alertService->editAlert($request);
    }

    public function getPendingAlerts() {
        return $this->alertService->getPendingAlerts();
    }

    public function getAlertById(int $alertId) {
        return $this->alertService->getAlertById((int)$alertId);
    }

    public function setResource($resource) {
        $this->resource = $resource;
    }
}