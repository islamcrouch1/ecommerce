<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Field;
use App\Models\Stage;
use Illuminate\Http\Request;

class StagesController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:superadministrator|administrator');
        $this->middleware('permission:stages-read')->only('index', 'show');
        $this->middleware('permission:stages-create')->only('create', 'store');
        $this->middleware('permission:stages-update')->only('edit', 'update');
        $this->middleware('permission:stages-delete|stages-trash')->only('destroy', 'trashed');
        $this->middleware('permission:stages-restore')->only('restore');
    }


    public function index()
    {
        $stages = Stage::whenSearch(request()->search)
            ->latest()
            ->paginate(100);


        return view('dashboard.stages.index', compact('stages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.stages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $request->validate([
            'name_ar' => "required|string|max:255|unique:stages",
            'name_en' => "required|string|max:255|unique:stages",
            'score' => "required|numeric",
            'type' => "required|array",
            'level' => "required|array",
            'field_name_ar' => "required|array",
            'field_name_en' => "required|array",
            'field_score' => "required|array",
            'is_required' => "required|array",
            'options' => "required|array",
        ]);

        $stage = Stage::create([
            'name_ar' => $request['name_ar'],
            'name_en' => $request['name_en'],
            'score' => $request['score'],
        ]);

        $score = 0;


        foreach ($request->type as $index => $type) {


            if (isset($request['is_required'][$request['level'][$index]])) {
                $is_required = '1';
            } else {
                $is_required = '0';
            }

            $field = Field::create([
                'stage_id' => $stage->id,
                'type' => $request['type'][$index],
                'name_ar' => $request['field_name_ar'][$index],
                'name_en' => $request['field_name_en'][$index],
                'score' => $request['field_score'][$index],
                'is_required' => $is_required,
                'data' => implode(',', $request['options'][$request['level'][$index]])
            ]);

            $score += $request['field_score'][$index];
        }


        $stage->update([
            'total_score' => $score,
        ]);


        alertSuccess('stage created successfully', 'تم اضافة المرحلة بنجاح');
        return redirect()->route('stages.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($stage)
    {
        $stage = Stage::findOrFail($stage);
        return view('dashboard.stages.edit ', compact('stage'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, stage $stage)
    {


        $request->validate([
            'name_ar' => "required|string|max:255|unique:stages,name_ar," . $stage->id,
            'name_en' => "required|string|max:255|unique:stages,name_en," . $stage->id,
            'score' => "required|numeric",
            'type' => "required|array",
            'level' => "required|array",
            'field_name_ar' => "required|array",
            'field_name_en' => "required|array",
            'field_score' => "required|array",
            'is_required' => "required|array",
            'options' => "required|array",
            'field_id' => "required|array",
        ]);


        $stage->update([
            'name_ar' => $request['name_ar'],
            'name_en' => $request['name_en'],
            'score' => $request['score'],
        ]);

        // foreach ($stage->fields as $filed) {
        //     $filed->delete();
        // }

        $fields = $stage->fields->pluck('id')->toArray();

        $score = 0;

        foreach ($request->type as $index => $type) {

            if (isset($request['is_required'][$request['level'][$index]])) {
                $is_required = '1';
            } else {
                $is_required = '0';
            }

            $field = $stage->fields->where('id', isset($request->field_id[$index]) ? $request->field_id[$index] : null)->first();

            if ($field != null) {
                $field->update([
                    'name_ar' => $request['field_name_ar'][$index],
                    'name_en' => $request['field_name_en'][$index],
                    'score' => $request['field_score'][$index],
                    'is_required' => $is_required,
                    'data' => implode(',', $request['options'][$request['level'][$index]])
                ]);
                unset($fields[array_search($field->id, $fields)]);
            } else {
                $field = Field::create([
                    'stage_id' => $stage->id,
                    'type' => $request['type'][$index],
                    'name_ar' => $request['field_name_ar'][$index],
                    'name_en' => $request['field_name_en'][$index],
                    'score' => $request['field_score'][$index],
                    'is_required' => $is_required,
                    'data' => implode(',', $request['options'][$request['level'][$index]])
                ]);
            }

            $score += $request['field_score'][$index];
        }

        foreach ($fields as $index => $field) {
            $stage->fields->where('id', $field)->first()->delete();
        }


        $stage->update([
            'total_score' => $score,
        ]);


        alertSuccess('stage updated successfully', 'تم تعديل المرحلة بنجاح');
        return redirect()->route('stages.index');
    }






    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($stage)
    {
        $stage = Stage::withTrashed()->where('id', $stage)->first();
        if ($stage->trashed() && auth()->user()->hasPermission('stages-delete')) {

            $stage->forceDelete();
            alertSuccess('stage deleted successfully', 'تم حذف المرحلة بنجاح');
            return redirect()->route('stages.trashed');
        } elseif (!$stage->trashed() && auth()->user()->hasPermission('stages-trash') && checkStageForTrash($stage)) {
            $stage->delete();
            alertSuccess('stage trashed successfully', 'تم حذف المرحلة مؤقتا');
            return redirect()->route('stages.index');
        } else {
            alertError('Sorry, you do not have permission to perform this action, or the stage cannot be deleted at the moment', 'نأسف ليس لديك صلاحية للقيام بهذا الإجراء ، أو المرحلة لا يمكن حذفها حاليا');
            return redirect()->back()->withInput();
        }
    }


    public function trashed()
    {
        $stages = Stage::onlyTrashed()
            ->whenSearch(request()->search)
            ->paginate(100);
        return view('dashboard.stages.index', ['stages' => $stages]);
    }

    public function restore($stage)
    {
        $stage = Stage::withTrashed()->where('id', $stage)->first()->restore();
        alertSuccess('stage restored successfully', 'تم استعادة المرحلة بنجاح');
        return redirect()->route('stages.index');
    }
}
