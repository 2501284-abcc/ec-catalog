# カート機能の安全確認

## 未ログインアクセス

確認場所
- public_html/cart-insert.php

理由
- 未ログイン利用者による不正なカート追加を防ぐため

## POSTチェック

確認場所
- public_html/cart-insert.php

理由
- URL直接アクセスによるデータ登録を防ぐため

## CSRF対策

確認場所
- public_html/item.php
- public_html/cart-insert.php

理由
- 外部サイトからの不正送信を防ぐため

## 商品IDチェック

確認場所
- public_html/cart-insert.php

理由
- 不正な値の登録を防ぐため