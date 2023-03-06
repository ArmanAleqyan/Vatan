<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class FfmpegConversion implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $filesname;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $filesname)
    {
        $this->filesname = $filesname;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $command = "ffmpeg -i /var/www/vatan/data/www/dev.vatan.su/public_html/public/uploads/NewVideo/{$this->filesname} /var/www/vatan/data/www/dev.vatan.su/public_html/public/uploads/{$this->filesname}";
        exec($command);
        $image_path = "uploads/NewVideo/".$this->filesname;  // Value is not URL but directory file path
        if(file_exists($image_path)){
            unlink($image_path);
        }
    }
}
