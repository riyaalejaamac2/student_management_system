<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin')->except(['index']);
    }

    /**
     * Display the settings form.
     */
    public function index(): View
    {
        $settings = Schema::hasTable('settings')
            ? (Setting::first() ?? new Setting(Setting::defaults()))
            : new Setting(Setting::defaults());

        return view('settings.index', compact('settings'));
    }

    /**
     * Persist settings to storage.
     */
    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'site_name' => ['required', 'string', 'max:255'],
            'system_email' => ['nullable', 'email', 'max:255'],
            'contact_phone' => ['nullable', 'string', 'max:50'],
            'academic_year' => ['nullable', 'string', 'max:50'],
        ]);

        if (! Schema::hasTable('settings')) {
            return redirect()
                ->route('settings.index')
                ->with('success', 'Settings will be stored once migrations are executed.');
        }

        $settings = Setting::first();

        if ($settings === null) {
            Setting::create($data);
        } else {
            $settings->update($data);
        }

        return redirect()
            ->route('settings.index')
            ->with('success', 'Settings updated successfully.');
    }
}

