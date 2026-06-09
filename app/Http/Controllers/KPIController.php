<?php

namespace App\Http\Controllers;

use App\Enums\DataType;
use App\Models\Collect;
use App\Models\CollectData;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class KPIController extends Controller
{
    public function showDonorResult(Request $request, string $slug)
    {
        $validated = $request->validate([
            'user_uuid' => 'required|string',
            'collect.id' => 'required|exists:collects,id',
            'collect.appointment_link' => 'required|exists:collects,appointment_link',
        ]);

        $company = Company::where('slug', $slug)->with('collects')->first();

        if (! $company) {
            return to_route('home');
        }

        $companyDisplayData = [
            'name' => $company->company_name,
            'slug' => $company->slug,
            'primary_color' => $company->primary_color,
            'secondary_color' => $company->secondary_color,
            'logo_url' => $company->logo_url,
        ];

        return Inertia::render('Result', ['displayData' => $companyDisplayData, 'collect' => $validated['collect'], 'type' => 'donor']);
    }

    public function donorResult(Request $request, string $slug)
    {
        $validated = $request->validate([
            'user_uuid' => 'required|string',
            'collect.id' => 'required|exists:collects,id',
            'collect.appointment_link' => 'required|exists:collects,appointment_link',
        ]);

        $data = new CollectData(['session_id' => $validated['user_uuid'], 'data_type' => DataType::DONOR_RESULT]);
        $collect = Collect::with('data')->find($validated['collect']['id']);

        $existing = CollectData::where('collect_id', $validated['collect']['id'])->where('session_id', $validated['user_uuid'])->where('data_type', DataType::DONOR_RESULT)->orWhere('data_type', DataType::SUPPORTER_RESULT)->first();

        if (! $existing) {
            $collect->data()->save($data);
        }

        $company = Company::where('slug', $slug)->with('collects')->first();

        if (! $company) {
            return to_route('home');
        }

        $companyDisplayData = [
            'name' => $company->company_name,
            'slug' => $company->slug,
            'primary_color' => $company->primary_color,
            'secondary_color' => $company->secondary_color,
            'logo_url' => $company->logo_url,
        ];

        return Inertia::render('Result', ['displayData' => $companyDisplayData, 'collect' => $validated['collect'], 'type' => 'donor']);
    }

    public function showSupporterResult(Request $request, string $slug)
    {
        $validated = $request->validate([
            'user_uuid' => 'required|string',
            'collect.id' => 'required|exists:collects,id',
            'collect.appointment_link' => 'required|exists:collects,appointment_link',
        ]);

        $company = Company::where('slug', $slug)->with('collects')->first();

        if (! $company) {
            return to_route('home');
        }

        $companyDisplayData = [
            'name' => $company->company_name,
            'slug' => $company->slug,
            'primary_color' => $company->primary_color,
            'secondary_color' => $company->secondary_color,
            'logo_url' => $company->logo_url,
        ];

        return Inertia::render('Result', ['displayData' => $companyDisplayData, 'collect' => $validated['collect'], 'type' => 'supporter']);
    }

    public function supporterResult(Request $request, string $slug)
    {
        $validated = $request->validate([
            'user_uuid' => 'required|string',
            'collect.id' => 'required|exists:collects,id',
            'collect.appointment_link' => 'required|exists:collects,appointment_link',
        ]);

        $data = new CollectData(['session_id' => $validated['user_uuid'], 'data_type' => DataType::SUPPORTER_RESULT]);
        $collect = Collect::with('data')->find($validated['collect']['id']);

        $existing = CollectData::where('collect_id', $validated['collect']['id'])->where('session_id', $validated['user_uuid'])->where('data_type', DataType::DONOR_RESULT)->orWhere('data_type', DataType::SUPPORTER_RESULT)->first();

        if (! $existing) {
            $collect->data()->save($data);
        }

        $company = Company::where('slug', $slug)->with('collects')->first();

        if (! $company) {
            return to_route('home');
        }

        $companyDisplayData = [
            'name' => $company->company_name,
            'slug' => $company->slug,
            'primary_color' => $company->primary_color,
            'secondary_color' => $company->secondary_color,
            'logo_url' => $company->logo_url,
        ];

        return Inertia::render('Result', ['displayData' => $companyDisplayData, 'collect' => $validated['collect'], 'type' => 'supporter']);
    }

    public function appointmentClick(Request $request, string $slug)
    {
        $validated = $request->validate([
            'user_uuid' => 'required|string',
            'collect.id' => 'required|exists:collects,id',
            'collect.appointment_link' => 'required|exists:collects,appointment_link',
        ]);

        $data = new CollectData(['session_id' => $validated['user_uuid'], 'data_type' => DataType::APPOINTMENT_CLIC]);
        $collect = Collect::with('data')->find($validated['collect']['id']);

        $existing = CollectData::where('collect_id', $validated['collect']['id'])->where('session_id', $validated['user_uuid'])->where('data_type', DataType::APPOINTMENT_CLIC)->first();

        if (! $existing) {
            $collect->data()->save($data);
        }

        $company = Company::where('slug', $slug)->with('collects')->first();

        if (! $company) {
            return to_route('home');
        }

        return Inertia::location($validated['collect']['appointment_link']);
    }

    public function donorShare(Request $request, string $slug)
    {
        $validated = $request->validate([
            'user_uuid' => 'required|string',
            'collect.id' => 'required|exists:collects,id',
            'collect.appointment_link' => 'required|exists:collects,appointment_link',
        ]);

        $data = new CollectData(['session_id' => $validated['user_uuid'], 'data_type' => DataType::DONOR_SHARE]);
        $collect = Collect::with('data')->find($validated['collect']['id']);

        $existing = CollectData::where('collect_id', $validated['collect']['id'])->where('session_id', $validated['user_uuid'])->where('data_type', DataType::DONOR_SHARE)->first();

        if (! $existing) {
            $collect->data()->save($data);
        }

        $company = Company::where('slug', $slug)->with('collects')->first();

        if (! $company) {
            return to_route('home');
        }

        return to_route('donor');
    }

    public function supporterShare(Request $request, string $slug)
    {
        $validated = $request->validate([
            'user_uuid' => 'required|string',
            'collect.id' => 'required|exists:collects,id',
            'collect.appointment_link' => 'required|exists:collects,appointment_link',
        ]);

        $data = new CollectData(['session_id' => $validated['user_uuid'], 'data_type' => DataType::SUPPORTER_SHARE]);
        $collect = Collect::with('data')->find($validated['collect']['id']);

        $existing = CollectData::where('collect_id', $validated['collect']['id'])->where('session_id', $validated['user_uuid'])->where('data_type', DataType::SUPPORTER_SHARE)->first();

        if (! $existing) {
            $collect->data()->save($data);
        }

        $company = Company::where('slug', $slug)->with('collects')->first();

        if (! $company) {
            return to_route('home');
        }

        return to_route('supporter');
    }

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
