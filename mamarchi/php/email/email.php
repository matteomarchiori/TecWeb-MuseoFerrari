<?php

namespace Email;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "tools" . DIRECTORY_SEPARATOR . "phpmailer" . DIRECTORY_SEPARATOR . "src" . DIRECTORY_SEPARATOR . "Exception.php";
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "tools" . DIRECTORY_SEPARATOR . "phpmailer" . DIRECTORY_SEPARATOR . "src" . DIRECTORY_SEPARATOR . "PHPMailer.php";
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "tools" . DIRECTORY_SEPARATOR . "phpmailer" . DIRECTORY_SEPARATOR . "src" . DIRECTORY_SEPARATOR . "SMTP.php";

class Email {

    const HOST = 'smtp.gmail.com';
    const SMTPAUTH = true;
    const USERNAME = 'museoferrariunipd@gmail.com';
    const PASSWORD = 'Muse0Ferrar1/11';
    const SMTPSECURE = 'tls';
    const PORT = 587;
    const FROMMAIL = 'museoferrariunipd@gmail.com';
    const FROMNAME = 'Museo Ferrari';
    const CHARSET = 'UTF-8';
    const ENCODING = 'base64';

    private static $sender;

    public function __construct() {
        if (!isset(self::$sender)) {
            self::$sender = new PHPMailer(true);
            if (isset(self::$sender)) {
                self::$sender->isSMTP();
                self::$sender->Host = self::HOST;
                self::$sender->SMTPAuth = self::SMTPAUTH;
                self::$sender->Username = self::USERNAME;
                self::$sender->Password = self::PASSWORD;
                self::$sender->SMTPSecure = self::SMTPSECURE;
                self::$sender->Port = self::PORT;
                self::$sender->setFrom(self::FROMMAIL, self::FROMNAME);
                self::$sender->CharSet = self::CHARSET;
                self::$sender->Encoding = self::ENCODING;
            }
        }
    }

    public static function sendEmail($subject, $message, $to, $toName) {
        try {
            self::$sender->addAddress($to, $toName);
            self::$sender->Subject = $subject;
            self::$sender->Body = $message;
            self::$sender->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public static function sendEmailWithAttachment($subject, $message, $to, $toName, $attachment, $attachmentName) {
        self::$sender->addAttachment($attachment, $attachmentName);
        return self::sendEmail($subject, $message, $to, $toName);
    }

}
