<?php
/*
Copyright 2016-2017 Daniil Gentili
(https://daniil.it)
This file is part of MadelineProto.
MadelineProto is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
MadelineProto is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
See the GNU Affero General Public License for more details.
You should have received a copy of the GNU General Public License along with MadelineProto.
If not, see <http://www.gnu.org/licenses/>.
*/

namespace PostRadar;

class Exception extends \Exception
{
    /**
     * @var mixed
     */
    public $errorData;

    /**
     * Exception constructor.
     * @param null $message
     * @param int $code
     * @param Exception|null $previous
     * @param null $file
     * @param null $line
     */
    public function __construct($message = null, $code = 0, Exception $previous = null, $file = null, $line = null)
    {
        parent::__construct($message, $code, $previous);
        if (\PostRadar\Logger::$constructed && $this->file !== __FILE__) {
            \PostRadar\Logger::log([$message.' in '.basename($this->file).':'.$this->line],
                \PostRadar\Logger::FATAL_ERROR);
        }
        if ($line !== null) {
            $this->line = $line;
        }
        if ($file !== null) {
            $this->file = $file;
        }
    }

    public function getError()
    {
        return $this->errorData;
    }

    /**
     * ExceptionErrorHandler.
     *
     * Error handler
     */
    public static function ExceptionErrorHandler($errno = 0, $errstr = null, $errfile = null, $errline = null)
    {
        // If error is suppressed with @, don't throw an exception
        if (error_reporting() === 0) {
            return true; // return true to continue through the others error handlers
        }
        if (\PostRadar\Logger::$constructed) {
            \PostRadar\Logger::log([$errstr.' in '.basename($errfile).':'.$errline], \PostRadar\Logger::FATAL_ERROR);
        }
        $e = new self($errstr, $errno, null, $errfile, $errline);
        throw $e;
    }

    /**
     * @param null $message
     * @param int $code
     * @param null $error
     * @return bool
     * @throws Exception
     */
    public static function ExceptionPostHandler($message = null, $code = 0, $error = null) {
        // If error is suppressed with @, don't throw an exception
        if (error_reporting() === 0) {
            return true; // return true to continue through the others error handlers
        }
        if (\PostRadar\Logger::$constructed) {
            \PostRadar\Logger::log([$errstr.' in '.basename($errfile).':'.$errline], \PostRadar\Logger::FATAL_ERROR);
        }
        $e = new self($message, $code);
        $e->errorData = $error;
        throw $e;
    }
}
