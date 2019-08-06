<?php
declare(strict_types=1);
namespace LAZ\objects\admin2\alertSystem\api;

use LAZ\objects\admin2\sites\services\SiteService;
use LAZ\objects\library\Router\Resource;
use Psr\Http\Message\ServerRequestInterface;
use LAZ\objects\admin2\alertSystem\services\AlertSystemService;
use LAZ\objects\admin2\alertSystem\businessObjects\AlertSite;
use LAZ\objects\library\SiteHelper;

class AlertSystemApiController implements Resource {
    /**
     * @var Resource
     * @var AlertSystemService
     */
    private $alertService;
    private $resource;
    public function __construct() {
        $this->alertService = new AlertSystemService();
    }

    public function createAlert() {
        $alert = $this->resource;
        return $this->alertService->createAlert($alert);
    }

    public function getSites() {
        return $this->alertService->getSites();

    }

    public function deleteAlert(ServerRequestInterface $request) {
        $alertId = $request->getAttribute('alertId');
        return $this->alertService->deleteAlert((int)$alertId);
    }

    public function editAlert() {
        $alert = $this->resource;
        return $this->alertService->editAlert($alert);
    }

    public function getPendingAlerts() {
        return $this->alertService->getPendingAlerts();
    }

    public function getAlertById(ServerRequestInterface $request) {
        $alertId = $request->getAttribute('alertId');
        return $this->alertService->getAlertById((int)$alertId);
    }

    public function setResource($resource) {
        $this->resource = $resource;
    }
}