<?php

namespace ops\commands;

use App\Comment;
use App\Image;
use Illuminate\Console\Command;

class FixData extends Command
{
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct($cmd)
    {
        $this->cmd = $cmd;
    }

    public function run()
    {
        if ($this->cmd->argument('operation') == "tags") {
            return $this->cmd->fix_tags();
        }
        if ($this->cmd->argument('operation') == "comments") {
            return $this->cmd->fix_tags();
        }
        if ($this->cmd->argument('operation') == "articles") {
            return $this->cmd->fix_articles();
        }
        if ($this->cmd->argument('operation') == "images") {
            return $this->cmd->fix_images();
        }
        if ($this->cmd->argument('operation') == "videos") {
            return $this->cmd->fix_videos();
        }
        if ($this->cmd->argument('operation') == "categories") {
            return $this->cmd->fix_categories();
        }
        if ($this->cmd->argument('operation') == "users") {
            return $this->cmd->fix_users();
        }
    }

    public function fix_users()
    {
        // 今后，数据写到数据文件里，别堆代码里
    }

    public function fix_tags()
    {

    }

    public function fix_comments()
    {

    }

    public function fix_categories()
    {

    }

    public function fix_videos()
    {

    }

    public function fix_images()
    {
        $this->cmd->info('fix images ...');
        Image::orderBy('id')->chunk(100, function ($images) {
            foreach ($images as $image) {
                //服务器上图片不在本地的，都设置disk=hxb
                $image->hash = '';
                if (file_exists(public_path($image->path))) {
                    $image->hash = md5_file(public_path($image->path));
                    $image->disk = 'local';
                    $this->cmd->info($image->id . '  ' . $image->extension);
                } else {
                    $image->disk = 'hxb';
                    $this->cmd->comment($image->id . '  ' . $image->extension);
                }
                $image->save();
            }
        });
    }

    public function fix_articles()
    {

    }
}
