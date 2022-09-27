<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCvRequest;
use App\Http\Requests\UpdateCvRequest;
use App\Models\Cv;
use App\Models\Education;
use App\Models\WorkExperience;
use App\Services\EducationService;
use App\Services\WorkExperienceService;
use Illuminate\Support\Facades\Validator;
use F9Web\ApiResponseHelpers;
use Illuminate\Http\JsonResponse;

class CvController extends Controller
{
    // https://laravel-news.com/laravel-api-response-helpers
    use ApiResponseHelpers;

    /**
     * @var EducationService
     */
    protected $educationService;

    /**
     * @var WorkExperience
     */
    protected $workExperienceService;


    /**
     * UserController constructor.
     *
     * @param  EducationService  $educationService
     * @param  WorkExperience  $workExperienceService
     */
    public function __construct(EducationService $educationService, WorkExperienceService $workExperienceService)
    {
        $this->educationService = $educationService;
        $this->workExperienceService = $workExperienceService;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cvs = Cv::with(['education', 'workExperience'])->get();

        return $this->respondWithSuccess($cvs);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreCvRequest $request
     * @return
     */
    public function store(StoreCvRequest $request)
    {
        if(!$request->input('cv')) {
            return $this->respondNotFound();
        } else {
            return $this->tt($request->input('cv'));
        }

        // Strip tags, allow some:
        if($request->input('cv.about_me')) {
            $about_me = strip_tags($request->input('cv.about_me'),"<br><p><b><i>");
            $request->merge(['cv' => ['about_me' => $about_me]]);
        }
        if($request->input('cv.technology_experience')) {
            $technology_experience = strip_tags($request->input('cv.technology_experience'),"<br><p><b><i>");
            $request->merge(['cv' => ['technology_experience' => $technology_experience]]);
        }

        // Save data
        $cv = Cv::create([
            'title' => $request->input("cv.title"),
            'first_name' => $request->input("cv.first_name"),
            'surname' => $request->input("cv.surname"),
            'middle_name' => $request->input("cv.middle_name"),
            'date_of_birth' => $request->input("cv.date_of_birth"),
            'email' => $request->input("cv.email"),
            'phone' => $request->input("cv.phone"),
            'avatar' => $request->input("cv.avatar"),
            'address' => $request->input("cv.address"),
            'city' => $request->input("cv.city"),
            'district' => $request->input("cv.district"),
            'linkedin' => $request->input("cv.linkedin"),
            'skype' => $request->input("cv.skype"),
            'website' => $request->input("cv.website"),
            'about_me' => $request->input("cv.about_me"),
            'technology_experience' => $request->input("cv.technology_experience"),
        ]);

        // create Educations
        $this->educationService->create($request->get('cvEducations'), $cv);
        // create ExperienceService
        $this->workExperienceService->create($request->get("deletedWorkExperiences"), $cv);

        // Response
        return $this->respondWithSuccess();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateCvRequest $request
     * @param \App\Models\Cv $cv
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCvRequest $request, Cv $cv)
    {
        if(!$request->input('cv')) {
            return $this->respondNotFound();
        }

        // Strip tags from client ckeditor, allow some:
        if($request->input('cv.about_me')) {
            $about_me = strip_tags($request->input('cv.about_me'),"<br><p><b><i>");
            $request->merge(['cv' => ['about_me' => $about_me]]);
        }
        if($request->input('cv.technology_experience')) {
            $technology_experience = strip_tags($request->input('cv.technology_experience'),"<br><p><b><i>");
            $request->merge(['cv' => ['technology_experience' => $technology_experience]]);
        }

        // Save data
        $arrCv = [
            'title' => $request->input("cv.title"),
            'first_name' => $request->input("cv.first_name"),
            'surname' => $request->input("cv.surname"),
            'middle_name' => $request->input("cv.middle_name"),
            'date_of_birth' => $request->input("cv.date_of_birth") ? $request->input("cv.date_of_birth") : '',
            'email' => $request->input("cv.email"),
            'phone' => $request->input("cv.phone"),
            'avatar' => $request->input("cv.avatar"),
            'address' => $request->input("cv.address"),
            'city' => $request->input("cv.city"),
            'district' => $request->input("cv.district"),
            'linkedin' => $request->input("cv.linkedin"),
            'skype' => $request->input("cv.skype"),
            'website' => $request->input("cv.website"),
            'about_me' => $request->input("cv.about_me"),
            'technology_experience' => $request->input("cv.technology_experience"),
            'updated_at' => date("Y-m-d H:i:s", time())
        ];
        $arrCv = array_filter( $arrCv, 'strlen' );// "update on patch", remove empty values from arr
        Cv::where('id', $cv->id)->update($arrCv);

        // update Educations
        $this->educationService->update($request->get('cvEducations'), $cv);
        // update WorkExperience
        $this->workExperienceService->update($request->get("cvWorkExperiences"), $cv);

        // deletedEducations (child of cv update ui)
        $this->educationService->delete($request->input("deletedEducations"));
        // workExperienceService (child of cv update ui)
        $this->workExperienceService->delete($request->input("deletedWorkExperiences"));

        // Response
        return $this->respondWithSuccess();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Cv $cv
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cv $cv)
    {
        Education::where('cv_id', $cv->id)->delete();
        WorkExperience::where('cv_id', $cv->id)->delete();
        Cv::where('id', $cv->id)->delete();
        return $this->respondWithSuccess();
    }

    /**
     * Description: Test api $request->input('key.key');
     * Usage:       return $this->tt($request->input('key'));
     *
     * @param array|string $arrayOrString
     * @return JsonResponse|string
     */
    public function tt($arrayOrString)
    {
        if(is_string($arrayOrString)) {
            return $this->morphMessage($arrayOrString);
        } else {
            return $this->respondWithSuccess($arrayOrString);
        }
    }
}


