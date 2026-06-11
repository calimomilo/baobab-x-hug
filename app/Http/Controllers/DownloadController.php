<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{
    public function downloadDonorKit()
    {
        abort_unless(Storage::disk('local')->exists('kits/kit-donneur.zip'), 404);

        return Storage::disk('local')->download(
            'kits/kit-donneur.zip',
            'kit-communication-donneur.zip'
        );
    }

    public function downloadSupporterKit()
    {
        abort_unless(Storage::disk('local')->exists('kits/kit-supporter.zip'), 404);

        return Storage::disk('local')->download(
            'kits/kit-supporter.zip',
            'kit-communication-supporter.zip'
        );
    }
}
