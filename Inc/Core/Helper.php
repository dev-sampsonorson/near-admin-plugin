<?php

    use Westsworld\TimeAgo;

    /**
     * @package CarpentryReviewPlugin
     */

    class Helper {     
        
        public function __construct() {
            
        }

        public static function timeAgo(?DateTime $date): string {
            if (empty($date) || $date === null) return '';

            $timeAgo = new TimeAgo();
            return $timeAgo->inWords($date);
        }

        public static function toDateTimeFromString(string $value, string $format = null): ?DateTime {
            if (empty($value)) return null;

            if ($format == null) {
                return new DateTime($value, new DateTimeZone(WB_CURRENT_TIMEZONE));
            }
        
            return DateTime::createFromFormat($format, $value, new DateTimeZone(WB_CURRENT_TIMEZONE));
        }

        /**
         *
         * Sanatize a single var according to $type.
         * Allows for static calling to allow simple sanatization
         */
        public static function sanitize($var, $type)
        {
            $flags = NULL;
            switch($type)
            {
                    case 'url':
                            $filter = FILTER_SANITIZE_URL;
                    break;
                    case 'int':
                            $filter = FILTER_SANITIZE_NUMBER_INT;
                    break;
                    case 'float':
                            $filter = FILTER_SANITIZE_NUMBER_FLOAT;
                            $flags = FILTER_FLAG_ALLOW_FRACTION | FILTER_FLAG_ALLOW_THOUSAND;
                    break;
                    case 'email':
                            $var = substr($var, 0, 254);
                            $filter = FILTER_SANITIZE_EMAIL;
                    break;
                    case 'string':
                    default:
                            $filter = FILTER_SANITIZE_STRING;
                            $flags = FILTER_FLAG_NO_ENCODE_QUOTES;
                    break;
        
            }
            $output = filter_var($var, $filter, $flags);            
            return($output);
        }

        public static function mergeQueryString($url = null,$query = null,$recursive = false) {
            // $url = 'http://www.google.com.au?q=apple&type=keyword';
            // $query = '?q=banana';
            // if there's a URL missing or no query string, return
            if($url == null)
              return false;
            if($query == null)
              return $url;
            // split the url into it's components
            $url_components = parse_url($url);
            // if we have the query string but no query on the original url
            // just return the URL + query string
            if(empty($url_components['query']))
              return $url.'?'.ltrim($query,'?');
            // turn the url's query string into an array
            parse_str($url_components['query'],$original_query_string);
            // turn the query string into an array
            parse_str(parse_url($query,PHP_URL_QUERY),$merged_query_string);
            // merge the query string
            if($recursive == true)
              $merged_result = array_merge_recursive($original_query_string,$merged_query_string);
            else
              $merged_result = array_merge($original_query_string,$merged_query_string);
            // Find the original query string in the URL and replace it with the new one
            return str_replace($url_components['query'],http_build_query($merged_result),$url);
        }
    }