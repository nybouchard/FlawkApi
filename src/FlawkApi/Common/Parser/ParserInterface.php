<?php
/**
 * @package    FlawkApi
 * @subpackage FlawkParser Interface
 * @author     Nick Bouchard <nybouchard@gmail.com>
 * @copyright  Copyright (c) 2012 the author
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 */
 
namespace FlawkApi\Common\Parser;

use SimpleXMLElement;
use FlawkApi\Common\Parser\Exception\ParserException;

interface ParserInterface {

  /**
   * @param array $response; http client response
   * @param array $xpath; xpath query nodes 
   * @return array $results;
   */
  public function parseXML(array $response, array $xpath = null);

}