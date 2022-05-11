> 阿里翻译
```php
    $alibaba = Translation::alibaba(['timeout' => 5])->translate(['query' => '你好']);
    var_dump($alibaba->getDetect());
    var_dump($alibaba->getTranslation());
```