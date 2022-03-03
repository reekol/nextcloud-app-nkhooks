<?php

namespace OCA\Nkhooks\Controller;

use OCP\IRequest;
use OCP\AppFramework\Http;
use OCP\AppFramework\Http\TemplateResponse;
use OCP\AppFramework\Http\RedirectResponse;
use OCP\AppFramework\Http\DataResponse;
use OCP\AppFramework\Controller;
use OCP\IConfig;

class PageController extends Controller {

    private $userId;
    private $config;
    private $appUri;

    public function __construct($AppName,IConfig $config, IRequest $request, $UserId){
        parent::__construct($AppName, $request);
        $this->userId = $UserId;
        $this->config = $config;
        $this->appUri = '/index.php/apps/' . $this->appName . '/';
    }

    /**
    * CAUTION: the @Stuff turns off security checks; for this page no admin is
    *          required and no CSRF check. If you don't know what CSRF is, read
    *          it up in the docs or you might create a security hole. This is
    *          basically the only required method to add this exemption, don't
    *          add it to any other method if you don't exactly know what it does
    *
    * @NoAdminRequired
    * @NoCSRFRequired
    */
    public function index() {
        $apkey = md5($this->userId);
        return new TemplateResponse($this->appName, 'index',[
            'apkey' => $apkey,
            'apihk' => json_decode($this->config->getUserValue($apkey       , $this->appName,'apihk'), true),
            'hooks' => json_decode($this->config->getUserValue($this->userId, $this->appName,'hooks'), true),
            'uidat' => json_decode($this->config->getUserValue($this->userId, $this->appName,'uidat'), true),
            ]);
    }

    /**
    * @NoAdminRequired
    * @NoCSRFRequired
    */
    public function hooksPost(string $name = '', string $pin = '') {

    $uidat = [];
        $hooks = $this->config->getUserValue($this->userId, $this->appName,'hooks');
        $hooks = json_decode($hooks, true);

        if($pin == $hooks[$name]['pin']){
            foreach($hooks[$name]['url'] as $u){
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $u);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $res =curl_exec($ch);
            curl_close($ch);
            usleep(250000);
            if(strpos($u,'#')){
                $paths = explode(',',end(explode('#',$u)));
                $res = json_decode($res,true);

                foreach($paths as $path){
                    $path = explode(':',$path);
                    $tmp_name = array_shift($path);
                    $path = implode(':',$path);
                    $path = explode('.',$path);
                    $tmp = $res;
                    foreach($path as $segment){
                        $tmp = $tmp[$segment];
                    }
                    $uidat[$tmp_name] = $tmp;
                }
                $this->config->setUserValue($this->userId, $this->appName, 'uidat', json_encode($uidat));
            }
            }
        }
        return new RedirectResponse($this->appUri);
    }

    /**
    * @NoAdminRequired
    * @NoCSRFRequired
    */
    public function hooksPut(string $name = '', array $url = [], string $pin = '') {

        $hooks = $this->config->getUserValue($this->userId, $this->appName,'hooks');

        if(!$hooks) $hooks = json_encode([]);

        $hooks = json_decode($hooks, true);
        $hooks[trim($name)] = [
            'url' => array_filter($url),
            'pin' => $pin
        ];
        $hooks = json_encode($hooks);

        $this->config->setUserValue($this->userId, $this->appName, 'hooks', $hooks);

        return new RedirectResponse($this->appUri);
    }

    /**
    * @NoAdminRequired
    * @NoCSRFRequired
    */
    public function hooksDelete(string $name = '') {
        $hooks = $this->config->getUserValue($this->userId, $this->appName,'hooks');
        $hooks = json_decode($hooks, true);
        unset($hooks[$name]);
        $hooks = json_encode($hooks);
        $this->config->setUserValue($this->userId, $this->appName, 'hooks', $hooks);

        return new RedirectResponse($this->appUri);
    }

    /**
    * @NoAdminRequired
    * @NoCSRFRequired
    */
    public function hooksExport() {
        $hooks = $this->config->getUserValue($this->userId, $this->appName,'hooks');
        $hooks = json_decode($hooks, true);
        return new DataResponse($hooks,Http::STATUS_OK,[
            'Content-Description' => 'File Transfer',
            'Content-Type' => 'application/octet-stream',
            'Content-Transfer-Encoding' => 'binary',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Pragma' => 'public'
        ]);
    }


    /**
     * @NoAdminRequired
     * @NoCSRFRequired
     */
    public function hooksImport() {
        $import =  $this->request->getUploadedFile('import');
        try{
          $hooks = json_decode(file_get_contents($import['tmp_name']), true);
        }catch (Exception $e){
          Throw new Exception($e->getMessage());
        }

        if($hooks){
          $hooks = json_encode($hooks);
          $this->config->setUserValue($this->userId, $this->appName, 'hooks', $hooks);
        }
        return new RedirectResponse($this->appUri);
    }

}
