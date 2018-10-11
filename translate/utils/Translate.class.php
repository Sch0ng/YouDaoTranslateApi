<?php

namespace YouDaoTranslateApi\translate\utils;

/**
 * Class Translate
 * @package YouDaoTranslateApi
 * @author Sch0ng@163.com
 */
class Translate
{
    const TABLE1 = '    ';
    const TABLE2 = '        ';
    const TABLE3 = '            ';

    public function run($argv = [])
    {
        if (empty($argv[1])) {
            echo '请输入要查询的词语' . PHP_EOL;
            echo self::TABLE1 . '格式: \'词典 e\'' . PHP_EOL;
            die();
        }
        $query = $argv[1];
        $from = isset($argv[2]) ? $argv[2] : 'e';
        if ($from == 'e') {
            $from = Request::ENGLISH;
            $to = Request::CHINESE;
        } else {
            $from = Request::CHINESE;
            $to = Request::ENGLISH;
        }
        $json = (new Request())->translate($query, $from, $to);
        $result = json_decode($json, 1);
        $this->parser($result);
    }

    private function parser($result)
    {
        //0. 英文
        $query = isset($result['query']) ? $result['query'] : '';
        echo '英文:' . $query . PHP_EOL;

        //2. 常用翻译
        echo '翻译:' . implode(', ', $result['translation']) . PHP_EOL;

        //3. 详细释义
        if (isset($result['basic'])) {
            echo '释义:' . PHP_EOL;
            self::saveQuery($query);
            foreach ($result['basic']['explains'] as $value) {
                echo self::TABLE1 . $value . PHP_EOL;
            }
        }
        //3. 发音
        if (isset($result['basic'])) {
            echo '发音:' . PHP_EOL;
            if (isset($result['basic']['us-phonetic'])) {
                echo self::TABLE1 . '美音：' . $result['basic']['us-phonetic'] . PHP_EOL;
            }
            if (isset($result['basic']['phonetic'])) {
                echo self::TABLE1 . '读音：' . $result['basic']['phonetic'] . PHP_EOL;
            }
            if (isset($result['basic']['uk-phonetic'])) {
                echo self::TABLE1 . '英音：' . $result['basic']['uk-phonetic'] . PHP_EOL;
            }
        }

        //1. 网络释义
        if (isset($result['web'])) {
            echo '网络:' . PHP_EOL;

            $keys = array_column($result['web'], 'key');
            $max_length = 0;
            foreach ($keys as $key) {
                $length = strlen($key);
                if ($length > $max_length) {
                    $max_length = $length;
                }
            }

            foreach ($result['web'] as $value) {
                $key_length = strlen($value['key']);
                $offset = $max_length - $key_length;
                $blank = '';
                if ($offset > 0) {
                    $blank = str_pad($blank, $offset, ' ');
                }
                echo self::TABLE1 . $value['key'] . ':' . $blank;
                echo self::TABLE1 . implode(', ', $value['value']) . PHP_EOL;
            }
        }

    }

    private static function saveQuery($query = '')
    {
        global $base_path;
        $file = $base_path . '/translate/data/' . $query[0] . '.txt';
        if (!file_exists($file)) {
            fopen($file, 'w');
        }
        if (preg_match('/[a-zA-Z]+/', $query)) {
            $list = file_get_contents($file);
            if (empty($list)) {
                $list = [$query => 1];
            } else {
                $list = json_decode($list,1);
                $list[$query] += 1;
            }
            arsort($list);
            file_put_contents($file, json_encode($list));
        }
    }

    private function englishToChinestDemo()
    {
        return [
            'web'         => [
                [
                    'value' => [
                        '地狱',
                        '情狱',
                        '阴间',
                    ],
                    'key'   => [
                        'Hell',
                    ],
                ],
            ],
            'query'       => 'hell',
            'translation' => [
                '地狱',
            ],
            'errorCode'   => 0,
            'basic'       => [
                'us-phonetic'  => 'hɛl',
                'phonetic'     => 'hel',
                'uk-phonetic]' => 'hel',
                'explains'     => [
                    'n. 地狱；究竟（作加强语气词）；训斥；黑暗势力',
                    'vi. 过放荡生活；飞驰',
                    'int. 该死；见鬼（表示惊奇、烦恼、厌恶、恼怒、失望等）',
                    'n. (Hell)人名；(柬)海；(西)埃利；(德、匈、捷、罗、芬、瑞典)黑尔',

                ],

            ],
        ];
    }
}
