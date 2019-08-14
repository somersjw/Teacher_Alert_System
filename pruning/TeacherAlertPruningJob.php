<?php
namespace LAZ\objects\tools;
require_once("{$_ENV['RAZ3_OBJECTS_DIR']}/config/config.inc.php");

$notificationRollupService = new TeacherAlertPruningService();
$notificationRollupService->pruneAlerts();