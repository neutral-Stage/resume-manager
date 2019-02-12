<?php
/**
 * Created by PhpStorm.
 * User: Ahmed
 * Date: 7/25/2018
 * Time: 6:39 PM
 */

namespace App\Http\Controllers;


use App\Campaign;
use App\Invoice;
use App\Shift;
use App\ShiftDay;
use Illuminate\Http\Request;

class ShiftsController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }


    public function addShiftToCamp(Request $request){
        if(isset($request->campaign_id)){
            $currCampaign = Campaign::where('id',$request->campaign_id)->first();
        }
        if(isset($request->invoiceID)){
            $currInvoice  = Invoice::where('id',$request->invoiceID)->first();
        }
        $request->validate([
            'start_time' => 'required',
            'end_time' => 'required',
            'days' => 'max:1500|required',
            'rate' => 'max:191',
            'service' => 'max:191',
        ]);

        if(isset($request->id)){
            // edit
            $shift = Shift::where('id',$request->id)->first();
        }else{
            // add
            $shift = new Shift;
            if(isset($currInvoice)){
                $shift->invoice_id = $currInvoice->id;
            }
            if(isset($currCampaign)){
                $shift->campaign_id = $currCampaign->id;
            }
        }

        $shift->start_time = $request->start_time;
        $shift->end_time  = $request->end_time;
        if(isset($request->rate)){
            $shift->rate  = $request->rate;
        }
        if(isset($request->service)){
            $shift->service  = $request->service;
        }
        if(isset($request->days)){
            $shift->days      = implode('|',$request->days);
        }

        $shift->save();

        return ['id'=>$shift->id];

    }

    public function deleteShift(Request $request){
        $shift = Shift::where('id',$request->shiftID);
        $shift->delete();
        return 'Shift has been deleted';
    }

    public function getShiftMembers(Request $request){
        $shiftID = $request->shiftID;
        return Shift::find($shiftID)->workers;
    }

    public function addWorkersToShift(Request $request){
        $shift = Shift::find($request->shiftID) ;
        if(empty($request->users)){
            // remove all freelancers from the shift.
            foreach ($shift->workers as $worker){
                $shift->workers()->detach($worker->id);
            }
        }else{
            foreach ($request->users as $user){
                // sync with the id's sent.
                $IDs[] = $user['id'];
            }
            $shift->workers()->sync($IDs);
        }
        return 'Workers Updated';
    }

}