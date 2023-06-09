<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShortenedUrl;
use Illuminate\Support\Facades\DB;


class UrlShortenerController extends Controller
{
    public function index()
    {
        return view('url-shortener');
    }

    public function store(Request $request)
    {
        $request->validate([
            'url' => 'required|url|max:255',
        ]);

        $originalUrl = $request->input('url');

        $shortCode = $this->generateShortCode();

        $shortenedUrl = ShortenedUrl::create([
            'original_url' => $originalUrl,
            'short_code' => $shortCode,
            'click_count' => 0,
        ]);

        return response()->json(['shortUrl' => route('redirect', $shortCode)]);
    }

    public function redirect($shortCode)
    {
        $shortenedUrl = ShortenedUrl::where('short_code', $shortCode)->firstOrFail();

        $shortenedUrl->increment('click_count');

        return redirect($shortenedUrl->original_url);
    }

    private function generateShortCode()
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $codeLength = 6;
        $shortCode = '';

        for ($i = 0; $i < $codeLength; $i++) {
            $shortCode .= $characters[rand(0, strlen($characters) - 1)];
        }

        return $shortCode;
    }

    public function urls(Request $request)
    {
        try {
            $perPage = $request->query('rowsPerPage', 10);
            $page = $request->query('page', 1);

            $stats = DB::table('shortened_urls')
                ->select('original_url', 'short_code', 'click_count', 'id')
                ->orderBy('click_count', 'desc')
                ->paginate($perPage, ['*'], 'page', $page);

            return response()->json([
                'shortenedUrls' => $stats->items(),
                'meta' => [
                    'current_page' => $stats->currentPage(),
                    'last_page' => $stats->lastPage(),
                ],
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error',
                'error' => $th->getMessage()
            ], 500);
        }


    }
}