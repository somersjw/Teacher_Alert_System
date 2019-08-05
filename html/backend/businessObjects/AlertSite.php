<?php
declare(strict_types=1);
namespace LAZ\objects\admin2\alertSystem\businessObjects;

class AlertSite {
    public $siteId;
    public $name;
    public $selected;

    public function __construct(int $siteId, string $name, bool $selected) {
        $this->siteId = $siteId;
        $this->name = $name;
        $this->selected = $selected;
    }
    
    public static function fromArray($arr, bool $selected) {
        return new AlertSite(
            (int)$arr['site_id'],
            $arr['name'],
            $selected
        );
    }

    public static function fromArrays($arrays) {
        return array_map(function ($arr) {
            return AlertSite::fromArray($arr, true);
        }, $arrays);
    }
}