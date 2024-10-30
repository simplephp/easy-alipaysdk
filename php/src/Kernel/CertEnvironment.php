<?php


namespace Alipay\EasySDK\Kernel;


use Alipay\EasySDK\Kernel\Util\AntCertificationUtil;

class CertEnvironment
{
    private $rootCertSN;

    private $merchantCertSN;

    private $cachedAlipayPublicKey;

    /**
     * 构造证书运行环境
     * @param $merchantCertPath    string 商户公钥证书路径
     * @param $alipayCertPath      string 支付宝公钥证书路径
     * @param $alipayRootCertPath  string 支付宝根证书路径
     */
    public function certEnvironment($merchantCertPath, $alipayCertPath, $alipayRootCertPath)
    {
        if (empty($merchantCertPath) || empty($alipayCertPath) || empty($alipayRootCertPath)) {
            throw new \RuntimeException("证书参数merchantCertPath、alipayCertPath或alipayRootCertPath设置不完整。");
        }
        if (!file_exists($merchantCertPath)) {
            throw new \RuntimeException("商户公钥证书文件不存在，文件路径：" . $merchantCertPath);
        }
        if (!file_exists($alipayCertPath)) {
            throw new \RuntimeException("支付宝公钥证书文件不存在，文件路径：" . $alipayCertPath);
        }
        if (!file_exists($alipayRootCertPath)) {
            throw new \RuntimeException("支付宝根证书文件不存在，文件路径：" . $alipayRootCertPath);
        }
        $antCertificationUtil = new AntCertificationUtil();
        $this->rootCertSN = $antCertificationUtil->getRootCertSN($alipayRootCertPath);
        $this->merchantCertSN = $antCertificationUtil->getCertSN($merchantCertPath);
        $this->cachedAlipayPublicKey = $antCertificationUtil->getPublicKey($alipayCertPath);
    }

    /**
     * @return mixed
     */
    public function getRootCertSN()
    {
        return $this->rootCertSN;
    }

    /**
     * @return mixed
     */
    public function getMerchantCertSN()
    {
        return $this->merchantCertSN;
    }

    /**
     * @return mixed
     */
    public function getCachedAlipayPublicKey()
    {
        return $this->cachedAlipayPublicKey;
    }


}