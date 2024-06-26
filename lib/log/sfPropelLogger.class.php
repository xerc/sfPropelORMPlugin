<?php

/*
 * This file is part of the symfony package.
 * (c) 2004-2006 Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * A symfony logging adapter for Propel
 *
 * @package    symfony
 * @subpackage log
 * @author     Dustin Whittle <dustin.whittle@symfony-project.com>
 * @version    SVN: $Id: sfPropelLogger.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class sfPropelLogger implements Psr\Log\LoggerInterface
{
  protected
    $dispatcher = null;

  /**
   * Constructor.
   *
   * @param sfEventDispatcher $dispatcher
   */
  public function __construct(sfEventDispatcher $dispatcher = null)
  {
    if (null === $dispatcher)
    {
      $this->dispatcher = sfProjectConfiguration::getActive()->getEventDispatcher();
    }
    else
    {
      $this->dispatcher = $dispatcher;
    }
  }

  /**
   * A convenience function for logging an alert event.
   *
   * @param mixed $message the message to log.
   */
  public function alert($message, array $context = [])
  {
    $this->log($message, sfLogger::ALERT);
  }

  /**
   * A convenience function for logging a emergency event.
   *
   * @param mixed $message the message to log.
   */
  public function emergency($message, array $context = [])
  {
    $this->log($message, sfLogger::EMERG);
  }

  /**
   * A convenience function for logging a critical event.
   *
   * @param mixed $message the message to log.
   */
  public function critical($message, array $context = [])
  {
    $this->log($message, sfLogger::CRIT);
  }

  /**
   * A convenience function for logging an error event.
   *
   * @param mixed $message the message to log.
   */
  public function error($message, array $context = [])
  {
    $this->log($message, sfLogger::ERR);
  }

  /**
   * A convenience function for logging a warning event.
   *
   * @param mixed $message the message to log.
   */
  public function warning($message, array $context = [])
  {
    $this->log($message, sfLogger::WARNING);
  }

  /**
   * A convenience function for logging an critical event.
   *
   * @param mixed $message the message to log.
   */
  public function notice($message, array $context = [])
  {
    $this->log($message, sfLogger::NOTICE);
  }

  /**
   * A convenience function for logging an critical event.
   *
   * @param mixed $message the message to log.
   */
  public function info($message, array $context = [])
  {
    $this->log($message, sfLogger::INFO);
  }

  /**
   * A convenience function for logging a debug event.
   *
   * @param mixed $message the message to log.
   */
  public function debug($message, array $context = [])
  {
    $this->log($message, sfLogger::DEBUG);
  }

  /**
   * Primary method to handle logging.
   *
   * @param mixed $message the message to log.
   * @param int $severity The numeric severity. Defaults to null so that no assumptions are made about the logging backend.
   */
  public function log($severity = sfLogger::DEBUG, $message, array $context = [])
  {
    $this->dispatcher->notify(new sfEvent($this, 'application.log', array($message, 'priority' => $severity)));
  }
}
