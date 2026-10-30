# 出力エスケープの監査レポート

第12回の課題（上級）。自分の `03_商品カタログ` で、**DB やフォームから来た値を画面に出している箇所**をすべて書き出し、`htmlspecialchars()` を通っているか確かめる。
このファイルは `docs/security-audit.md` として自分のリポジトリに置き、PRで提出する。

## ① 調べ方

- VS Code で `Ctrl` + `Shift` + `F` → `<?=` を検索し、出てきた行を上から順に見る
- `echo` で HTML を組み立てている行も検索する

## ② 出力している箇所の一覧

| ファイル | 行 | 出している値 | どこから来た値か | エスケープ |
|---|---|---|---|---|
| public_html/reviews.php | TODO | `$r['body']` | レビュー投稿（他人が入力） | TODO |
| TODO | TODO | TODO | TODO | TODO |
| ファイル | 行 | 出している値 | どこから来た値か | エスケープ |
|---|---|---|---|---|
| public_html/reviews.php | 63 | $r['name'] | 会員登録の名前（ユーザー入力） | ○ |
| public_html/reviews.php | 66 | $r['body'] | レビュー投稿（他人が入力） | ○ |
| public_html/items.php | （キーワード入力欄の行） | $keyword | URLの検索キーワード | ○ |
| public_html/item.php | （商品名の行） | $item['name'] | DBの商品名 | ○ |
| public_html/mypage.php | （名前表示の行） | $user['name'] | 会員登録の名前（ユーザー入力） | ○ |
``

- 「エスケープ」は、`htmlspecialchars()` を通っていれば `○`、通っていなければ `✕`
- `(int)` を付けた数値や `number_format()` の結果など、HTML の記号が入りようがないものは `―（数値）` と書く

## ③ 直したところ

- TODO（✕ だった箇所と、どう直したか。無ければ「無し」）
- public_html/reviews.php の $r['body'] が htmlspecialchars() を通っていなかったため修正した。
- それ以外に ✕ の箇所は見つからなかった。

## ④ 気づいたこと

- TODO（エスケープを忘れやすいのはどんな場所か、など）
- フォーム入力やURLパラメータ、データベースから取得した値を表示するときは、htmlspecialchars() を忘れないようにする必要がある。
- 特にレビュー本文のようなユーザー入力をそのまま表示すると、XSSの原因になるので注意が必要だと思った。
