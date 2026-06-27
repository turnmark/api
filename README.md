# Turnmark API

[![pages-build-deployment](https://github.com/turnmark/api/actions/workflows/pages/pages-build-deployment/badge.svg)](https://github.com/turnmark/api/actions/workflows/pages/pages-build-deployment)
[![scrape](https://github.com/turnmark/api/actions/workflows/scrape.yml/badge.svg)](https://github.com/turnmark/api/actions/workflows/scrape.yml)
[![license](https://img.shields.io/badge/license-MIT-yellow.svg)](https://opensource.org/licenses/MIT)
[![v1](https://img.shields.io/badge/Turnmark_API-v1-blue)](https://github.com/turnmark/api/tree/gh-pages/docs/v1)

## ⚠️ 注意事項

> ⚡ 本 API は**非公式**であり、BOATRACE 公式サイト・団体とは一切関係ありません。<br>
> 🕒 リアルタイム更新ではなく、**前日までのデータが更新**されています。（ GitHub Actions のスケジュールは scrape.yml を参照 ）<br>
> 🔍 データの正確性・完全性を保証するものではありません。<br>
> 🙇‍♂️ 利用は自己責任でお願いします。

## 📌 概要

この API では、ボートレース（ 競艇 ）のデータを取得できます。<br>
データは GitHub Pages 上で公開されており、JSON 形式で提供されます。

## 🌐 エンドポイント

### [![v1](https://img.shields.io/badge/Turnmark_API-v1-blue)](https://github.com/turnmark/api/tree/gh-pages/docs/v1)

> 📅 対応期間: 2026年06月26日以降

```bash
https://turnmark.github.io/api/v1/YYYY/YYYYMMDD.json
```

📅 YYYY → 年<br>
📅 YYYYMMDD → 年月日<br>
（ 日付は日本標準時 JST〔UTC+9〕基準 ）

## 🧩 サンプル

### [![v1](https://img.shields.io/badge/Turnmark_API-v1-blue)](https://github.com/turnmark/api/tree/gh-pages/docs/v1)

- 2026年06月26日のデータ
  - [https://turnmark.github.io/api/v1/2026/20260626.json](https://turnmark.github.io/api/v1/2026/20260626.json)

## 📄 ライセンス

Turnmark API は [MIT license](LICENSE) の元で公開されています。
