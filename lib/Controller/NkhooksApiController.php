<?php
namespace OCA\Nkhooks\Controller;

use OCP\AppFramework\Http;
use OCP\AppFramework\Http\DataResponse;
use OCP\AppFramework\ApiController;
use OCP\IRequest;
use OCP\IConfig;


class NkhooksApiController extends ApiController {

    protected $request;
    private $userId;
    private $config;
    private $defaultTopic = 'Default';

    public function __construct($appName,IConfig $config, IRequest $request, $UserId) {
      $this->request = $request;
      $this->userId  = $UserId;
      $this->config  = $config;
      parent::__construct($appName, $request);
    }

    /**
     * @NoAdminRequired
     * @NoCSRFRequired
     * @PublicPage
     * @CORS
     */
     public function apiGetTopic(string $key, string $topic) {

        $apihk = $this->config->getUserValue($key, $this->appName,'apihk');

        if(!$apihk) $apihk = json_encode([]);
        $apihk = json_decode($apihk,true);
        $params = $this->request->getParams();
        $apihk[] = ['time' => microtime(true), 'topic' => $topic, 'params' => $params];
        $apihk = array_slice($apihk, -10);
        $this->config->setUserValue($key, $this->appName,'apihk', json_encode($apihk));

        return new DataResponse([
                'key' => $key,
                'topic' => $topic,
                'params' => $params,
                'sizeOfApihk' => sizeOf($apihk),
            ],Http::STATUS_OK);
    }

    /**
     * @NoAdminRequired
     * @NoCSRFRequired
     * @PublicPage
     * @CORS
     */
     public function apiGet(string $key) {
        return $this->apiGetTopic($key, $this->defaultTopic);
    }
}
