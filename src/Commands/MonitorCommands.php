<?php

namespace Drupal\cap_monitor\Commands;

use Drupal\Core\Site\Settings;
use Drush\Commands\DrushCommands;
use GuzzleHttp\Client;

class  MonitorCommands extends DrushCommands {

  const AUTH_URL = 'https://authz.stanford.edu/oauth/token';

  /**
   * @var \GuzzleHttp\Client
   */
  protected $client;

  public function __construct(Client $guzzzle) {
    $this->client = $guzzzle;
  }

  /**
   * @command cap:log
   */
  public function checkCap() {
    $access_token = $this->getAccessToken();
    $urls = [
      'https://cap.stanford.edu/cap-api/api/profiles/v1?privGroups=BIOENGINEERING:FACULTY,BIOE:MASTERS,BIOE:COTERM,BIOE:PHD1,BIOE:PHD2,BIOE:PHD3,BIOE:PHD4,BIOE:PHD5,BIOE:PHD6,BIOE:PHD7,BIOE:POSTDOCS,BIOENGINEERING:STAFF&p=1&ps=15&whitelist=uid,displayName',
      'https://cap.stanford.edu/cap-api/api/profiles/v1?privGroups=BIOENGINEERING:FACULTY,BIOE:MASTERS,BIOE:COTERM,BIOE:PHD1,BIOE:PHD2,BIOE:PHD3,BIOE:PHD4,BIOE:PHD5,BIOE:PHD6,BIOE:PHD7,BIOE:POSTDOCS,BIOENGINEERING:STAFF&p=2&ps=15&whitelist=uid,displayName',
      'https://cap.stanford.edu/cap-api/api/profiles/v1?privGroups=BIOENGINEERING:FACULTY,BIOE:MASTERS,BIOE:COTERM,BIOE:PHD1,BIOE:PHD2,BIOE:PHD3,BIOE:PHD4,BIOE:PHD5,BIOE:PHD6,BIOE:PHD7,BIOE:POSTDOCS,BIOENGINEERING:STAFF&p=3&ps=15&whitelist=uid,displayName',
      'https://cap.stanford.edu/cap-api/api/profiles/v1?privGroups=BIOENGINEERING:FACULTY,BIOE:MASTERS,BIOE:COTERM,BIOE:PHD1,BIOE:PHD2,BIOE:PHD3,BIOE:PHD4,BIOE:PHD5,BIOE:PHD6,BIOE:PHD7,BIOE:POSTDOCS,BIOENGINEERING:STAFF&p=4&ps=15&whitelist=uid,displayName',
      'https://cap.stanford.edu/cap-api/api/profiles/v1?privGroups=BIOENGINEERING:FACULTY,BIOE:MASTERS,BIOE:COTERM,BIOE:PHD1,BIOE:PHD2,BIOE:PHD3,BIOE:PHD4,BIOE:PHD5,BIOE:PHD6,BIOE:PHD7,BIOE:POSTDOCS,BIOENGINEERING:STAFF&p=5&ps=15&whitelist=uid,displayName',
      'https://cap.stanford.edu/cap-api/api/profiles/v1?privGroups=BIOENGINEERING:FACULTY,BIOE:MASTERS,BIOE:COTERM,BIOE:PHD1,BIOE:PHD2,BIOE:PHD3,BIOE:PHD4,BIOE:PHD5,BIOE:PHD6,BIOE:PHD7,BIOE:POSTDOCS,BIOENGINEERING:STAFF&p=6&ps=15&whitelist=uid,displayName',
      'https://cap.stanford.edu/cap-api/api/profiles/v1?privGroups=BIOENGINEERING:FACULTY,BIOE:MASTERS,BIOE:COTERM,BIOE:PHD1,BIOE:PHD2,BIOE:PHD3,BIOE:PHD4,BIOE:PHD5,BIOE:PHD6,BIOE:PHD7,BIOE:POSTDOCS,BIOENGINEERING:STAFF&p=7&ps=15&whitelist=uid,displayName',
      'https://cap.stanford.edu/cap-api/api/profiles/v1?privGroups=BIOENGINEERING:FACULTY,BIOE:MASTERS,BIOE:COTERM,BIOE:PHD1,BIOE:PHD2,BIOE:PHD3,BIOE:PHD4,BIOE:PHD5,BIOE:PHD6,BIOE:PHD7,BIOE:POSTDOCS,BIOENGINEERING:STAFF&p=8&ps=15&whitelist=uid,displayName',
      'https://cap.stanford.edu/cap-api/api/profiles/v1?privGroups=BIOENGINEERING:FACULTY,BIOE:MASTERS,BIOE:COTERM,BIOE:PHD1,BIOE:PHD2,BIOE:PHD3,BIOE:PHD4,BIOE:PHD5,BIOE:PHD6,BIOE:PHD7,BIOE:POSTDOCS,BIOENGINEERING:STAFF&p=9&ps=15&whitelist=uid,displayName',
      'https://cap.stanford.edu/cap-api/api/profiles/v1?privGroups=BIOENGINEERING:FACULTY,BIOE:MASTERS,BIOE:COTERM,BIOE:PHD1,BIOE:PHD2,BIOE:PHD3,BIOE:PHD4,BIOE:PHD5,BIOE:PHD6,BIOE:PHD7,BIOE:POSTDOCS,BIOENGINEERING:STAFF&p=10&ps=15&whitelist=uid,displayName',
      'https://cap.stanford.edu/cap-api/api/profiles/v1?privGroups=BIOENGINEERING:FACULTY,BIOE:MASTERS,BIOE:COTERM,BIOE:PHD1,BIOE:PHD2,BIOE:PHD3,BIOE:PHD4,BIOE:PHD5,BIOE:PHD6,BIOE:PHD7,BIOE:POSTDOCS,BIOENGINEERING:STAFF&p=11&ps=15&whitelist=uid,displayName',
      'https://cap.stanford.edu/cap-api/api/profiles/v1?privGroups=BIOENGINEERING:FACULTY,BIOE:MASTERS,BIOE:COTERM,BIOE:PHD1,BIOE:PHD2,BIOE:PHD3,BIOE:PHD4,BIOE:PHD5,BIOE:PHD6,BIOE:PHD7,BIOE:POSTDOCS,BIOENGINEERING:STAFF&p=12&ps=15&whitelist=uid,displayName',
      'https://cap.stanford.edu/cap-api/api/profiles/v1?privGroups=BIOENGINEERING:FACULTY,BIOE:MASTERS,BIOE:COTERM,BIOE:PHD1,BIOE:PHD2,BIOE:PHD3,BIOE:PHD4,BIOE:PHD5,BIOE:PHD6,BIOE:PHD7,BIOE:POSTDOCS,BIOENGINEERING:STAFF&p=13&ps=15&whitelist=uid,displayName',
      'https://cap.stanford.edu/cap-api/api/profiles/v1?privGroups=BIOENGINEERING:FACULTY,BIOE:MASTERS,BIOE:COTERM,BIOE:PHD1,BIOE:PHD2,BIOE:PHD3,BIOE:PHD4,BIOE:PHD5,BIOE:PHD6,BIOE:PHD7,BIOE:POSTDOCS,BIOENGINEERING:STAFF&p=14&ps=15&whitelist=uid,displayName',
      'https://cap.stanford.edu/cap-api/api/profiles/v1?privGroups=BIOENGINEERING:FACULTY,BIOE:MASTERS,BIOE:COTERM,BIOE:PHD1,BIOE:PHD2,BIOE:PHD3,BIOE:PHD4,BIOE:PHD5,BIOE:PHD6,BIOE:PHD7,BIOE:POSTDOCS,BIOENGINEERING:STAFF&p=15&ps=15&whitelist=uid,displayName',
      'https://cap.stanford.edu/cap-api/api/profiles/v1?privGroups=BIOENGINEERING:FACULTY,BIOE:MASTERS,BIOE:COTERM,BIOE:PHD1,BIOE:PHD2,BIOE:PHD3,BIOE:PHD4,BIOE:PHD5,BIOE:PHD6,BIOE:PHD7,BIOE:POSTDOCS,BIOENGINEERING:STAFF&p=16&ps=15&whitelist=uid,displayName',
      'https://cap.stanford.edu/cap-api/api/profiles/v1?privGroups=BIOENGINEERING:FACULTY,BIOE:MASTERS,BIOE:COTERM,BIOE:PHD1,BIOE:PHD2,BIOE:PHD3,BIOE:PHD4,BIOE:PHD5,BIOE:PHD6,BIOE:PHD7,BIOE:POSTDOCS,BIOENGINEERING:STAFF&p=17&ps=15&whitelist=uid,displayName',
      'https://cap.stanford.edu/cap-api/api/profiles/v1?privGroups=BIOENGINEERING:FACULTY,BIOE:MASTERS,BIOE:COTERM,BIOE:PHD1,BIOE:PHD2,BIOE:PHD3,BIOE:PHD4,BIOE:PHD5,BIOE:PHD6,BIOE:PHD7,BIOE:POSTDOCS,BIOENGINEERING:STAFF&p=18&ps=15&whitelist=uid,displayName',
      'https://cap.stanford.edu/cap-api/api/profiles/v1?privGroups=BIOENGINEERING:FACULTY,BIOE:MASTERS,BIOE:COTERM,BIOE:PHD1,BIOE:PHD2,BIOE:PHD3,BIOE:PHD4,BIOE:PHD5,BIOE:PHD6,BIOE:PHD7,BIOE:POSTDOCS,BIOENGINEERING:STAFF&p=19&ps=15&whitelist=uid,displayName',
      'https://cap.stanford.edu/cap-api/api/profiles/v1?privGroups=BIOENGINEERING:FACULTY,BIOE:MASTERS,BIOE:COTERM,BIOE:PHD1,BIOE:PHD2,BIOE:PHD3,BIOE:PHD4,BIOE:PHD5,BIOE:PHD6,BIOE:PHD7,BIOE:POSTDOCS,BIOENGINEERING:STAFF&p=20&ps=15&whitelist=uid,displayName',
      'https://cap.stanford.edu/cap-api/api/profiles/v1?privGroups=BIOENGINEERING:FACULTY,BIOE:MASTERS,BIOE:COTERM,BIOE:PHD1,BIOE:PHD2,BIOE:PHD3,BIOE:PHD4,BIOE:PHD5,BIOE:PHD6,BIOE:PHD7,BIOE:POSTDOCS,BIOENGINEERING:STAFF&p=21&ps=15&whitelist=uid,displayName',
      'https://cap.stanford.edu/cap-api/api/profiles/v1?privGroups=BIOENGINEERING:FACULTY,BIOE:MASTERS,BIOE:COTERM,BIOE:PHD1,BIOE:PHD2,BIOE:PHD3,BIOE:PHD4,BIOE:PHD5,BIOE:PHD6,BIOE:PHD7,BIOE:POSTDOCS,BIOENGINEERING:STAFF&p=22&ps=15&whitelist=uid,displayName',
      'https://cap.stanford.edu/cap-api/api/profiles/v1?privGroups=BIOENGINEERING:FACULTY,BIOE:MASTERS,BIOE:COTERM,BIOE:PHD1,BIOE:PHD2,BIOE:PHD3,BIOE:PHD4,BIOE:PHD5,BIOE:PHD6,BIOE:PHD7,BIOE:POSTDOCS,BIOENGINEERING:STAFF&p=23&ps=15&whitelist=uid,displayName',
      'https://cap.stanford.edu/cap-api/api/profiles/v1?uids=teruel1,dbush1&whitelist=uid,displayName',
    ];

    $options = ['query' => ['access_token' => $access_token]];
    foreach ($urls as $url) {
      $result = $this->client->request('get', $url, $options);
      $response = json_decode((string) $result->getBody(), TRUE);

      $this->compareCapResponses($url, $response);
    }
  }

  protected function compareCapResponses($url, $response) {
    $url_hash = substr(md5($url), 0, 10);
    $cache = \Drupal::cache()->get("cap:$url_hash");
    // Nothing to compare.
    if (!$cache) {
      \Drupal::cache()->set("cap:$url_hash", $response);
      return;
    }

    $logger = \Drupal::logger('cap_monitor');

    $old_data = $cache->data;
    if (count($old_data['values']) != count($response['values'])) {

      if (count($old_data['values']) > count($response['values'])) {
        $logger->critical(t('Different number of profiles. %old in the original dataset, %new in the new dataset'), [
          '%old' => count($old_data['values']),
          '%new' => count($response['values']),
        ]);
      }
      else {
        $logger->info(t('Different number of profiles. %old in the original dataset, %new in the new dataset'), [
          '%old' => count($old_data['values']),
          '%new' => count($response['values']),
        ]);
      }
    }

    foreach ($old_data['values'] as $old_data_profile) {
      $uid = $old_data_profile['uid'];
      foreach ($response['values'] as $new_data_profile) {
        if ($new_data_profile['uid'] == $uid) {
          continue 2;
        }
      }

      $logger->critical(t('Profile not included in the new data. UID: %uid'), ['%uid' => $uid]);
    }

    \Drupal::cache()->set("cap:$url_hash", $response);
  }

  protected function getAccessToken() {
    if ($cache = \Drupal::cache()->get('cap_access_token')) {
      return $cache->data;
    }

    $client_id = Settings::get('CAP_USER');
    $client_secret = Settings::get('CAP_PASSWORD');
    $options = [
      'query' => ['grant_type' => 'client_credentials'],
      'auth' => [$client_id, $client_secret],
    ];
    $response = $this->client->request('get', self::AUTH_URL, $options);
    $body = json_decode((string) $response->getBody(), TRUE);

    \Drupal::cache()
      ->set('cap_access_token', $body['access_token'], time() + $body['expires_in']);
    return $body['access_token'];
  }

}
