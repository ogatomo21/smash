# 簡易スマートホームダッシュボード SMASH (SMArthome daSHboard)

![スクリーンショット](/screenshot1.png)

## 概要

SMASHは、PHPとSQLite、SwitchBot API、気象庁API(非公式)で構築された家庭向けの簡易スマートホームダッシュボードです。

温湿度の情報・エアコンの操作・照明の操作・スマートロックの状態などを一画面で閲覧することが可能で、スマホ操作等と比べ、より簡単にスマートホームを活用できます。

## 使い方

```
docker compose up -d
```

## 使用可能製品

このアプリケーションではSwitchBotの各製品と連携して使うことを想定して制作されています。

具体的には下記の製品に対応しています。

**(※太字は動作確認済み製品)**

- 温湿度: SwitchBot 温湿度計, **SwitchBot 温湿度計プラス**, SwitchBot 温湿度計Pro, SwitchBot CO2センサー（温湿度計）, SwitchBot ハブ2, SwitchBot ハブ3
- 赤外線リモコン: **SwitchBot ハブミニ**, SwitchBot ハブミニ(Matter対応), SwitchBot ハブ2, SwitchBot ハブ3
- スマートロック: SwitchBot ロック, **SwitchBot ロックPro**, SwitchBot ロックUltra, SwitchBot ロックLite,

## 設定方法

`.env` 内に各設定箇所がございます。`.env.sample` を参考に設定を行ってください。

## 自動ダークモード機能

v1.2より、自動ダークモード機能が搭載されました。

これは、ブラウザや端末がダークモードに対応してない場合でも時間帯に応じで自動でダークモードに切り替える機能です。

`.env` 内の `AUTO_DARK_MODE` をtrueにし、`DARK_( START | END )_HOUR` の各項目を設定することで調整できます。

## Kubernetesで動かす場合

v1.2より、Kubernetes用の設定ファイル(`aio.yaml`)を同梱しております。

Kubernetesで動かす際は、そちらのファイルに各種設定情報を入力したうえでデプロイしてください。

## 注意事項

- 本アプリケーションは家庭内または小規模オフィス等での使用を想定しており、ユーザー認証は一切実装しておりません。
- ユーザー認証が必要な場合は各自で `.htaccess` を設定するなどのご対応をお願いします。
- スマホ等の小さい画面ではUIが崩れます。タブレットやPCでご利用ください。というかスマホならアプリのほうが断然使いやすいのでそちらを推奨します。
- 天気情報取得に気象庁の非公式API(公式サイトだがサービス稼働保証なし)を使用しているため、取得ができなくなった場合等で気象庁に問い合わせるのはご遠慮ください。(GitHubのIssueまでお願いします)
- シーン実行機能について、デフォルトではシーン名の先端に「_(アンダーバー)」がついている場合は表示しない設定になっております。アンダーバー付きの項目も表示させたい場合は `src/assets/main.js` 内の `if(scene.sceneName.startsWith('_')) return;` という行を消すかコメントアウトしてください。

## Special Thanks

- [SwitchBot(Wonderlabs)](https://www.switchbot.jp/)
- [SwitchBot API](https://github.com/OpenWonderLabs/SwitchBotAPI)
- [Bulma](https://bulma.io/)
- [Font Awesome](https://fontawesome.com/)
- [IBM Plex Sans JP](https://fonts.google.com/specimen/IBM+Plex+Sans+JP)
- [Jost](https://fonts.google.com/specimen/Jost)
- [気象庁 Webサイト](https://www.jma.go.jp/jma/index.html)

## ライセンス

MIT LICENSE
