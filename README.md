# Turnmark API

[![pages-build-deployment](https://github.com/turnmark/api/actions/workflows/pages/pages-build-deployment/badge.svg)](https://github.com/turnmark/api/actions/workflows/pages/pages-build-deployment)
[![scrape](https://github.com/turnmark/api/actions/workflows/scrape.yml/badge.svg)](https://github.com/turnmark/api/actions/workflows/scrape.yml)
[![license](https://img.shields.io/badge/license-MIT-yellow.svg)](https://opensource.org/licenses/MIT)
[![v1](https://img.shields.io/badge/Turnmark_API-v1-blue)](https://github.com/turnmark/api/tree/gh-pages/docs/v1)

## ⚠️ 注意事項

> **本 API を利用する前に、以下の内容をご確認ください。**
>
> - ⚡ **本 API は非公式です。**
>   BOATRACE 公式サイトおよび関連団体とは一切関係ありません。
>
> - 🕒 **データはリアルタイムではありません。**
>   GitHub Actions による定期更新を行っており、**前日までのデータ**を提供しています。更新スケジュールは `scrape.yml` を参照してください。
>
> - 📊 **データの正確性・完全性は保証していません。**
>   収集・変換の都合により、欠損や誤りが含まれる可能性があります。
>
> - 🚫 **公式な情報が必要な場合は、必ず BOATRACE 公式サイトをご確認ください。**
>
> - 🙇‍♂️ **本 API の利用は自己責任でお願いします。**

## 📌 概要

この API では、ボートレース（ 競艇 ）のデータを取得できます。<br>
データは GitHub Pages 上で公開されており、JSON 形式で提供されます。

## 🌐 エンドポイント

### [![v1](https://img.shields.io/badge/Turnmark_API-v1-blue)](https://github.com/turnmark/api/tree/gh-pages/docs/v1)

> 📅 対応期間: 2026年05月01日以降

```bash
https://turnmark.github.io/api/v1/YYYY/YYYYMMDD.json
```

📅 YYYY → 年<br>
📅 YYYYMMDD → 年月日<br>
（ 日付は日本標準時 JST〔UTC+9〕基準 ）

## 🧩 サンプル

### [![v1](https://img.shields.io/badge/Turnmark_API-v1-blue)](https://github.com/turnmark/api/tree/gh-pages/docs/v1)

- 2026年05月01日のデータ
  - [https://turnmark.github.io/api/v1/2026/20260501.json](https://turnmark.github.io/api/v1/2026/20260501.json)

## 📄 ライセンス

Turnmark API は [MIT license](LICENSE) の元で公開されています。
