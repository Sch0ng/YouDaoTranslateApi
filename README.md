# YouDaoTranslateApi

## 简介

- 使用有道翻译API实现简单翻译工具
- 支持英汉互译

## 安装
1. 将代码clone到本地
2. 设置命令别名
    ```
    vim ~/.bashrc
    alias t='/usr/local/bin/php /YourLocalPath/YouDaoTranslateApi/index.php'
    source ~/.bashrc
    ```
3. 使用方法
    ```
    # 汉译英
    $ : ~ t 翻译
    英文:翻译
    翻译:翻译
    释义:
        translate
        interpret
    发音:
        读音：fān yì
    网络:
        翻译:          Translation, translate, Translator
        机器翻译:    machine translation, mechanical translation, Machinery-Translating
        翻译记忆:    Translation memory, Translation Memory, translation memory
    
    
    # 英译汉
    $ : ~ t translate
    英文:translate
    翻译:翻译
    释义:
        vt. 翻译；转化；解释；转变为；调动
        vi. 翻译
    发音:
        美音：træns'let
        读音：træns'leɪt; trɑːns-; -nz-
        英音：træns'leɪt; trɑːns-; -nz-
    网络:
        translate:         翻译, 转化, 协议转换信息
        Translate Tool:    线上翻译, 平移工具, 移动工具
        translate it:      翻译, 翻译它, 把它
    ```
## 备注
- [有道云翻译API文档](http://ai.youdao.com/docs/doc-trans-api.s#p05)
- 其他待支持语言如下
    - 日文
    - 韩文
    - 法文
    - 俄文
    - 西班牙文
    - 葡萄牙文
- 仅支持类Linux系统使用
