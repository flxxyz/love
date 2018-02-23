<?php

namespace App\Controller;

use Identicon\Identicon;

/**
 * 头像类
 * Class ImgController
 * @package App\Controller
 */
class ImgController extends Controller
{
    /**
     * qq头像
     * @param $id
     */
    public function qq($id)
    {
        $qq = bit($id, true);
        $url = "http://q.qlogo.cn/headimg_dl?dst_uin=$qq&spec=100";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_REFERER, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36');
        ob_start();
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $result = curl_exec($ch);
        ob_end_clean();
        curl_close($ch);

        $offset = 30 * 60 * 60 * 24; // 一个月
        $cache = gmdate("D, d M Y H:i:s", time() + $offset);
        header("Pragma: cache");
        header("Cache-Control: max-age={$offset}");
        header("Expires: {$cache} GMT");
        header('Content-Type: image/jpeg');
        exit($result);
    }

    /**
     * 随机头像
     * @return string
     */
    public static function identicon()
    {
        $identicon = new Identicon();
        //$identicon->displayImage($this->session->name);
        //$imageData = $identicon->getImageData('bar');
        $imageDataUri = $identicon->getImageDataUri(md5(microtime(true) . mt_rand(1, 9999)));
        return $imageDataUri;
    }
}