<?php

namespace App\Http\Controllers;

use App\Models\Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use League\CommonMark\Extension\CommonMark\Node\Inline\Strong;
use Illuminate\Support\Facades\Artisan;

class ConfigController extends Controller
{
    public function index()
    {
        $config = Config::find(1);
        return view('pages.config.config', compact('config'));
    }

    public function update(Request $request)
    {

        $config = Config::find(1);
        $config->wa_admin = $request->wa_admin;
        $config->save();

        return redirect(route('config'))->withSuccess('Config updated successfully.');
    }

    // Backup
    public function index_backup()
    {
        function formatBytesForHumans($bytes): string
        {
            if ($bytes >= 1073741824) {
                $bytes = number_format($bytes / 1073741824, 2) . ' GB';
            } elseif ($bytes >= 1048576) {
                $bytes = number_format($bytes / 1048576, 2) . ' MB';
            } elseif ($bytes >= 1024) {
                $bytes = number_format($bytes / 1024, 2) . ' KB';
            } elseif ($bytes > 1) {
                $bytes = $bytes . ' bytes';
            } elseif ($bytes == 1) {
                $bytes = $bytes . ' byte';
            } else {
                $bytes = '0 bytes';
            }

            return $bytes;
        }

        $files = collect(Storage::disk('file_backup')->allFiles());

        $files = $files->map(function ($item, $key) {
            return [
                'file' => $item,
                'size' => formatBytesForHumans(Storage::disk('file_backup')->size($item))
            ];
        });
        return view('pages.backup.backup', compact('files'));
    }

    public function download_backup($backup)
    {

        return Storage::disk('file_backup')->download($backup);
    }
    public function backup_process()
    {
        Artisan::call('backup:run --only-files --only-to-disk=file_backup');
        return redirect()->back();
    }
}
