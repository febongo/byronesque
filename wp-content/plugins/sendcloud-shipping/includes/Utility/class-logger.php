<?php

namespace Sendcloud\Shipping\Utility;

use Sendcloud\Shipping\Sendcloud;
use WC_Logger;

class Logger {
	/**
	 * Log levels
	 */
	const EMERGENCY = 'emergency';
	const ALERT = 'alert';
	const CRITICAL = 'critical';
	const ERROR = 'error';
	const WARNING = 'warning';
	const NOTICE = 'notice';
	const INFO = 'info';
	const DEBUG = 'debug';

	/**
	 * Instance of Logger class
	 *
	 * @var Logger
	 */
	private static $instance;

	/**
	 * WooCommerce logger
	 *
	 * @var WC_Logger
	 */
	private $wc_logger;

	/**
	 * Logger constructor.
	 *
	 * @param WC_Logger $wc_logger
	 */
	public function __construct() {
		if ( version_compare( WC()->version, '2.7', '>=' ) ) {
			$this->wc_logger = wc_get_logger();
		} else {
			$this->wc_logger = new WC_Logger();
		}
	}

	/**
	 * Gets logger instance
	 *
	 * @return Logger
	 */
	private static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Log info level message
	 *
	 * @param $message
	 * @param array $context
	 */
	public static function info( $message, $context = array() ) {
		self::get_instance()->log( self::INFO, $message, $context );
	}

	/**
	 * Log debug level message
	 *
	 * @param $message
	 * @param array $context
	 */
	public static function debug( $message, $context = array() ) {
		self::get_instance()->log( self::DEBUG, $message, $context );
	}

	/**
	 * Log error level message
	 *
	 * @param $message
	 * @param array $context
	 */
	public static function error( $message, $context = array() ) {
		self::get_instance()->log( self::ERROR, $message, $context );
	}

	/**
	 * Log notice level message
	 *
	 * @param $message
	 * @param array $context
	 */
	public static function notice( $message, $context = array() ) {
		self::get_instance()->log( self::NOTICE, $message, $context );
	}

	/**
	 * Log warning level message
	 *
	 * @param $message
	 * @param array $context
	 */
	public static function warning( $message, $context = array() ) {
		self::get_instance()->log( self::WARNING, $message, $context );
	}

	/**
	 * Log alert level message
	 *
	 * @param $message
	 * @param array $context
	 */
	public static function alert( $message, $context = array() ) {
		self::get_instance()->log( self::ALERT, $message, $context );
	}

	/**
	 * Log critical level message
	 *
	 * @param $message
	 * @param array $context
	 */
	public static function critical( $message, $context = array() ) {
		self::get_instance()->log( self::CRITICAL, $message, $context );
	}

	/**
	 * Log emergency level message
	 *
	 * @param $message
	 * @param array $context
	 */
	public static function emergency( $message, $context = array() ) {
		self::get_instance()->log( self::EMERGENCY, $message, $context );
	}

	/**
	 * Log message
	 *
	 * @param $level
	 * @param $message
	 * @param array $context
	 */
	private function log( $level, $message, $context = array() ) {
		if ( ! empty( $context['trace'] ) ) {
			$message .= PHP_EOL . 'Stack trace: ' . PHP_EOL . $context['trace'];
		}

		if ( version_compare( WC()->version, '2.7', '>=' ) ) {
			$context['source'] = Sendcloud::INTEGRATION_NAME;
			$this->wc_logger->log( $level, $message, $context );
		} else {
			$message = strtoupper( $level ) . ' ' . $message;
			$this->wc_logger->add( Sendcloud::INTEGRATION_NAME, $message );
		}
	}
}
