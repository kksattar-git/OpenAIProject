<?php

namespace App\Http\Controllers;

use App\Models\Insight;
use App\Services\OpenAiService;
use Illuminate\Http\Request;

class LogController extends Controller
{
    protected $openAiService;

    public function __construct(OpenAiService $openAiService)
    {
        $this->openAiService = $openAiService;
    }

    public function summarize(Request $request)
    {
        $request->validate([
            'log_data' => 'required|string',
        ]);

        $logData = $request->input('log_data');
        $aiResponse = $this->openAiService->summarizeLogs($logData);

        // Store the result
        Insight::create([
            'type' => 'summarize_logs',
            'input_data' => $logData,
            'ai_response' => $aiResponse
        ]);

        return view('result', compact('logData', 'aiResponse'));
    }

    public function history()
    {
        $insights = Insight::all();
        return view('history', compact('insights'));
    }
}
