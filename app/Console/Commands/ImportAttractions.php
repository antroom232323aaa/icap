<?php

namespace App\Console\Commands;

use App\Services\AttractionImportService;
use Illuminate\Console\Command;

class ImportAttractions extends Command
{
    /**
     * Artisan 指令
     */
    protected $signature = 'attractions:import';

    /**
     * 指令說明
     */
    protected $description = '匯入農村美食與農村住宿資料';


    /**
     * 執行匯入
     */
    public function handle(
        AttractionImportService $importService
    ): int {

        $this->info(
            '開始匯入農村旅遊資料...'
        );

        $this->newLine();

        try {

            // 執行資料匯入
            $result = $importService->import();

            // 顯示農村美食
            $this->info(
                '✓ 農村美食資料匯入完成'
            );

            $this->line(
                '  筆數：'
                    . $result['food']
            );

            $this->newLine();

            // 顯示農村住宿
            $this->info(
                '✓ 農村住宿資料匯入完成'
            );

            $this->line(
                '  筆數：'
                    . $result['stay']
            );

            $this->newLine();

            // 分隔線
            $this->line(
                '--------------------------------'
            );

            $this->info(
                '資料匯入完成！'
            );

            $this->line(
                '農村美食：'
                    . $result['food']
                    . ' 筆'
            );

            $this->line(
                '農村住宿：'
                    . $result['stay']
                    . ' 筆'
            );

            $this->line(
                '總計：'
                    . $result['total']
                    . ' 筆'
            );

            $this->line(
                '--------------------------------'
            );

            return Command::SUCCESS;
        } catch (\Throwable $e) {

            $this->newLine();

            $this->error(
                '資料匯入失敗：'
            );

            $this->error(
                $e->getMessage()
            );

            return Command::FAILURE;
        }
    }
}
