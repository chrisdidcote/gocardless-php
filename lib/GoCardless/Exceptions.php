<?php

/**
 * GoCardless exceptions
 *
 * @package GoCardless\Exceptions
 */

/**
 * Exceptions pertaining to the client object
 *
 * @return exception
 */
class GoCardless_ClientException extends Exception {

  /**
   * Throw a default exception
   *
   * @param string $description Description of the error
   */
  public function __construct($description = 'Unknown client error') {
    parent::__construct($description);
  }

}

/**
 * Exceptions pertaining to the arguments used in a function
 *
 * @return exception
 */
class GoCardless_ArgumentsException extends Exception {

  /**
   * Throw a default exception
   *
   * @param string $description Description of the error
   */
  public function __construct($description = 'Unknown argument error') {
    parent::__construct($description);
  }

}

/**
 * Exceptions pertaining to the GoCardless API
 *
 * @return exception
 */
class GoCardless_ApiException extends Exception {

  /**
   * Throw a default exception
   *
   * @param string $description Description of the error
   * @param integer $code The returned error code
   */

  private $json;

  public function __construct($description = 'Unknown error', $code = 0, $json = null) {
    if (empty($description)) {
      $description = 'Unknown error';
    }

    $this->json = $json;

    parent::__construct($description, $code);
  }

  public function getJson() {
    return $this->json;
  }

  public function getResponse() {
    return json_decode($this->json, true);
  }

  public function getError() {
    $object = json_decode($this->json, true);
    $message = array("HTTP status {$this->code}");

    if (isset($object["errors"])) {
      foreach ($object["errors"] as $key => $val) {
        if (is_array($val)) $val = implode(', ', $val);
        $message[] = "{$key} {$val}";
      }
    }

    if (isset($object["error"])) {
      foreach ($object["error"] as $val) {
        $message[] = $val;
      }
    }

    return implode('. ', $message);
  }

}

/**
 * Exceptions pertaining to the signature
 *
 * @return exception
 */
class GoCardless_SignatureException extends Exception {

  /**
   * Throw a default exception
   *
   * @param string $description Description of the error
   */
  public function __construct($description = 'Signature error') {
    parent::__construct($description);
  }

}
