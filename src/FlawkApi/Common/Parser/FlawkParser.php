<?php
/**
 * FlawkParser normalizes the http client response
 *
 * @package    FlawkApi
 * @subpackage FlawkParser Parser
 * @author     Nick Bouchard <nybouchard@gmail.com>
 * @copyright  Copyright (c) 2012 the author
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 */
 
namespace FlawkApi\Common\Parser;

use SimpleXMLElement;
use FlawkApi\Common\Parser\Exception\ParserException;

/**
 * FlawkParser custom parsing class to normalize response body;
 */
class FlawkParser implements ParserInterface {

  // var (string) $xml; XML string
  protected $xml;
  
  // var (array) $data; array that will return the final results
  protected $data = array();
  
  
  /**
   * @param array $response; http client response
   * @param array $parseAttributes; array compliant to this parser
   * @return array $results;
   */
  public function parseXML(array $response, array $parseAttributes = null) {
    
    // checks response code and if body is empty
    if ($response["code"] == '200' && !empty($response["body"])) {
      
      $this->xml = $response["body"];
      $xml = new SimpleXMLElement($response["body"]);
      $data = array();
      
      // if xml doesn't exist throw FlawkApi\Common\Parser\Exception\ParserException;
      if (!$xml) {
        throw new ParserException('XML could not be parsed by the SimpleXMLElement; Check response body');
      }
      
      // if there are no parse attributes return the simple xml element
      if ($parseAttributes == null){
        return $xml;
      }
      
      foreach ($parseAttributes as $key => $attributes) {
        $results = $xml->xpath($attributes[0]);
          
        if ($results) {
          foreach ($results as $result) {
            
            switch ($attributes[1]) {
              case 'string':
                $data[$key] = (string)$result;
                break;
                
              case 'decode-string':
                $data[$key] = utf8_decode((string)$result);
                break;
                
              case 'float':
                $data[$key] = (float)$result;
                break;
              
              case 'int':
                $data[$key] = (int)$result;
                break;
                
              case 'array':
                $data[$key] = (array)$result;
                break; 
                
              case 'bool':
                $data[$key] = (bool)$result;
                break;
                
              default:
                $data[$key] = $result;
                break;
                
            }
            
          }
         
        }
          
      }
      
      return $data;
    }
  
  }

}