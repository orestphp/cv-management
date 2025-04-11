<?php

namespace App\Services;

use App\Exceptions\GeneralException;
use App\Models\Cv;
use App\Models\User;
use App\Models\WorkExperience;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * Class WorkExperience.
 */
class WorkExperienceService extends BaseService
{
    public $request;

    /**
     * WorkExperience constructor.
     *
     * @param  WorkExperience  $workExperience
     * @param  Request  $request
     */
    public function __construct(WorkExperience $workExperience, Request $request)
    {
        $this->model = $workExperience;
        $this->request = $request;
    }


    /**
     * @param  array  $data
     * @param  Cv  $cv
     *
     * @return array
     */
    public function update(array $data, Cv $cv): array
    {
        $cvWorkExperiences = [];
        if($data && $cv) {
            foreach($data as $input) {
                if(isset($input['id']) && $input['id']) {
                    $arrWorkExperiences = [
                        'position' => $input["position"],
                        'company_name' => $input["company_name"],
                        'company_website' => $input["company_website"],
                        'period_from' => $cv->formatDate($input["period_from"]),
                        'period_to' => $cv->formatDate($input["period_to"]),
                        'summary' => $input["summary"],
                        'tech_stack' => $input["tech_stack"],
                        'updated_at' => date("Y-m-d H:i:s", time())
                    ];
                    $arrWorkExperiences = array_filter($arrWorkExperiences, 'strlen');// "update on patch", remove empty values from arr
                    $cvWorkExperiences[] = WorkExperience::where('id', $input['id'])->update($arrWorkExperiences);
                } else {
                    $cvWorkExperiences[] = WorkExperience::create([
                        'position' => $input["position"],
                        'company_name' => $input["company_name"],
                        'company_website' => $input["company_website"],
                        'period_from' => $cv->formatDate($input["period_from"]),
                        'period_to' => $cv->formatDate($input["period_to"]),
                        'summary' => $input["summary"],
                        'tech_stack' => $input["tech_stack"],
                        'cv_id' => $cv->id,
                    ]);
                }
            }
        }
        return $cvWorkExperiences;
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
            $aDeletedWorkExperiences = array_unique($data);
            // remove empty
            if (($key = array_search('', $aDeletedWorkExperiences)) !== false) {
                unset($aDeletedWorkExperiences[$key]);
            }
            // delete
            $deleted = WorkExperience::whereIn('id', $aDeletedWorkExperiences)->delete();
        }
    }


    /**
     * @param  array  $data
     *
     * @return array
     */
    public function create(array $data, $cv): array
    {
        $cvWorkExperiences = [];
        if($data && $cv && $this->request->get('cvWorkExperiences')) {
            foreach($data as $k => $v) {
                $cvWorkExperiences[] = WorkExperience::create([
                    'position' => $this->request->input("cvWorkExperiences.".$k.".position"),
                    'company_name' => $this->request->input("cvWorkExperiences.".$k.".company_name"),
                    'company_website' => $this->request->input("cvWorkExperiences.".$k.".company_website"),
                    'period_from' => $cv->formatDate($this->request->input("cvWorkExperiences.".$k.".period_from")),
                    'period_to' => $cv->formatDate($this->request->input("cvWorkExperiences.".$k.".period_to")),
                    'summary' => $this->request->input("cvWorkExperiences.".$k.".summary"),
                    'tech_stack' => $this->request->input("cvWorkExperiences.".$k.".tech_stack"),
                    'cv_id' => $cv->id,
                ]);
            }
        }
        return $cvWorkExperiences;
    }
}
