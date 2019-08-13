<?php

namespace App\Http\Controllers;


use App\Client;
use App\ClientSearch;
use App\User;
use App\UserData;
use App\Agent;
use Illuminate\Http\Request;


use Illuminate\Support\Facades\DB;

class SearchesController extends Controller
{

    public function showSearchPage(){
        if(auth()->user()){
            if(auth()->user()->admin){
                return view('admin.search');
            }
        }
        return redirect()->back();
    }


    public function searchFreelancers(Request $request){

        $searchArray = [] ;
        $userDatas   = [] ;
        // clear session
        session()->forget(['country','languages','jobTitle','city','available_hours','salary_hour','skills','primary_skills']);

        // jobTitle :
        if(isset($request->jobTitle)){
            // save filter in session :
            session()->put('jobTitle',$request->jobTitle);

            $jobTitleInput = $request->jobTitle ;
            $jobTitleArr   = explode(' ',$jobTitleInput);
            foreach ($jobTitleArr as $jobTitleWord){
                $searchArray [] = ['job_title','like','%'.$jobTitleWord.'%'] ;
            }
        }

        // languages :
        if(isset($request->language)){
            // save filter in session :
            session()->put('languages',$request->language);
            $languagesInput = $request->language ;
            // split by space or comma
            $languagesArr = preg_split('/[\ \n\,]+/', $languagesInput);
            foreach ($languagesArr as $language){
                if($language == 'and' || $language == 'or'){
                    continue;
                }
                $searchArray[] = ['languages','like','%'.$language.'%'];
            }
        }

        // country :
        if(isset($request->country)){
            // save filter in session :
            session()->put('country',$request->country);
            $searchArray[] = ['country','like','%'.$request->country.'%'];
        }

        // city :
        if(isset($request->city)){
            // save filter in session :
            session()->put('city',$request->city);
            $searchArray[] = ['city','like','%'.$request->city.'%'];
        }

        // available_hours :
        if(isset($request->available_hours)){
            // save filter in session :
            session()->put('available_hours',$request->available_hours);
            $searchArray[] = ['available_hours_per_week','>=',intval($request->available_hours)];
        }

        // salary_hour :
        if(isset($request->salary_hour)){
            // save filter in session :
            session()->put('salary_hour',$request->salary_hour);

            $searchArray[] = ['hourly_rate','<=',intval($request->salary_hour)];
            $searchArray[] = ['hourly_rate','!=',0];
        }

        // skills :
        if(isset($request->skills)){
            // save filter in session :
            session()->put('skills',$request->skills);

            $skillsInput = $request->skills ;
            // split by space or comma
            $skillsArr = preg_split('/[\ \n\,]+/', $skillsInput);
            foreach ($skillsArr as $skill){
                if($skill == 'and' || $skill == 'or'){
                    continue;
                }
                $searchArray[] = ['design_skills_checkbox','like','%'.$skill.'%'];
            }
        }

        // skills :
        if(isset($request->primary_skills)){
            // save filter in session :
            session()->put('primary_skills',$request->primary_skills);

            $primSkillsInput = $request->primary_skills ;
            // split by space or comma
            $primSkillsArr = preg_split('/[\ \n\,]+/', $primSkillsInput);
            foreach ($primSkillsArr as $skill){
                if($skill == 'and' || $skill == 'or'){
                    continue;
                }
                $searchArray[] = ['primarySkills','like','%'.$skill.'%'];
            }
        }

        // form the where array :

        $userDatas[] = UserData::where($searchArray)->get();

        $freelancers = $this->getFilteredFreelancers($userDatas);

        $dataForFreelancerCard = [] ;
        // make a freelancer array with only the needed data for vue js :
        $i=0;
        foreach ($freelancers as $freelancer){
            $dataForFreelancerCard[$i] =[
                'id'=>$freelancer->id,
                'photo'=>$freelancer->userData->photo,
                'firstName'=>$freelancer->firstName,
                'lastName'=>$freelancer->lastName,
                'username'=>$freelancer->username,
                'profession'=>$freelancer->profession,
                'design_skills_checkbox'=>$freelancer->userData->design_skills_checkbox,
                'salary'=>$freelancer->userData->salary,
                'availableHours'=>$freelancer->userData->availableHours,
            ];
            $i++;
        }

        return $dataForFreelancerCard;

        return view('admin.search',compact('freelancers'));
    }

    public function searchAgents(Request $request){

        $searchArray = [] ;
        $userDatas   = [] ;
        // clear session
        session()->forget(['country','languages','jobTitle','city','available_hours','salary_hour','skills','primary_skills']);

        // jobTitle :
        if(isset($request->jobTitle) && $request->jobTitle != ''){
            // save filter in session :
            session()->put('jobTitle',$request->jobTitle);

            $jobTitleInput = $request->jobTitle ;
            $jobTitleArr   = explode(' ',$jobTitleInput);
            foreach ($jobTitleArr as $jobTitleWord){
                $searchArray [] = ['user_datas.job_title','like','%'.$jobTitleWord.'%'] ;
            }
        }

        // languages :
        if(isset($request->language)){
            // save filter in session :
            session()->put('languages',$request->language);
            $languagesInput = $request->language ;
            // split by space or comma
            $languagesArr = preg_split('/[\ \n\,]+/', $languagesInput);
            foreach ($languagesArr as $language){
                if($language == 'and' || $language == 'or'){
                    continue;
                }
                $searchArray[] = ['user_datas.languages','like','%'.$language.'%'];
            }
        }

        // country :
        if(isset($request->country) && $request->country != ''){
            // save filter in session :
            session()->put('country',$request->country);
            $searchArray[] = ['user_datas.country','like','%'.$request->country.'%'];
        }

        // city :
        if(isset($request->city)){
            // save filter in session :
            session()->put('city',$request->city);
            $searchArray[] = ['user_datas.city','like','%'.$request->city.'%'];
        }

        // available_hours :
        if(isset($request->available_hours) && $request->available_hours != ''){
            // save filter in session :
            session()->put('available_hours',$request->available_hours);
            
            $availableHours = str_replace("+", "", $request->available_hours);
            $availableHours = explode(' - ', $availableHours);

            $searchArray[] = ['user_datas.available_hours_per_week','>=',intval($availableHours[0])];

            if (sizeof($availableHours) == 2) {
                $searchArray[] = ['user_datas.available_hours_per_week','<=',intval($availableHours[1])];
            }
        }

        // skills :
        if(isset($request->skills)){
            // save filter in session :
            session()->put('skills',$request->skills);

            $skillsInput = $request->skills ;
            // split by space or comma
            $skillsArr = preg_split('/[\ \n\,]+/', $skillsInput);
            foreach ($skillsArr as $skill){
                if($skill == 'and' || $skill == 'or'){
                    continue;
                }
                $searchArray[] = ['user_datas.design_skills_checkbox','like','%'.$skill.'%'];
            }
        }

        // skills :
        if(isset($request->primary_skills)){
            // save filter in session :
            session()->put('primary_skills',$request->primary_skills);

            $primSkillsInput = $request->primary_skills ;
            // split by space or comma
            $primSkillsArr = preg_split('/[\ \n\,]+/', $primSkillsInput);
            foreach ($primSkillsArr as $skill){
                if($skill == 'and' || $skill == 'or'){
                    continue;
                }
                $searchArray[] = ['user_datas.primary_skills','like','%'.$skill.'%'];
            }
        }

        // form the where array :

        if(isset($request->salary_hour) && $request->salary_hour != ''){
            // save filter in session :
            session()->put('salary_hour',$request->salary_hour);
            $salaryRates = str_replace("+", "", $request->salary_hour);

            $salaryRates = explode(' - ', $salaryRates);

            $searchArray[] = ['agents.hourly_rate', '>=', $salaryRates[0]];
            
            if (count($salaryRates) == 2) {
                $searchArray[] = ['agents.hourly_rate', '<=', $salaryRates[1]];                
            }
        }

        $result = DB::table('user_datas')
                    ->join('agents', 'user_datas.user_id', '=', 'agents.user_id')
                    ->select('user_datas.first_name', 'user_datas.last_name', 'user_datas.job_title',
                    'user_datas.available_hours_per_week', 'agents.hourly_rate', 'user_datas.user_id', 'user_datas.avatar')
                    ->where($searchArray)->get();

        $dataForFreelancerCard = [] ;
        // make a freelancer array with only the needed data for vue js :

        
        foreach ($result as $freelancer) {
            array_push($dataForFreelancerCard, [
                'id'=>$freelancer->user_id,
                'photo'=>$freelancer->avatar,
                'firstName'=>$freelancer->first_name,
                'lastName'=>$freelancer->last_name,
                'jobTitle'=>$freelancer->job_title,
                'salary'=>$freelancer->hourly_rate,
                'availableHours'=>$freelancer->available_hours_per_week,
            ]);
        }

        return $dataForFreelancerCard;
    }

    public function getFilteredFreelancers($userDatas){
        $freelancers = [] ;
        foreach ($userDatas as $userData){
            foreach ($userData as $data){
                $freelancer = User::where('id',$data->user_id)->first();
                if(empty($freelancer)){
                    // delete user data if there is no user related to it !
                    $noUserData = UserData::where('user_id',$data->user_id)->first();
                    $noUserData->delete();
                }else{
                    $freelancers[] = $freelancer ;
                }
            }
        }

        return array_unique($freelancers);
    }

    public function saveSearch(Request $request){

        $client = Client::where('email',$request->client_email)->first();
        // make a new search :
        $search = new ClientSearch;
        $search->freelancers_id = implode(',',$request->freelancers_id);
        $search->client_id = $client->id;
        $search->name = $request->search_name;
        $search->save();
        return ['search_id'=> $search->id];
    }

    public function deleteSearch(Request $request){
        $search = ClientSearch::where('id',$request->search_id)->first();
        $search->delete();
        return ['status'=>'ok'];
    }

    public function deleteSearchFreelancer(Request $request){

        $search = ClientSearch::where('id',$request->search_id)->first();
        // remove freelancer id from the search freelancers_id
        $freelancer_id = $request->freelancer_id ;

        $freelancers_idArr = explode(',',$search->freelancers_id );
        // remove the not needed freelancer :
        if (($key = array_search($freelancer_id, $freelancers_idArr)) !== false) {
            unset($freelancers_idArr[$key]);
        }

        $search->freelancers_id = implode(',',$freelancers_idArr);
        $search->save();

        return ['status'=>'ok'];
    }


}