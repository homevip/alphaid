# alphaid ID 加密
##### 使用
```
$AlphaID = new AlphaID();

// 多个参数
$encode = $AlphaID->encode(1, 2, 3, 4, 5); // 6lUAfVtaC6

for ($i = 0; $i < 10; $i++) {
    // 加密
    $encode = $AlphaID->encode($i);

    // 解密
    $decode = $AlphaID->decode($encode);

    dump($encode, $decode);
}
```