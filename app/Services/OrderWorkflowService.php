<?php

namespace App\Services;

use App\Models\User;
use App\Models\ContactInfo;
use App\Models\OrderWInspection;
use Carbon\Carbon;
use App\Models\PropertyInfo;
use Spatie\GoogleCalendar\Event;

class OrderWorkflowService
{
	 protected object $role;

     public function setOrderSchedule($order_id){
         $property_info = PropertyInfo::query()->where('order_id',$order_id)->select('search_address')->first();
         $contact_info = ContactInfo::query()->where('order_id',$order_id)->select('contact','contact_email')->first();
         $schedule = OrderWInspection::query()->where('order_id',$order_id)->first();
         $phone_numbers = implode(",",json_decode($contact_info->contact_email)->phone);
         $inspector = User::where('id',$schedule->inspector_id)->select('name','email','color_id')->first();

         $event = new Event;
         $event->name = $property_info->search_address . ' ' . $inspector->name  . ' (' . $contact_info->contact . ',' . $phone_numbers . ') ' . $schedule->note;
         $event->description = $schedule->note;
         $event->startDateTime = Carbon::parse($schedule->inspection_date_time);
         $event->endDateTime = Carbon::parse($schedule->inspection_date_time)->addMinute((int) $schedule->duration);
         $event->location = $property_info->search_address;
         $event->colorId = $inspector->color_id ?? 1;
         $event->description = $schedule->note;
         $event->addAttendee(['email' => $inspector->email ]);
         $newEvent = $event->save();

         $schedule->event_id = $newEvent->id;
         $schedule->save();
     }
}
