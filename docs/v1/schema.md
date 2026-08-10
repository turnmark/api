# レスポンススキーマ (v1)

> 📅 対応期間: 2026年01月01日以降

## エンドポイント

```
https://turnmark.github.io/api/v1/YYYY/YYYYMMDD.json
```

## `_source` フィールドについて

`_source` サフィックスが付くフィールドは、スクレイピングで取得したオリジナルの文字列です。  
対応する `_source` なしのフィールドは、そのオリジナル文字列を変換・正規化した値です。

例:
| フィールド | 値 | 説明 |
|---|---|---|
| `day_number_source` | `"初日"` | スクレイピング元の文字列 |
| `day_number` | `1` | 変換後の数値 |

## `null` について

**すべてのフィールドは `null` になり得ます。** 公式サイト上で該当欄が空欄の場合、`_source` と変換後の値がいずれも `null` になります。

主な例は以下のとおりです。

| ケース | 該当フィールド |
|---|---|
| 欠場艇 | `course_number` / `start_timing` / オッズ |
| プロペラを交換していない | `propeller` |
| 部品交換の個数が非公表 | `parts[].quantity` |
| 直前情報が未公開のレース | `preview` 配下すべて（`parts` は空配列ではなく `null`） |
| 決まり手が付かないレース | `technique_number` |

---

## JSON 全体構造

レスポンスは以下の階層で構成されます。  
スタジアム番号・レース番号はいずれも文字列キー（例: `"1"`）です。

```
{
  "programs": {
    "stadiums": {
      "{stadium_number}": {
        "races": {
          "{race_number}": {
            // 出走表
            "date": "...",
            "stadium_number": ...,
            "race_number": ...,
            ...
            "racers": { "{entry_number}": { ... } },

            // 直前情報
            "preview": {
              ...
              "racers": { "{entry_number}": { ... } }
            },

            // オッズ
            "odds": { ... },

            // 結果
            "result": {
              ...
              "racers": { "{entry_number}": { ... } }
            }
          }
        }
      }
    }
  }
}
```

---

## 出走表

`programs.stadiums.{stadium_number}.races.{race_number}` 直下のフィールドです。

### 基本情報

| フィールド | 型 | `_source` | 説明 |
|---|---|---|---|
| `date` | `string` | — | レース開催日（`YYYY-MM-DD`） |
| `stadium_number` | `integer` | — | レース場番号 |
| `race_number` | `integer` | — | レース番号 |
| `closed_at` | `string` | — | 締切日時（`YYYY-MM-DD HH:MM:SS`） |
| `grade_number` | `integer` | ✅ | グレード番号 |
| `title` | `string` | — | レースタイトル |
| `subtitle` | `string` | — | レースサブタイトル |
| `distance` | `integer` | ✅ | 距離（メートル） |
| `day_number` | `integer` | ✅ | 開催日番号（何日目か） |

### 選手情報 (`racers`)

枠番（`1`〜`6`）をキーとするオブジェクトです。

| フィールド | 型 | `_source` | 説明 |
|---|---|---|---|
| `entry_number` | `integer` | — | 枠番 |
| `name` | `string` | — | 選手名 |
| `number` | `integer` | — | 選手登録番号 |
| `rank_number` | `integer` | ✅ | 級別番号 |
| `branch_number` | `integer` | ✅ | 支部番号 |
| `birthplace_number` | `integer` | ✅ | 出身地番号 |
| `age` | `integer` | ✅ | 年齢 |
| `weight` | `float` | ✅ | 体重（kg） |
| `flying_count` | `integer` | ✅ | フライング回数 |
| `late_count` | `integer` | ✅ | 出遅れ回数 |
| `average_start_timing` | `float` | — | 平均スタートタイミング |
| `national_win_rate` | `float` | — | 全国勝率 |
| `national_top_2_percent` | `float` | — | 全国 2 連対率（%） |
| `national_top_3_percent` | `float` | — | 全国 3 連対率（%） |
| `local_win_rate` | `float` | — | 当地勝率 |
| `local_top_2_percent` | `float` | — | 当地 2 連対率（%） |
| `local_top_3_percent` | `float` | — | 当地 3 連対率（%） |
| `motor_number` | `integer` | — | モーター番号 |
| `motor_top_2_percent` | `float` | — | モーター 2 連対率（%） |
| `motor_top_3_percent` | `float` | — | モーター 3 連対率（%） |
| `boat_number` | `integer` | — | ボート番号 |
| `boat_top_2_percent` | `float` | — | ボート 2 連対率（%） |
| `boat_top_3_percent` | `float` | — | ボート 3 連対率（%） |

---

## 直前情報 (`preview`)

`programs.stadiums.{stadium_number}.races.{race_number}.preview` 直下のフィールドです。

### 基本情報

| フィールド | 型 | `_source` | 説明 |
|---|---|---|---|
| `date` | `string` | — | レース開催日（`YYYY-MM-DD`） |
| `stadium_number` | `integer` | — | レース場番号 |
| `race_number` | `integer` | — | レース番号 |
| `wind_speed` | `integer` | ✅ | 風速（m） |
| `wind_direction_number` | `integer` | ✅ | 風向番号 |
| `wave_height` | `integer` | ✅ | 波高（cm） |
| `weather_number` | `integer` | ✅ | 天候番号 |
| `air_temperature` | `float` | ✅ | 気温（℃） |
| `water_temperature` | `float` | ✅ | 水温（℃） |

### 選手情報 (`racers`)

枠番（`1`〜`6`）をキーとするオブジェクトです。

| フィールド | 型 | `_source` | 説明 |
|---|---|---|---|
| `entry_number` | `integer` | — | 枠番 |
| `course_number` | `integer` | — | 進入コース番号 |
| `start_timing` | `float` | ✅ | スタートタイミング |
| `weight` | `float` | ✅ | 体重（kg） |
| `weight_adjustment` | `float` | ✅ | 体重調整量（kg） |
| `exhibition_time` | `float` | ✅ | 展示タイム（秒） |
| `tilt_adjustment` | `float` | ✅ | チルト調整 |
| `propeller` | `string` | — | プロペラ交換の有無（交換時は `"新"`、それ以外は `null`） |
| `parts` | `array` | — | 部品交換情報（交換がなければ空配列、直前情報が未公開のレースは `null`） |

#### 部品交換情報 (`parts`)

交換した部品ごとの要素を持つ配列です。

| フィールド | 型 | `_source` | 説明 |
|---|---|---|---|
| `number` | `integer` | ✅ | 部品番号 |
| `quantity` | `integer` | — | 交換個数（非公表の場合は `null`） |

```json
"parts": [
  { "number_source": "リング", "number": 2, "quantity": 4 },
  { "number_source": "キャブ", "number": 4, "quantity": null }
]
```

部品番号の対応は以下のとおりです。

| 番号 | 部品 | 番号 | 部品 |
|---|---|---|---|
| `1` | ピストン | `5` | シリンダ |
| `2` | ピストンリング | `6` | クランクシャフト |
| `3` | 電気一式 | `7` | ギヤケース |
| `4` | キャブレター | `8` | キャリアボデー |

---

## オッズ (`odds`)

`programs.stadiums.{stadium_number}.races.{race_number}.odds` 直下のフィールドです。

### 基本情報

| フィールド | 型 | `_source` | 説明 |
|---|---|---|---|
| `date` | `string` | — | レース開催日（`YYYY-MM-DD`） |
| `stadium_number` | `integer` | — | レース場番号 |
| `race_number` | `integer` | — | レース番号 |

### 賭式情報

| フィールド | 賭式 | 説明 |
|---|---|---|
| `trifecta` | 3連単 | 1着・2着・3着を順番通りに予想 |
| `trio` | 3連複 | 1着・2着・3着を順不同で予想 |
| `exacta` | 2連単 | 1着・2着を順番通りに予想 |
| `quinella` | 2連複 | 1着・2着を順不同で予想 |
| `quinella_place` | 拡連複 | 2着以内に入る2艇を順不同で予想 |
| `win` | 単勝 | 1着を予想 |
| `place` | 複勝 | 2着以内を予想 |

### オッズの参照方法

賭式によってキーの深さが異なります。枠番はいずれも文字列キー（例: `"1"`）です。

**3連単 (`trifecta`)** — `[1着枠番][2着枠番][3着枠番]`

```json
"trifecta": {
  "1": { "2": { "3": 10.7, "4": 8.6 } }
}
```

**3連複 (`trio`)** — `[枠番A][枠番B][枠番C]`（A &lt; B &lt; C）

```json
"trio": {
  "1": { "2": { "3": 4.2 } }
}
```

**2連単 (`exacta`)** — `[1着枠番][2着枠番]`

```json
"exacta": {
  "1": { "2": 2.5 }
}
```

**2連複 (`quinella`)** — `[枠番A][枠番B]`（A &lt; B）

```json
"quinella": {
  "1": { "2": 1.5 }
}
```

**拡連複 (`quinella_place`)** — `[枠番A][枠番B]`（A &lt; B）、オッズは下限・上限で表現

```json
"quinella_place": {
  "1": { "2": { "lower_limit": 1.3, "upper_limit": 1.3 } }
}
```

**単勝 (`win`)** — `[枠番]`

```json
"win": {
  "1": 1.5
}
```

**複勝 (`place`)** — `[枠番]`、オッズは下限・上限で表現

```json
"place": {
  "1": { "lower_limit": 1.0, "upper_limit": 1.1 }
}
```

### 欠場艇のオッズ

欠場艇を含む組み合わせは公式サイト上でオッズ欄が空欄になるため、`null` になります。下限・上限で表現する賭式（拡連複・複勝）では、`lower_limit` と `upper_limit` の両方が `null` です。

```json
"win": { "1": null, "2": 2.0 },
"place": { "1": { "lower_limit": null, "upper_limit": null } }
```

該当する枠番は、結果 (`result`) の `refunds` で確認できます。

---

## 結果 (`result`)

`programs.stadiums.{stadium_number}.races.{race_number}.result` 直下のフィールドです。

### 基本情報

| フィールド | 型 | `_source` | 説明 |
|---|---|---|---|
| `date` | `string` | — | レース開催日（`YYYY-MM-DD`） |
| `stadium_number` | `integer` | — | レース場番号 |
| `race_number` | `integer` | — | レース番号 |
| `wind_speed` | `integer` | ✅ | 風速（m） |
| `wind_direction_number` | `integer` | ✅ | 風向番号 |
| `wave_height` | `integer` | ✅ | 波高（cm） |
| `weather_number` | `integer` | ✅ | 天候番号 |
| `air_temperature` | `float` | ✅ | 気温（℃） |
| `water_temperature` | `float` | ✅ | 水温（℃） |
| `technique_number` | `integer` | ✅ | 決まり手番号 |
| `remarks` | `string` | — | 備考（返還艇がある場合は `"【返還艇あり】"`、それ以外は `null`） |
| `refunds` | `array` | — | 返還艇の枠番リスト（返還がなければ空配列） |

### 返還艇 (`refunds`)

フライング・出遅れ・欠場により舟券が返還された艇の枠番です。

```json
"remarks": "【返還艇あり】",
"refunds": [2, 3, 5, 6]
```

### 選手情報 (`racers`)

枠番（`1`〜`6`）をキーとするオブジェクトです。

| フィールド | 型 | `_source` | 説明 |
|---|---|---|---|
| `entry_number` | `integer` | — | 枠番 |
| `course_number` | `integer` | — | 進入コース番号 |
| `start_timing` | `float` | ✅ | スタートタイミング |
| `place_number` | `integer` | ✅ | 着順番号 |
| `number` | `integer` | ✅ | 選手登録番号 |
| `name` | `string` | — | 選手名 |

着順番号は、通常の着順のほか失格・欠場も表します。

| 番号 | 意味 | 番号 | 意味 |
|---|---|---|---|
| `1`〜`6` | 1着〜6着 | `12` | 不完走失格 |
| `7` | 妨害失格 | `13` | 失格 |
| `8` | エンスト失格 | `14` | フライング欠場 |
| `9` | 転覆失格 | `15` | 出遅れ欠場 |
| `10` | 落水失格 | `16` | 欠場 |
| `11` | 沈没失格 | `99` | その他 |

レースに出走しなかった艇（`14`〜`16`）は、`course_number` と `start_timing` が `null` になります。

### 払戻情報 (`payouts`)

賭式をキーとする配列です。同じ賭式で複数の払戻がある場合（同着など）、配列に複数の要素が含まれます。

| フィールド | 型 | 説明 |
|---|---|---|
| `combination` | `string` | 的中組み合わせ（例: `"4-3-1"`、`"1=3=4"`） |
| `amount` | `integer` | 払戻金額（円） |
| `label` | `string` | 組み合わせが確定しなかった場合のラベル（例: `"特払"`、`"不成立"`） |

```json
"payouts": {
  "trifecta": [
    { "combination": "4-3-1", "amount": 3040, "label": null }
  ],
  "trio": [
    { "combination": "1=3=4", "amount": 300, "label": null }
  ],
  "exacta": [
    { "combination": "4-3", "amount": 1290, "label": null }
  ],
  "quinella": [
    { "combination": "3=4", "amount": 380, "label": null }
  ],
  "quinella_place": [
    { "combination": "3=4", "amount": 160, "label": null },
    { "combination": "1=4", "amount": 200, "label": null },
    { "combination": "1=3", "amount": 260, "label": null }
  ],
  "win": [
    { "combination": "4", "amount": 330, "label": null }
  ],
  "place": [
    { "combination": "4", "amount": 140, "label": null },
    { "combination": "3", "amount": 140, "label": null }
  ]
}
```

### 払戻が発生しないケース

通常の払戻以外に3つのケースがあります。`combination` と `amount` のどちらが `null` かで判別できます。

| ケース | `combination` | `amount` | `label` | 意味 |
|---|---|---|---|---|
| 通常 | 組番 | 金額 | `null` | 的中・払戻あり |
| 票なし | 組番 | `null` | `null` | 的中したが該当票がなく、同じ賭式の他の的中目が総取り |
| 特払 | `null` | 返還額 | `"特払"` | その賭式のどの目にも票がなく、全票が返還 |
| 不成立 | `null` | 返還額 | `"不成立"` | 返還艇により賭式自体が不成立 |

```json
"win": [
  { "combination": null, "amount": 70, "label": "特払" }
],
"trifecta": [
  { "combination": null, "amount": 100, "label": "不成立" }
],
"place": [
  { "combination": "3", "amount": 140, "label": null },
  { "combination": "4", "amount": null, "label": null }
]
```

`label` は公式サイトの表記をそのまま格納します。上記2種類以外の文字列が入る可能性もあるため、値を固定で判定せず、`null` かどうかで分岐することを推奨します。

レースが中止・不開催の場合は、すべての賭式が空配列になります。
