<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteInfo;
use App\Models\TeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SiteContentController extends Controller
{
    //! ====================================================================
    //! SITE INFO (statistics shown on the About page)
    //! ====================================================================
    public function siteInfoIndex()
    {
        $infos = SiteInfo::orderBy('sort_order')->paginate(15);
        return view('admin.pages.site_info', compact('infos'));
    }

    public function siteInfoCreate()
    {
        return view('admin.pages.edit_site_info', ['info' => null]);
    }

    public function siteInfoStore(Request $request)
    {
        $data = $this->validateInfo($request);
        $info = SiteInfo::create($data);

        // Immediately refresh the live stat value so it shows in the list right away
        SiteInfo::refreshLiveStats();

        return redirect()->route('admin.site_info')->with('success', 'Statistic added successfully.');
    }

    public function siteInfoEdit($id)
    {
        $info = SiteInfo::findOrFail($id);
        return view('admin.pages.edit_site_info', compact('info'));
    }

    public function siteInfoUpdate(Request $request, $id)
    {
        $info = SiteInfo::findOrFail($id);
        $data = $this->validateInfo($request);
        $info->update($data);
        return redirect()->route('admin.site_info')->with('success', 'Statistic updated successfully.');
    }

    public function siteInfoDestroy($id)
    {
        SiteInfo::findOrFail($id)->delete();
        return redirect()->route('admin.site_info')->with('success', 'Statistic deleted successfully.');
    }

    private function validateInfo(Request $request): array
    {
        $data = $request->validate([
            'key'        => 'required|string|max:50|regex:/^[a-z0-9_]+$/|unique:site_infos,key,' . ($request->route('id') ?? 'NULL') . ',id',
            'label'      => 'required|string|max:100',
            'icon'       => 'nullable|string|max:80',
            'sort_order' => 'nullable|integer|min:0',
            'is_visible' => 'nullable|boolean',
        ]);

        // 'value' is NOT accepted from the form — it's auto-imported every 24h.
        // If a row is being created, default to empty until first sync runs.
        $data['value'] = '';

        return $data + [
            'is_visible' => $request->boolean('is_visible'),
        ];
    }

    //! ====================================================================
    //! TEAM MEMBERS
    //! ====================================================================
    public function teamIndex()
    {
        $members = TeamMember::orderBy('sort_order')->paginate(15);
        return view('admin.pages.team_members', compact('members'));
    }

    public function teamCreate()
    {
        return view('admin.pages.edit_team_member', ['member' => null]);
    }

    public function teamStore(Request $request)
    {
        $data = $this->validateMember($request);
        $data['skills'] = $this->parseSkills($request->input('skills'));

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('team', 'public');
        }

        $data['departments'] = $request->input('departments')
            ? collect($request->input('departments'))->map(fn($d) => trim($d))->filter()->unique()->values()->all()
            : null;
        // Back-compat: keep the first department in the old column
        $data['department'] = $data['departments'][0] ?? null;

        TeamMember::create($data);
        return redirect()->route('admin.team_members')->with('success', 'Team member added successfully.');
    }

    public function teamEdit($id)
    {
        $member = TeamMember::findOrFail($id);
        return view('admin.pages.edit_team_member', compact('member'));
    }

    public function teamUpdate(Request $request, $id)
    {
        $member = TeamMember::findOrFail($id);
        $data = $this->validateMember($request);
        $data['skills'] = $this->parseSkills($request->input('skills'));

        if ($request->hasFile('image')) {
            // Delete the previous image to avoid orphaned files
            if ($member->image && Storage::disk('public')->exists($member->image)) {
                Storage::disk('public')->delete($member->image);
            }
            $data['image'] = $request->file('image')->store('team', 'public');
        }

        $data['status'] = $request->boolean('status');
        $data['departments'] = $request->input('departments')
            ? collect($request->input('departments'))->map(fn($d) => trim($d))->filter()->unique()->values()->all()
            : null;
        $data['department'] = $data['departments'][0] ?? null;
        $member->update($data);
        return redirect()->route('admin.team_members')->with('success', 'Team member updated successfully.');
    }

    public function teamDestroy($id)
    {
        $member = TeamMember::findOrFail($id);
        if ($member->image && Storage::disk('public')->exists($member->image)) {
            Storage::disk('public')->delete($member->image);
        }
        $member->delete();
        return redirect()->route('admin.team_members')->with('success', 'Team member deleted successfully.');
    }

    private function validateMember(Request $request): array
    {
        return $request->validate([
            'name'         => 'required|string|max:120',
            'role'         => 'required|string|max:120',
            'departments'  => 'required|array|min:1',
            'departments.*'=> 'string|in:Leadership,Engineering,Design,Operations,Support,Marketing,Sales',
            'bio'          => 'nullable|string|max:2000',
            'image'        => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'email'        => 'nullable|email|max:191',
            'twitter'      => 'nullable|url|max:500',
            'linkedin'     => 'nullable|url|max:500',
            'github'       => 'nullable|url|max:500',
            'sort_order'   => 'nullable|integer|min:0',
        ]);
    }

    private function parseSkills(?string $raw): array
    {
        if (!$raw) return [];
        return collect(preg_split('/[,\n]+/', $raw))
            ->map(fn($s) => trim($s))
            ->filter()
            ->values()
            ->all();
    }
}
