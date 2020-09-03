# alphaid ID 加密
##### 使用
```
for ($i = 0; $i < 10; $i++) {
    // 加密
    $decode = (new AlphaID())->encode($i);

    // 解密
    $decode = (new AlphaID())->decode($decode);

    dump($decode);
}
```