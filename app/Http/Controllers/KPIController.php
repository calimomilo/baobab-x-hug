<?php

namespace App\Http\Controllers;

use App\Enums\DataType;
use App\Models\Collect;
use App\Models\CollectData;
use Illuminate\Http\Request;

class KPIController extends Controller
{
    public function donorResult(Request $request, string $slug)
    {
        $validated = $request->validate([
            'user_uuid' => 'required|string',
            'collect.id' => 'required|exists:collects,id',
        ]);

        $data = new CollectData(['session_id' => $validated['user_uuid'], 'data_type' => DataType::DONOR_RESULT]);
        $collect = Collect::with('data')->find($validated['collect']['id']);

        $existing = CollectData::where('collect_id', $validated['collect']['id'])->where('session_id', $validated['user_uuid'])->where('data_type', DataType::DONOR_RESULT)->orWhere('data_type', DataType::SUPPORTER_RESULT)->first();

        if (! $existing) {
            $collect->data()->save($data);
        }

        return to_route('donor', ['slug' => $slug, 'id' => $collect->id]);
    }

    public function supporterResult(Request $request, string $slug)
    {
        $validated = $request->validate([
            'user_uuid' => 'required|string',
            'collect.id' => 'required|exists:collects,id',
        ]);

        $data = new CollectData(['session_id' => $validated['user_uuid'], 'data_type' => DataType::SUPPORTER_RESULT]);
        $collect = Collect::with('data')->find($validated['collect']['id']);

        $existing = CollectData::where('collect_id', $validated['collect']['id'])->where('session_id', $validated['user_uuid'])->where('data_type', DataType::DONOR_RESULT)->orWhere('data_type', DataType::SUPPORTER_RESULT)->first();

        if (! $existing) {
            $collect->data()->save($data);
        }

        return to_route('supporter', ['slug' => $slug, 'id' => $collect->id]);
    }

    public function appointmentClick(Request $request, string $slug)
    {
        $validated = $request->validate([
            'user_uuid' => 'required|string',
            'collect.id' => 'required|exists:collects,id',
        ]);

        $data = new CollectData(['session_id' => $validated['user_uuid'], 'data_type' => DataType::APPOINTMENT_CLIC]);
        $collect = Collect::with('data')->find($validated['collect']['id']);

        $existing = CollectData::where('collect_id', $validated['collect']['id'])->where('session_id', $validated['user_uuid'])->where('data_type', DataType::APPOINTMENT_CLIC)->first();

        if (! $existing) {
            $collect->data()->save($data);
        }
    }

    public function donorShare(Request $request, string $slug)
    {
        $validated = $request->validate([
            'user_uuid' => 'required|string',
            'collect.id' => 'required|exists:collects,id',
        ]);

        $data = new CollectData(['session_id' => $validated['user_uuid'], 'data_type' => DataType::DONOR_SHARE]);
        $collect = Collect::with('data')->find($validated['collect']['id']);

        $existing = CollectData::where('collect_id', $validated['collect']['id'])->where('session_id', $validated['user_uuid'])->where('data_type', DataType::DONOR_SHARE)->first();

        if (! $existing) {
            $collect->data()->save($data);
        }
    }

    public function supporterShare(Request $request, string $slug)
    {
        $validated = $request->validate([
            'user_uuid' => 'required|string',
            'collect.id' => 'required|exists:collects,id',
        ]);

        $data = new CollectData(['session_id' => $validated['user_uuid'], 'data_type' => DataType::SUPPORTER_SHARE]);
        $collect = Collect::with('data')->find($validated['collect']['id']);

        $existing = CollectData::where('collect_id', $validated['collect']['id'])->where('session_id', $validated['user_uuid'])->where('data_type', DataType::SUPPORTER_SHARE)->first();

        if (! $existing) {
            $collect->data()->save($data);
        }
    }
}
