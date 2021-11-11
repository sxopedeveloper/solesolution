<?php
/**
* This class is autogenerated by the Spapi class generator
* Date of generation: 2020-12-22
* Specification: ttps://github.com/amzn/selling-partner-api-models/blob/main/models/feeds-api-model/feeds_2020-09-04.json
* Source MD5 signature: e8a9a2035ca171019d970a45acf42daf
*
*
* Selling Partner API for Feeds
* The Selling Partner API for Feeds lets you upload data to Amazon on behalf of a selling partner.
*/
namespace DoubleBreak\Spapi\Api;
use DoubleBreak\Spapi\Client;

class Feeds extends Client {

  /**
  * Operation getFeeds
  *
  * @param array $queryParams
  *    - *feedTypes* array - A list of feed types used to filter feeds. When feedTypes is provided, the other filter parameters (processingStatuses, marketplaceIds, createdSince, createdUntil) and pageSize may also be provided. Either feedTypes or nextToken is required.
  *    - *marketplaceIds* array - A list of marketplace identifiers used to filter feeds. The feeds returned will match at least one of the marketplaces that you specify.
  *    - *pageSize* integer - The maximum number of feeds to return in a single call.
  *    - *processingStatuses* array - A list of processing statuses used to filter feeds.
  *    - *createdSince* string - The earliest feed creation date and time for feeds included in the response, in ISO 8601 format. The default is 90 days ago. Feeds are retained for a maximum of 90 days.
  *    - *createdUntil* string - The latest feed creation date and time for feeds included in the response, in ISO 8601 format. The default is now.
  *    - *nextToken* string - A string token returned in the response to your previous request. nextToken is returned when the number of results exceeds the specified pageSize value. To get the next page of results, call the getFeeds operation and include this token as the only parameter. Specifying nextToken with any other parameters will cause the request to fail.
  *
  */
  public function getFeeds($queryParams = [])
  {
    return $this->send("/feeds/2020-09-04/feeds", [
      'method' => 'GET',
      'query' => $queryParams,
    ]);
  }

  /**
  * Operation createFeed
  *
  */
  public function createFeed($body = [])
  {
    return $this->send("/feeds/2020-09-04/feeds", [
      'method' => 'POST',
      'json' => $body
    ]);
  }

  /**
  * Operation cancelFeed
  *
  * @param string $feedId The identifier for the feed. This identifier is unique only in combination with a seller ID.
  *
  */
  public function cancelFeed($feedId)
  {
    return $this->send("/feeds/2020-09-04/feeds/{$feedId}", [
      'method' => 'DELETE',
    ]);
  }

  /**
  * Operation getFeed
  *
  * @param string $feedId The identifier for the feed. This identifier is unique only in combination with a seller ID.
  *
  */
  public function getFeed($feedId)
  {
    return $this->send("/feeds/2020-09-04/feeds/{$feedId}", [
      'method' => 'GET',
    ]);
  }

  /**
  * Operation createFeedDocument
  *
  */
  public function createFeedDocument($body = [])
  {
    return $this->send("/feeds/2020-09-04/documents", [
      'method' => 'POST',
      'json' => $body
    ]);
  }

  /**
  * Operation getFeedDocument
  *
  * @param string $feedDocumentId The identifier of the feed document.
  *
  */
  public function getFeedDocument($feedDocumentId)
  {
    return $this->send("/feeds/2020-09-04/documents/{$feedDocumentId}", [
      'method' => 'GET',
    ]);
  }
}
