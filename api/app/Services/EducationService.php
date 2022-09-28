<?php

namespace App\Services;

use App\Exceptions\GeneralException;
use App\Models\Cv;
use App\Models\Education;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * Class EducationService.
 */
class EducationService extends BaseService
{
    public $request;

    /**
     * EducationService constructor.
     *
     * @param  Education  $education
     * @param  Request  $request
     */
    public function __construct(Education $education, Request $request)
    {
        $this->model = $education;
        $this->request = $request;
    }


    /**
     * @param  array  $data
     * @param  Cv  $cv
     *
     * @return array
     */
    public function update(array $data = [], Cv $cv): array
    {
        $cvEducations = [];
        if($data) {
            foreach($data as $input) {

                if(isset($input['id']) && $input['id']) {
                    $arrEducation = [
                        'institution_name' => $input["institution_name"],
                        'period_from' => $cv->formatDate($input["period_from"]),
                        'period_to' => $cv->formatDate($input["period_to"]),
                        'faculty' => $input["faculty"],
                        'summary' => $input["summary"],
                        'website' => $input["website"],
                        'updated_at' => date("Y-m-d H:i:s", time())
                    ];
                    $arrEducation = array_filter( $arrEducation, 'strlen' );// "update on patch", remove empty values from arr
                    $cvEducations[] = Education::where('id', $input['id'])->update($arrEducation);
                } else {
                    $cvEducations[] = Education::create([
                        'institution_name' => $input["institution_name"],
                        'period_from' => $cv->formatDate($input["period_from"]),
                        'period_to' => $cv->formatDate($input["period_to"]),
                        'faculty' => $input["faculty"],
                        // 'address' => $input["address"],
                        'summary' => $input["summary"],
                        'website' => $input["website"],
                        'cv_id' => $cv->id,
                    ]);
                }
            }
        }
        return $cvEducations;
    }


    /**
     * @param  array  $data
     *
     * @return void
     */
    public function delete(array $data = [])
    {
        if($data) {
            // make 'unique' to eliminate bugs from client
            $aDeletedEducations = array_unique($data);
            // remove empty
            if (($key = array_search('', $aDeletedEducations)) !== false) {
                unset($aDeletedEducations[$key]);
            }
            // delete
            $deleted = Education::whereIn('id', $aDeletedEducations)->delete();
        }
    }


    /**
     * @param  array  $data
     * @param  Cv  $cv
     *
     * @return array
     */
    public function create(array $data = [], Cv $cv) : array
    {
        $cvEducations = [];
        if($data) {
            foreach($data as $k => $v) {
                $cvEducations[] = Education::create([
                    'institution_name' => $this->request->input("cvEducations.".$k.".institution_name"),
                    'period_from' => $cv->setDateAttribute($this->request->input("cvEducations.".$k.".period_from")),
                    'period_to' => $cv->setDateAttribute($this->request->input("cvEducations.".$k.".period_to")),
                    'faculty' => $this->request->input("cvEducations.".$k.".faculty"),
                    // 'address' => $this->request->input("cvEducations.".$k.".address"),
                    'summary' => $this->request->input("cvEducations.".$k.".summary"),
                    'website' => $this->request->input("cvEducations.".$k.".website"),
                    'cv_id' => $cv->id,
                ]);
            }
        }
        return $cvEducations;
    }
}
