<?php

namespace  Modules\Admin\Compound\Repositories;

use Modules\Admin\Compound\Entities\Compound;
use Illuminate\Support\Facades\DB;

/**
 * Class CompoundRepository
 * @package  Modules\Admin\Compound\Repositories
 *
 */
class CompoundRepository
{
    /**
     * @var array
     */

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Compound::class;
    }


    function create($request)
    {
        DB::beginTransaction();

        $data    = $request->only(['name', 'construction_status', 'description', 'lat', 'lang', 'address', 'developer_id', 'area_id']);

        $compound = Compound::updateOrCreate(['id' => $request['id'] ?? Null], $data);

        $compound->files()->attach($request->images_ids, ['type' => 'IMAGES']);

        $compound->files()->attach($request->videos_ids, ['type' => 'VIDEOS']);

        $compound->facilities()->attach($request->facilities_ids);
        DB::commit();
        return $compound->id;
    }
    function update($request, $id)
    {

        $data    = $request->only(['name', 'construction_status', 'description', 'lat', 'lang', 'address', 'developer_id', 'area_id']);

        $compound = Compound::where('id', $id)->first();
        if (!empty($compound)) {
            DB::beginTransaction();

            $compound->update($data);
            $compound->files()->detach($compound->images()->pluck('media.id')->toArray());
            $compound->files()->attach($request->images_ids, ['type' => 'IMAGES']);

            $compound->files()->detach($compound->videos()->pluck('media.id')->toArray());
            $compound->files()->attach($request->videos_ids, ['type' => 'VIDEOS']);

            $compound->facilities()->sync($request->facilities_ids);
            DB::commit();
            return $compound->id;
        } else {
            throw new \Exception("Compound Not Found !", 400);
        }
    }
}
