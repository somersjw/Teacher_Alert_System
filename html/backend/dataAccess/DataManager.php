<?php
declare(strict_types=1);
namespace backend\dataAccess;

class DataManager {
    
    private $db;
    private $result;
    public function __construct() {
        $this->db = mysqli_connect("localhost", "test", "test", "alertsystem");
    }

    public function query($query) {
      error_log(print_r($query, true));
        $this->result = mysqli_query($this->db, $query);
    }

    public function fetchAll() {
        return mysqli_fetch_all ($this->result, MYSQLI_ASSOC);
    }

    public function fetch() {
        return mysqli_fetch_assoc ($this->result);
    }

    public function lastId() {
        return mysqli_insert_id($this->db);
    }

    public function rowsAffected() {
        return mysqli_affected_rows($this->db);
    }

    public function resetDb() {
        $query = "DROP TABLE if exists alert;
        CREATE TABLE alert (
          alert_id mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT,
          alert_title varchar(50) NOT NULL,
          alert_message varchar(255) NOT NULL,
          display_on date NOT NULL,
          remove_on date NOT NULL,
          created_at datetime NOT NULL,
          PRIMARY KEY(alert_id)
        );
        INSERT INTO alert (alert_title, alert_message, display_on, remove_on, created_at) VALUES
        ('rgfgsgs', 'gdfsgdfsgdfsg', '2019-08-22', '2019-08-31', '2019-08-01 09:52:51'),
        ('dfsgdfsg', 'sdgdfsgdsf', '2019-08-31', '2019-09-27', '2019-08-01 09:53:22'),
        ('this is a test', 'heeee', '2019-11-10', '2019-11-20', '2019-08-01 10:10:58'),
        ('this is a test', 'heeee', '2019-11-10', '2019-11-20', '2019-08-01 10:11:10'),
        ('this is a test', 'heeee', '2019-11-10', '2019-11-20', '2019-08-01 10:11:10'),
        ('this is a test', 'heeee', '2019-11-10', '2019-11-20', '2019-08-01 10:11:15'),
        ('this is a test', 'heeee', '2019-11-10', '2019-11-20', '2019-08-01 10:11:15'),
        ('this is a test', 'heeee', '2019-11-10', '2019-11-20', '2019-08-01 10:11:15'),
        ('this is a test', 'heeee', '2019-11-10', '2019-11-20', '2019-08-01 10:11:15'),
        ('this is a test', 'heeee', '2019-11-10', '2019-11-20', '2019-08-01 10:11:16'),
        ('this is a test', 'heeee', '2019-11-10', '2019-11-20', '2019-08-01 10:11:16'),
        ('this is a test', 'heeee', '2019-11-10', '2019-11-20', '2019-08-01 10:11:16');
        DROP TABLE if exists alert_site;
        CREATE TABLE alert_site (
          alert_site_id int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
          alert_id mediumint(8) UNSIGNED NOT NULL,
          site_id int(10) UNSIGNED NOT NULL,
          PRIMARY KEY(alert_site_id),
          KEY alert_id (alert_id)
        );
        INSERT INTO alert_site ( alert_id, site_id) VALUES
        (1, 22),
        (1, 3),
        (1, 4),
        (2, 22),
        (2, 26),
        (1, 8),
        (1, 23),
        (1, 19),
        (2, 8),
        (1, 2),
        (1, 5),
        (1, 26),
        (3, 19),
        (3, 23),
        (3, 4),
        (4, 26),
        (4, 2),
        (4, 19),
        (4, 23),
        (4, 8),
        (4, 4),
        (5, 2),
        (5, 8),
        (5, 4),
        (6, 5),
        (6, 2),
        (6, 19),
        (6, 23),
        (6, 8),
        (6, 4),
        (6, 3),
        (6, 22),
        (7, 26),
        (7, 2),
        (7, 19),
        (7, 23),
        (7, 8),
        (7, 4),
        (7, 3),
        (8, 26),
        (8, 5),
        (8, 2),
        (8, 19),
        (8, 23),
        (8, 8),
        (8, 4),
        (8, 3),
        (8, 22),
        (9, 26),
        (9, 5),
        (9, 2),
        (9, 8),
        (10, 5),
        (10, 2),
        (10, 19),
        (10, 4),
        (11, 5),
        (11, 4),
        (11, 3),
        (11, 22),
        (12, 26),
        (12, 2),
        (12, 23),
        (12, 8),
        (12, 4),
        (12, 3),
        (12, 22);
        DROP TABLE if exists alert_member_activity;
        CREATE TABLE alert_member_activity (
          alert_member_activity_id int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
          alert_id mediumint(8) UNSIGNED NOT NULL,
          member_id int UNSIGNED NOT NULL,
          viewed_at datetime NOT NULL,
          PRIMARY KEY (alert_member_activity_id),
          KEY alert_member(alert_id, member_id)
        );
        INSERT INTO alert_member_activity (alert_id, member_id, viewed_at) VALUES 
        (1, 30, '2019-08-01 09:52:51'),
        (2, 30, '2019-08-01 09:52:51'),
        (3, 31, '2019-08-01 09:52:51'),
        (1, 31, '2019-08-01 09:52:51'),
        (2, 6318300, '2019-08-01 09:52:51'),
        (4, 31, '2019-08-01 09:52:51'),
        (4, 6318310, '2019-08-01 09:52:51'),
        (4, 6318300, '2019-08-01 09:52:51');
        DROP TABLE if exists site;
        CREATE TABLE site (
          site_id smallint UNSIGNED NOT NULL AUTO_INCREMENT,
          name varchar(50),
          PRIMARY KEY (site_id)
        );
        INSERT INTO site (name) VALUES
        ('Raz-Plus'),
        ('Reading A-Z'),
        ('Raz-Kids'),
        ('ELL Edition'),
        ('Headsprout'),
        ('Science A-Z'),
        ('Writing A-Z'),
        ('Vocabulary A-Z'),
        ('Readytest A-Z');
        DROP TABLE if exists member;
        CREATE TABLE member (
          member_id int UNSIGNED NOT NULL AUTO_INCREMENT,
          name varchar(50),
          PRIMARY KEY (member_id)
        );
        INSERT INTO member (name) VALUES
        ('ReaderDude'),
        ('ScienceRulez'),
        ('ScienceReader');
        analyze table alert;
        analyze table alert_site;
        analyze table alert_member_activity;";

        $this->db->multi_query($query);
    }
}