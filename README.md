# みりあやんないよbot for LINE

※みりあやんないよbotの元ネタは[こちら](https://twitter.com/miriayannaiyo)

# Features
みりあやんないよbotのLINE版。nissyがある日突然血迷って作った。（大体の物事はこうして生まれる）<br>
グループトークに放り込んでおくと忘れた頃に割り込んでくる。

# Requirement
PHP5(検証：5.5.9)
LINE Developpers API(Messaging API)

# Installation
- [LINE Developpers API](https://developers.line.biz/ja/services/messaging-api/)でアカウントを作成、Messaging APIが使用可能なBOTを作成
- webhookを「使用」、自動返信を「使用しない」に設定
- アクセストークンを発行し```miria_token.php```の```$token```に追記
- 外部からアクセス可能なディレクトリに配置し、URLをDeveloppers APIのダッシュボードに登録。SSLのみ対応なので注意。
- みりあも正常動作やーるー！

# Author
nissy(nissy@sfc.wide.ad.jp)
