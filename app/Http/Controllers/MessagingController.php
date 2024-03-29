<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\MessagingNotification;
use App\Group;
use App\UserGroup;
use App\NewUser;
use App\Services\NotificationService;
use Session;

class MessagingController extends Controller
{
    public function index()
    {

    }
    public function sendToGroup($id)
    {
        $group = Group::where('id',$id)->first();
        return view('MessagingNotification.create',compact('group'));
    }

    public function groupMessageCreate(Request $request)
    {
        $message = $request->message;

        $group = Group::where('id',$request->group_id)->first();

        $groupUsers = UserGroup::where('group_id',$group->id)->get();

        for($i=0 ; $i < count($groupUsers) ; $i++)
        {
            $oneUser = NewUser::where('id',$groupUsers[$i]->new_user_id)->first();

            $PlayerId = $oneUser->playerID;

            $newNotification = new NotificationService();
            $newNotification->sendToOne($message,$PlayerId);
            $notificationMessage              = new MessagingNotification();
            $notificationMessage->new_user_id = $oneUser->id;
            $notificationMessage->Message     = $message;
            $notificationMessage->save();
        }

        \Session::flash('success', 'well done! Message notification successfully sent to '.$group->name.' group!');
        return Redirect('/group');
    }

    public function sendToUsers()
    {
        return view('MessagingNotification.createUsers');
    }

    public function usersMessageCreate(Request $request)
    {
        $Users=explode(",",$request->Users);

        $message = $request->message;

        for($i=0 ; $i < count($Users) ; $i++)
        {
            $oneUser = NewUser::where('id',$Users[$i])->first();

            $PlayerId = $oneUser->playerID;

            $newNotification = new NotificationService();
            $newNotification->sendToOne($message,$PlayerId);

            $notificationMessage              = new MessagingNotification();
            $notificationMessage->new_user_id = $oneUser->id;
            $notificationMessage->Message     = $message;
            $notificationMessage->save();
        }

        \Session::flash('success', 'well done! Message notification successfully sent');
        return Redirect('/msgUsers');
    }

    public function resendNotification(Request $request)
    {
        $message = $request->Message;

        if ($request->userId != NULL) {
            $Users = explode(",", $request->userId);

            for ($i = 0; $i < count($Users); $i++) {
                $oneUser = NewUser::where('id', $Users[$i])->first();

                $PlayerId = $oneUser->playerID;

                $newNotification = new NotificationService();
                $newNotification->sendToOne($message, $PlayerId);

                $notificationMessage = new MessagingNotification();
                $notificationMessage->new_user_id = $oneUser->id;
                $notificationMessage->Message = $message;
                $notificationMessage->save();
            }

            \Session::flash('success', 'well done! Message notification successfully sent');
            return Redirect('/messageNotification');
        } else if ($request->group != NULL) {
            $group = Group::where('id', $request->group)->first();

            $groupUsers = UserGroup::where('group_id', $group->id)->get();

            for ($i = 0; $i < count($groupUsers); $i++) {
                $oneUser = NewUser::where('id', $groupUsers[$i]->new_user_id)->first();

                $PlayerId = $oneUser->playerID;

                $newNotification = new NotificationService();
                $newNotification->sendToOne($message, $PlayerId);

                $notificationMessage = new MessagingNotification();
                $notificationMessage->new_user_id = $oneUser->id;
                $notificationMessage->Message = $message;
                $notificationMessage->save();
            }
            \Session::flash('success', 'well done! Message notification successfully sent to ' . $group->name . ' group!');
            return Redirect('/messageNotification');
        }
    }
    public function AllmessageNotification()
    {
        $notifications = \DB::table('messaging_notifications')
            ->join('new_users', 'messaging_notifications.new_user_id', '=', 'new_users.id')
            ->select(
                \DB::raw("
                
                                           messaging_notifications.id,
                                           messaging_notifications.message as message,
                                           new_users.name as name,
                                           new_users.surname as surname,
                                           messaging_notifications.created_at
                                         
                                          ")

            )
            ->orderBy('id', 'DESC')
            ->get();

        return view('MessagingNotification.messageNotification', compact('notifications'));

    }

    public function resendMessageNotification($id)
    {
        $notification = MessagingNotification::where('id', $id)->first();
        return view('MessagingNotification.resendMessageNotification', compact('notification'));
    }
    public function sendByRadius(Request $request)
    {
        $lng = $request->lng;
        $lat = $request->lat;
        $radius = $request->radius;
        $message = $request->message;
        $address = $request->address;

        if($radius==0)
        {
            $Users = \DB::table('new_users')
                ->select(
                    \DB::raw(
                        "
                    id,
                    playerID,
                    name,
                    surname,
                    gps_lat,
                    gps_long,
                    ( 3959 * acos ( cos ( radians(" . $lat . ") ) * cos( radians( gps_lat ) ) * cos( radians( gps_long ) - radians(" . $lng . ") ) + sin ( radians(" . $lat . ") ) * sin( radians( gps_lat ) ) ) ) AS distance
                    "
                    )
                )
                ->get();

            for ($i = 0; $i < count($Users); $i++) {

                $PlayerId = $Users[$i]->playerID;

                $newNotification = new NotificationService();
                $newNotification->sendToOne($message, $PlayerId);

                $notificationMessage = new MessagingNotification();
                $notificationMessage->new_user_id = $Users[$i]->id;
                $notificationMessage->Message = $message;
                $notificationMessage->save();
            }
            \Session::flash('success', 'well done! Message notification successfully sent to all '.count($Users).' users!');
            return Redirect('/messageNotification');
        }
        else {

            $Users = \DB::table('new_users')
                ->select(
                    \DB::raw(
                        "
                    id,
                    playerID,
                    name,
                    surname,
                    gps_lat,
                    gps_long,
                    ( 3959 * acos ( cos ( radians(" . $lat . ") ) * cos( radians( gps_lat ) ) * cos( radians( gps_long ) - radians(" . $lng . ") ) + sin ( radians(" . $lat . ") ) * sin( radians( gps_lat ) ) ) ) AS distance
                    "
                    )
                )
                ->having('distance', '<', $radius)
                ->get();

            for ($i = 0; $i < count($Users); $i++) {

                $PlayerId = $Users[$i]->playerID;

                $newNotification = new NotificationService();
                $newNotification->sendToOne($message, $PlayerId);

                $notificationMessage = new MessagingNotification();
                $notificationMessage->new_user_id = $Users[$i]->id;
                $notificationMessage->Message = $message;
                $notificationMessage->save();
            }
            if(count($Users)==0)
            {
                \Session::flash('fail','Unsuccessful, There are '.count($Users) . ' users within ' . $radius . 'km radius of '.$address.'!');
                return Redirect('/messageNotification');
            }
            else {

                \Session::flash('success', 'well done! Message notification successfully sent to ' . count($Users) . ' users within ' . $radius . 'km radius of '.$address.'!');
                return Redirect('/messageNotification');
            }
        }

    }
}
