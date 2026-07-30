<?php

namespace App\Services;

use App\Models\Attraction;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AttractionImportService
{
    /**
     * 匯入所有旅遊資料
     */
    public function import(): array
    {
        return DB::transaction(function () {

            // 匯入農村美食
            $foodCount = $this->importFoodData();

            // 匯入農村住宿
            $stayCount = $this->importStayData();

            return [
                'food' => $foodCount,
                'stay' => $stayCount,
                'total' => $foodCount + $stayCount,
            ];
        });
    }


    /**
     * 匯入農村美食資料
     *
     * JSON：
     * TravelFood.json
     */
    private function importFoodData(): int
    {
        $count = 0;

        // 讀取 JSON
        $data = $this->readJson(
            'data/TravelFood.json'
        );

        // 建立或取得「農村美食」分類
        $category = Category::firstOrCreate([
            'name' => '農村美食',
        ]);

        // 將每筆資料寫入 attractions
        foreach ($data as $item) {

            Attraction::updateOrCreate(
                [
                    'category_id' => $category->id,

                    'name' => !empty($item['Name'])
                        ? trim($item['Name'])
                        : '未提供名稱',
                ],
                [
                    'city' => !empty($item['City'])
                        ? trim($item['City'])
                        : '未提供縣市',

                    'town' => !empty($item['Town'])
                        ? trim($item['Town'])
                        : '未提供鄉鎮',

                    'address' => !empty($item['Address'])
                        ? trim($item['Address'])
                        : '未提供地址',

                    'image' => !empty($item['PicURL'])
                        ? trim($item['PicURL'])
                        : '未提供圖片',

                    'description' => $this->cleanText(
                        $item['HostWords'] ?? null,
                        '未提供介紹'
                    ),

                    'feature' => $this->cleanText(
                        $item['FoodFeature'] ?? null,
                        '未提供美食特色'
                    ),

                    'website' => !empty($item['Url'])
                        ? trim($item['Url'])
                        : '未提供網站',
                ]
            );

            $count++;
        }

        return $count;
    }


    /**
     * 匯入農村住宿資料
     *
     * JSON：
     * TravelStay.json
     */
    private function importStayData(): int
    {
        $count = 0;

        // 讀取 JSON
        $data = $this->readJson(
            'data/TravelStay.json'
        );

        // 建立或取得「農村住宿」分類
        $category = Category::firstOrCreate([
            'name' => '農村住宿',
        ]);

        // 將每筆資料寫入 attractions
        foreach ($data as $item) {

            Attraction::updateOrCreate(
                [
                    'category_id' => $category->id,

                    'name' => !empty($item['Name'])
                        ? trim($item['Name'])
                        : '未提供名稱',
                ],
                [
                    'city' => !empty($item['County'])
                        ? trim($item['County'])
                        : '未提供縣市',

                    'town' => !empty($item['Town'])
                        ? trim($item['Town'])
                        : '未提供鄉鎮',

                    'address' => !empty($item['Address'])
                        ? trim($item['Address'])
                        : '未提供地址',

                    'image' => !empty($item['PhotoLink'])
                        ? trim($item['PhotoLink'])
                        : '未提供圖片',

                    'description' => $this->cleanText(
                        $item['HostWords'] ?? null,
                        '未提供介紹'
                    ),

                    'feature' => $this->cleanText(
                        $item['StayFeature'] ?? null,
                        '未提供住宿特色'
                    ),

                    'website' => !empty($item['Url'])
                        ? trim($item['Url'])
                        : '未提供網站',
                ]
            );

            $count++;
        }

        return $count;
    }


    /**
     * 讀取 JSON 檔案
     */
    private function readJson(string $path): array
    {
        // 確認檔案是否存在
        if (!Storage::exists($path)) {

            throw new \Exception(
                "找不到 JSON 檔案：{$path}"
            );
        }

        // 讀取 JSON 內容
        $json = Storage::get($path);

        // 將 JSON 轉換成 PHP Array
        $data = json_decode(
            $json,
            true
        );

        // 確認 JSON 格式是否正確
        if (json_last_error() !== JSON_ERROR_NONE) {

            throw new \Exception(
                "JSON 格式錯誤：{$path}"
            );
        }

        // 確認資料格式是 Array
        if (!is_array($data)) {

            throw new \Exception(
                "JSON 資料格式不是 Array：{$path}"
            );
        }

        return $data;
    }


    /**
     * 清洗 JSON 裡面的文字
     */
    private function cleanText(
        ?string $text,
        string $default = '未提供資料'
    ): string {

        if (empty($text)) {
            return $default;
        }

        $text = preg_replace(
            '/<br\s*\/?>/i',
            "\n",
            $text
        );

        $text = strip_tags($text);

        $text = trim($text);

        return $text !== ''
            ? $text
            : $default;
    }
}
