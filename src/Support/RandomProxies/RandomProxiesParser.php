<?php

namespace Support\RandomProxies;

use Support\RandomProxies\Contracts\CanParseRandomProxiesHtml;
use Support\RandomProxies\DTOs\ProxyDTO;
use Support\Traits\HasHtmlParsing;
use Carbon\Carbon;
use Symfony\Component\DomCrawler\Crawler;

class RandomProxiesParser implements CanParseRandomProxiesHtml
{
    use HasHtmlParsing;

    const _GUID_KEY_KEY = "key";
    const _GUID_KEY_SELECTOR = "selector";
    const _GUID_KEY_ATTRIBUTE = "attribute";
    const _GUID_KEY_CALLBACK = "callback";
    const _GUID_KEY_PATTERN = "pattern";
    const _GUID_KEY_MATCH_INDEX = "matchIndex";

    const _RAW_KEY_IP = "ip";
    const _RAW_KEY_PORT = "port";
    const _RAW_KEY_COUNTRY_CODE = "countryCode";
    const _RAW_KEY_COUNTRY = "country";
    const _RAW_KEY_ANONYMITY = "anonymity";
    const _RAW_KEY_IS_GOOGLE = "isGoogle";
    const _RAW_KEY_IS_HTTPS = "isHttps";
    const _RAW_KEY_LAST_CHECKED = "lastChecked";

    /**
     * Third party library parser
     *
     * @var Crawler
     * */
    protected $crawler;

    public function __construct(string $html)
    {
        $this->crawler = new Crawler($html);

        $this->parsingGuid = [
            self::_RAW_KEY_IP => [
                self::_GUID_KEY_KEY => self::_RAW_KEY_IP,
                self::_GUID_KEY_SELECTOR => "#proxylisttable tbody tr td:nth-child(1)",
            ],
            self::_RAW_KEY_PORT => [
                self::_GUID_KEY_KEY => self::_RAW_KEY_PORT,
                self::_GUID_KEY_SELECTOR => "#proxylisttable tbody tr td:nth-child(2)",
            ],
            self::_RAW_KEY_COUNTRY_CODE => [
                self::_GUID_KEY_KEY => self::_RAW_KEY_COUNTRY_CODE,
                self::_GUID_KEY_SELECTOR => "#proxylisttable tbody tr td:nth-child(3)",
            ],
            self::_RAW_KEY_COUNTRY => [
                self::_GUID_KEY_KEY => self::_RAW_KEY_COUNTRY,
                self::_GUID_KEY_SELECTOR => "#proxylisttable tbody tr td:nth-child(4)",
            ],
            self::_RAW_KEY_ANONYMITY => [
                self::_GUID_KEY_KEY => self::_RAW_KEY_ANONYMITY,
                self::_GUID_KEY_SELECTOR => "#proxylisttable tbody tr td:nth-child(5)",
            ],
            self::_RAW_KEY_IS_GOOGLE => [
                self::_GUID_KEY_KEY => self::_RAW_KEY_IS_GOOGLE,
                self::_GUID_KEY_SELECTOR => "#proxylisttable tbody tr td:nth-child(6)",
            ],
            self::_RAW_KEY_IS_HTTPS => [
                self::_GUID_KEY_KEY => self::_RAW_KEY_IS_HTTPS,
                self::_GUID_KEY_SELECTOR => "#proxylisttable tbody tr td:nth-child(7)",
            ],
            self::_RAW_KEY_LAST_CHECKED => [
                self::_GUID_KEY_KEY => self::_RAW_KEY_LAST_CHECKED,
                self::_GUID_KEY_SELECTOR => "#proxylisttable tbody tr td:nth-child(8)",
            ],
        ];

        $this->initRawresult();
        $this->initParsingGuid();
    }

    /**
     * Parse html string, format into entries and return array of random proxies entries
     *
     * @return ProxyDTO[]
     * */
    public function parseRandomProxies(): array
    {
        if (!$this->getHtml()) $this->result = [];

        if (is_null($this->result)) {
            $this->parseRawResult();
            $this->rawResultToEntries();
        }
        return $this->result;
    }

    public function rawResultToEntries()
    {
        foreach ($this->rawResult as $item) {
            $this->result[] = new ProxyDTO([
                'ip' => (string)$item[static::_RAW_KEY_IP],
                'port' => (int)$item[static::_RAW_KEY_PORT],
                'countryCode' => (string)$item[static::_RAW_KEY_COUNTRY_CODE],
                'country' => (string)$item[static::_RAW_KEY_COUNTRY],
                'anonymity' => (string)$item[static::_RAW_KEY_ANONYMITY],
                'isGoogle' => $item[static::_RAW_KEY_IS_GOOGLE] === "yes",
                'isHttps' => $item[static::_RAW_KEY_IS_HTTPS] === "yes",
                'lastChecked' => Carbon::parse($item[static::_RAW_KEY_LAST_CHECKED]),
            ]);
        }
    }
}
