# AI Travel Guide

> AI 輔助台灣農村旅遊景點探索平台  
> 提供農村美食、農村住宿景點的搜尋、篩選、排序、詳細資訊與統計功能。

---

## 1. 專題名稱

### AI Travel Guide

本專題以台灣農村旅遊為主題，整合農村美食與農村住宿資料，建立可供使用者探索景點的旅遊網站。

📷 **截圖位置：專題首頁／網站名稱**

![專題首頁](docs/screenshots/01-project-name.png)

---

## 2. 專題簡介

AI Travel Guide 是一個以台灣農村旅遊為主題的網站，使用者可以瀏覽各地農村美食與住宿景點，透過關鍵字、城市與分類進行搜尋與篩選，也可以依照不同欄位進行排序及分頁瀏覽。

網站另外提供單一景點詳細資訊、景點統計圖表，以及後台景點管理功能。

📷 **截圖位置：首頁完整畫面**

![專題簡介](docs/screenshots/02-project-introduction.png)

---

## 3. 使用技術

| 類別 | 技術 |
|---|---|
| Backend | Laravel 12 |
| Programming Language | PHP 8.2+ |
| Frontend | Blade、HTML、CSS、JavaScript |
| UI Framework | Bootstrap 5.3.3 |
| JavaScript Library | jQuery 4.0.0 |
| HTTP Client | Axios |
| Alert | SweetAlert2 |
| Chart | Chart.js、Chart.js DataLabels |
| Database | SQLite |
| ORM | Laravel Eloquent |
| API | Laravel REST API |
| Build Tool | Vite |
| Version Control | Git / GitHub |

📷 **截圖位置：專案技術／網站開發畫面**

![使用技術](docs/screenshots/03-technology.png)

---

## 4. 系統功能說明

### 4.1 首頁

首頁提供：

- Hero 主視覺
- AI 圖像素材
- 精選景點輪播(左右切換、自動播放、指示點)
- 農村美食介紹
- 農村住宿介紹
- 景點導覽按鈕

📷 **截圖位置：首頁**

![首頁](docs/screenshots/04-home.png)

---

### 4.2 景點列表

景點列表透過 API 取得資料，並以卡片方式呈現景點資訊。

每張景點卡片包含：

- 景點圖片
- 景點名稱
- 城市／地區
- 景點分類
- 景點簡介
- 查看詳細資訊按鈕

📷 **截圖位置：景點列表**

![景點列表](docs/screenshots/05-attraction-list.png)

---

### 4.3 搜尋與篩選

景點列表提供：

- 關鍵字搜尋
- 城市／地區篩選
- 景點分類篩選
- 排序欄位
- 升冪／降冪
- 每頁顯示筆數
- 分頁

關鍵字搜尋會搜尋：

- 景點名稱
- 地址
- 景點介紹
- 景點特色

📷 **截圖位置：搜尋／篩選區**

![搜尋與篩選](docs/screenshots/06-search-filter.png)

---

### 4.4 單一景點詳細資訊

使用者可以進入單一景點頁面查看：

- 景點圖片
- 景點名稱
- 景點分類
- 城市／地區
- 地址
- 景點特色
- 官方網站

頁面資料透過 API 動態取得。

📷 **截圖位置：單一景點頁**

![單一景點](docs/screenshots/07-attraction-detail.png)

---

### 4.5 統計圖表

統計頁透過 `/api/statistics` 取得各縣市農村美食與農村住宿景點數量，使用 Chart.js 製作長條圖。

兩張圖使用相同的 Y 軸最大值，並依資料最大值計算為 5 的倍數，使兩張圖能夠直接比較。

X 軸會依畫面寬度即時調整文字大小與排列方向，以維持 RWD 顯示效果。

📷 **截圖位置：統計頁**

![統計圖表](docs/screenshots/08-statistics.png)

---

### 4.6 後台景點管理

後台提供景點管理相關功能，包括：

- 景點列表
- 新增景點
- 編輯景點
- 刪除景點
- 表單驗證
- SweetAlert2 操作提示

📷 **截圖位置：後台景點管理**

![後台管理](docs/screenshots/09-admin.png)

---

## 5. 資料庫設計

本專案使用 SQLite 儲存景點資料。

主要資料表：

### categories

| 欄位 | 說明 |
|---|---|
| id | 分類編號 |
| name | 分類名稱 |
| created_at | 建立時間 |
| updated_at | 更新時間 |

### attractions

| 欄位 | 說明 |
|---|---|
| id | 景點編號 |
| category_id | 景點分類 |
| name | 景點名稱 |
| city | 城市／縣市 |
| town | 鄉鎮市區 |
| address | 地址 |
| image | 景點圖片 |
| description | 景點介紹 |
| feature | 景點特色 |
| website | 官方網站 |
| created_at | 建立時間 |
| updated_at | 更新時間 |

### Model Relationship

```text
Category
   │
   │ hasMany
   ▼
Attraction

Attraction
   │
   │ belongsTo
   ▼
Category
```

資料庫透過 `category_id` 建立分類與景點的一對多關係。

📷 **截圖位置：資料庫 Schema／ERD／資料表**

![資料庫設計](docs/screenshots/10-database.png)

---

## 6. API 說明

| Method | API | 功能 | 成功狀態碼 | 主要用途 |
|---|---|---|---|---|
| GET | `/api/attractions` | 景點列表 | 200 | 景點查詢、搜尋、篩選、排序、分頁 |
| GET | `/api/attractions/{id}` | 景點詳細資訊 | 200 | 取得指定景點 |
| POST | `/api/attractions` | 新增景點 | 201 | 建立景點資料 |
| PUT | `/api/attractions/{id}` | 修改景點 | 200 | 更新景點資料 |
| DELETE | `/api/attractions/{id}` | 刪除景點 | 200 | 刪除景點資料 |
| GET | `/api/statistics` | 景點統計 | 200 | 取得各縣市美食與住宿數量 |

### 景點列表 API 補充

```http
GET /api/attractions
```

用途：

- 取得景點列表
- 關鍵字搜尋
- 城市篩選
- 分類篩選
- 排序
- 分頁
- 首頁隨機精選景點

可使用的查詢參數：

| Parameter | 說明 |
|---|---|
| keyword | 關鍵字 |
| city | 城市／地區 |
| category_id | 景點分類 |
| sort | 排序欄位 |
| direction | asc / desc |
| per_page | 每頁筆數 |
| page | 頁碼 |
| random | 是否取得隨機精選景點 |


### API Response 格式

API 統一使用 JSON 回傳資料，例如：

```json
{
    "status": "success",
    "message": "景點取得成功",
    "data": {},
    "code": 200
}
```

### API 資料傳遞方式

```text
使用者操作網頁
       ↓
Blade 頁面
       ↓
JavaScript / jQuery
       ↓
Axios
       ↓
Laravel API
       ↓
Controller
       ↓
Eloquent Model
       ↓
SQLite Database
       ↓
JSON Response
       ↓
JavaScript 更新畫面
```

📷 **截圖位置：Postman／瀏覽器 Network／API JSON Response**

![API 測試](docs/screenshots/11-api.png)

---

## 7. 資料來源

本專案使用農村旅遊相關開放資料建立景點資料。

目前專案中的主要資料檔案：

```text
storage/app/private/data/TravelFood.json
storage/app/private/data/TravelStay.json
```

其中：

- `TravelFood.json`：農村美食資料
- `TravelStay.json`：農村住宿資料

匯入後將資料整理至 SQLite 的 `attractions` 與 `categories` 資料表。

📷 **截圖位置：原始資料／JSON 資料**

![資料來源](docs/screenshots/12-data-source.png)

---

## 8. AI 功能說明

本專案使用 AI 輔助製作網站所使用的圖像素材。

目前實際使用於網站的 AI 圖像素材包括：

- 首頁主視覺 Banner
- 農村美食圖片
- 農村住宿圖片

這些圖像素材實際放入首頁及相關內容區塊中，作為網站視覺設計的一部分。

📷 **截圖位置：AI 圖像素材與實際網站使用畫面**

![AI 圖像素材](docs/screenshots/13-ai-image.png)

---

## 9. UI / RWD 設計

網站使用 Bootstrap 5.3.3 搭配自訂 CSS 進行版面設計。

整體視覺以：

- 農村自然感的綠色系
- 淺色背景
- 卡片式資訊呈現
- 圓角元件
- 清楚的主要操作按鈕

為主要設計方向。

網站主要頁面皆有進行 RWD 調整，包括：

- Navbar
- 首頁 Hero
- Carousel
- 景點卡片
- 搜尋／篩選區
- 統計圖表
- 景點詳細頁

📷 **截圖位置：Desktop**

![Desktop RWD](docs/screenshots/14-rwd-desktop.png)

📷 **截圖位置：Mobile**

![Mobile RWD](docs/screenshots/15-rwd-mobile.png)

---

## 10. A6 介面設計

本專案使用介面設計工具製作首頁與景點列表頁設計稿。

設計稿包含：

- 導覽列
- 首頁主視覺區
- 景點卡片
- 主要按鈕
- 搜尋／篩選區
- 內容區塊
- AI 圖像素材

📷 **截圖位置：Figma 首頁設計稿**

![Figma 首頁](docs/screenshots/16-figma-home.png)

📷 **截圖位置：Figma 景點列表設計稿**

![Figma 景點列表](docs/screenshots/17-figma-attractions.png)

### Figma 設計稿

> **Figma Link：〔請填入 Figma 設計稿連結〕**

---

## 11. Git / GitHub

本專案使用 Git 進行版本控制，並建立 GitHub Repository 管理專案。

### GitHub Repository

https://github.com/antroom232323aaa/icap

📷 **截圖位置：GitHub Repository**

![GitHub Repository](docs/screenshots/18-github-repository.png)

---

## 12. 測試結果

以下整理專案開發過程中的功能測試結果。

### 測試 1：關鍵字搜尋

**測試方式：**

輸入景點名稱、地址、介紹或特色相關關鍵字後進行搜尋。

**預期結果：**

列表只顯示符合搜尋條件的景點。

**測試結果：**

✅ 通過

📷 **截圖位置：關鍵字搜尋測試**

![搜尋測試](docs/screenshots/19-test-search.png)

---

### 測試 2：排序功能

**測試方式：**

切換排序欄位及升冪／降冪。

**預期結果：**

景點列表依指定欄位及方向重新排序。

**測試結果：**

✅ 通過

此外，當排序欄位的值相同時，使用景點 ID 作為第二排序條件，以確保排序結果穩定。

📷 **截圖位置：排序測試**

![排序測試](docs/screenshots/20-test-sort.png)

---

### 測試 3：不存在的景點 ID

**測試方式：**

請求不存在的景點 ID。

**預期結果：**

API 回傳 HTTP 404，前端顯示找不到指定景點的提示。

**測試結果：**

✅ 通過

📷 **截圖位置：404 API 測試**

![404 測試](docs/screenshots/21-test-404.png)

---

### 測試 4：統計圖表

**測試方式：**

取得統計 API 資料並載入統計頁。

**預期結果：**

正確顯示農村美食與農村住宿各縣市數量，並能隨畫面寬度調整 X 軸文字。

**測試結果：**

✅ 通過

📷 **截圖位置：統計圖表測試**

![統計測試](docs/screenshots/22-test-statistics.png)

---

## 13. 開發者資訊

### 開發者

> **姓名：〔請填入〕**  
> **學號：〔請填入〕**  
> **班級／系所：〔請填入〕**

📷 **截圖位置：開發者資訊／GitHub 個人頁面**

![開發者資訊](docs/screenshots/23-developer.png)

---

## 14. 專案安裝與執行

### 1. Clone Repository

```bash
git clone https://github.com/antroom232323aaa/icap.git
cd icap
```

### 2. 安裝 PHP 套件

```bash
composer install
```

### 3. 建立環境設定

```bash
cp .env.example .env
```

Windows 可直接複製 `.env.example` 並重新命名為 `.env`。

### 4. 建立 Application Key

```bash
php artisan key:generate
```

### 5. 建立 SQLite Database

建立：

```text
database/database.sqlite
```

並確認 `.env`：

```env
DB_CONNECTION=sqlite
```

### 6. 執行 Migration

```bash
php artisan migrate
```

### 7. 安裝前端套件

```bash
npm install
```

### 8. 啟動 Vite

```bash
npm run dev
```

### 9. 啟動 Laravel

```bash
php artisan serve
```

完成後即可透過瀏覽器開啟：

```text
http://127.0.0.1:8000
```

---

## 15. 專案主要頁面

| 頁面 | URL |
|---|---|
| 首頁 | `/` |
| 景點列表 | `/attractions` |
| 景點詳細資訊 | `/attractions/{id}` |
| 景點統計 | `/statistics` |
| 後台景點管理 | `/admin/attractions` |

---

## 16. 專案目錄概要

```text
icap/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   └── Models/
├── database/
│   └── migrations/
├── public/
│   ├── css/
│   └── images/
├── resources/
│   └── views/
├── routes/
│   ├── api.php
│   └── web.php
├── storage/
│   └── app/
│       └── private/
│           └── data/
├── tests/
├── composer.json
├── package.json
└── README.md
```

---

## 17. License

本專案為課程／專題用途之網站作品。
