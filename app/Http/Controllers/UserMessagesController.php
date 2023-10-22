<?php

namespace App\Http\Controllers;

use App\Http\Traits\Notify;
use App\Models\ChatThread;
use App\Models\Job;
use App\Models\UserMessage;
use Illuminate\Http\Request;
use App\Models\DeviceToken;
use App\Libs\Notification;
use App\Models\User;
use App\Models\UserNotification;
use App\Models\Violation;
use Illuminate\Support\Facades\DB;

class UserMessagesController extends Controller
{
    use Notify;
    public function messages()
    {
        return view('content.messages.index');
    }

    public function sendInquiry(Request $request) {
        $chat = ChatThread::where('job_id', $request->job_id)->where(function ($q) {
            $q->where('participant_id', auth()->id());
            $q->orWhere('initiated_by', auth()->id());
        })->first();

        if (!$chat) {
            $job_creator = Job::find($request->job_id)->user_id;

            $chat = new ChatThread();
            $chat->job_id = $request->job_id;
            $chat->initiated_by = auth()->id();
            $chat->participant_id = $job_creator;
            $chat->last_message_at = now();
            $chat->save();
        }

        Job::createMessage($request->job_id, auth()->id(), 'received');

        $message = UserMessage::create([
            'chat_id' => $chat->id,
            'source_id' => auth()->id(),
            'message' => $request->message,
            'is_seen' => false
        ]);

        $str = $request->message;
        // $re = '/\(?\d{3}\)?[\s-]?\d{3}[\s-]\d{4}/';
        $phone_pattern = '/\+?\d{1,4}?[-.\s]?\(?\d{1,3}?\)?[-.\s]?\d{1,4}[-.\s]?\d{1,4}[-.\s]?\d{1,9}/';
        $match_phone = preg_match_all($phone_pattern, $str, $phone_matches);

        // Extract email addresses from a string
        $email_pattern = '/\\S+@\\S+\\.\\S+/';
        $match_email = preg_match_all($email_pattern, $str, $email_matches);

        if($match_phone > 0 && isset($phone_matches) && count($phone_matches[0]) > 0) {
            foreach ($phone_matches[0] as $key => $matched_string) {
                Violation::createViolation($request->job_id, auth()->id(), $message->id, $chat->id, $matched_string);
                $eData['job_title'] = Job::find($request->job_id)->title;
                $eData['user_data'] = User::find(auth()->id());
                $this->notify('violation_attempt', $eData);
            }
        }

        if($match_email > 0 && isset($email_matches) && count($email_matches[0]) > 0) {
            foreach ($email_matches[0] as $key => $matched_string) {
                Violation::createViolation($request->job_id, auth()->id(), $message->id, $chat->id, $matched_string);
                $eData['job_title'] = Job::find($request->job_id)->title;
                $eData['user_data'] = User::find(auth()->id());
                $this->notify('violation_attempt', $eData);
            }
        }

        $chat->update([
            'last_message_at' => now()
        ]);

        // notify other party
        Notification::send(auth()->id() == $chat->initiated_by ? $chat->receiver : $chat->sender, [
            'type' => 'message',
            'message' => $message
        ]);

        $receiver = (auth()->id() == $chat->initiated_by) ? $chat->receiver : $chat->sender;
        $sender = (auth()->id() != $chat->initiated_by) ? $chat->receiver : $chat->sender;

        $eData['sender_data'] = $sender;
        $eData['job_title'] = Job::find($request->job_id)->title;
        $eData['user_data'] = $receiver;
        $this->notify('new_message', $eData);

        return $this->sendResponse([], 'Message sent successfully');
    }

    public function contactStaff (Request $request) {
        $data = $request->all();

        $chat = ChatThread::where('job_id', $data['job_id'])->where(function ($q) use ($data) {
            $q->where('participant_id', $data['user_id']);
            $q->orWhere('initiated_by', $data['user_id']);
        })->first();

        if (!$chat) {
            $chat = new ChatThread();
            $chat->job_id = $request->job_id;
            $chat->initiated_by = auth()->id();
            $chat->participant_id = $request->user_id;
            $chat->last_message_at = now();
            $chat->save();
        }

        Job::createMessage($request->job_id, $chat->participant_id, 'invited');

        $message = UserMessage::create([
            'chat_id' => $chat->id,
            'source_id' => auth()->id(),
            'message' => $request->message,
            'is_seen' => false
        ]);

        $str = $request->message;
        // $re = '/\(?\d{3}\)?[\s-]?\d{3}[\s-]\d{4}/';
        $phone_pattern = '/\+?\d{1,4}?[-.\s]?\(?\d{1,3}?\)?[-.\s]?\d{1,4}[-.\s]?\d{1,4}[-.\s]?\d{1,9}/';
        $match_phone = preg_match_all($phone_pattern, $str, $phone_matches);

        // Extract email addresses from a string
        $email_pattern = '/\\S+@\\S+\\.\\S+/';
        $match_email = preg_match_all($email_pattern, $str, $email_matches);

        if($match_phone > 0 && isset($phone_matches) && count($phone_matches[0]) > 0) {
            foreach ($phone_matches[0] as $key => $matched_string) {
                Violation::createViolation($request->job_id, auth()->id(), $message->id, $chat->id, $matched_string);
                $eData['job_title'] = Job::find($request->job_id)->title;
                $eData['user_data'] = User::find(auth()->id());
                $this->notify('violation_attempt', $eData);
            }
        }

        if($match_email > 0 && isset($email_matches) && count($email_matches[0]) > 0) {
            foreach ($email_matches[0] as $key => $matched_string) {
                Violation::createViolation($request->job_id, auth()->id(), $message->id, $chat->id, $matched_string);
                $eData['job_title'] = Job::find($request->job_id)->title;
                $eData['user_data'] = User::find(auth()->id());
                $this->notify('violation_attempt', $eData);
            }
        }

        $chat->update([
            'last_message_at' => now()
        ]);

        // notify other party
        Notification::send(auth()->id() == $chat->initiated_by ? $chat->receiver : $chat->sender, [
            'type' => 'message',
            'message' => $message
        ]);

        return $this->sendResponse([], 'Message sent successfully');
    }

    public function sendMessage(Request $request) {
        $data = $request->all();

        if (isset($data['job_id'])) {
            $data['chat'] = ChatThread::where('job_id', $data['job_id'])->where(function ($q) use ($data) {
                $q->where('participant_id', $data['user_id']);
                $q->orWhere('initiated_by', $data['user_id']);
            })->first();

            if (!$data['chat']) {
                $data['chat'] = new ChatThread();
                $data['chat']->job_id = $data['job_id'];
                $data['chat']->initiated_by = auth()->id();
                $data['chat']->participant_id = $data['user_id'];
                $data['chat']->last_message_at = now();
                $data['chat']->save();
            }
        }

        $message = UserMessage::create([
            'chat_id' => $request->chat_id ?? $data['chat']->id,
            'source_id' => auth()->id(),
            'message' => $request->message,
            'is_seen' => false
        ]);

        $str = $request->message;
        // $re = '/\(?\d{3}\)?[\s-]?\d{3}[\s-]\d{4}/';
        $phone_pattern = '/\+?\d{1,4}?[-.\s]?\(?\d{1,3}?\)?[-.\s]?\d{1,4}[-.\s]?\d{1,4}[-.\s]?\d{1,9}/';
        $match_phone = preg_match_all($phone_pattern, $str, $phone_matches);

        // Extract email addresses from a string
        $email_pattern = '/\\S+@\\S+\\.\\S+/';
        $match_email = preg_match_all($email_pattern, $str, $email_matches);

        
        $message->load('chat');

        $job_id = ChatThread::find($data['chat_id'])->job_id ?? null;

        if($match_phone > 0 && isset($phone_matches) && count($phone_matches[0]) > 0) {
            foreach ($phone_matches[0] as $key => $matched_string) {
                Violation::createViolation($job_id, auth()->id(), $message->id, $request->chat_id ?? $data['chat']->id, $matched_string);
                $eData['job_title'] = Job::find($job_id)->title;
                $eData['user_data'] = User::find(auth()->id());
                $this->notify('violation_attempt', $eData);
            }
        }

        if($match_email > 0 && isset($email_matches) && count($email_matches[0]) > 0) {
            foreach ($email_matches[0] as $key => $matched_string) {
                Violation::createViolation($job_id, auth()->id(), $message->id, $request->chat_id ?? $data['chat']->id, $matched_string);
                $eData['job_title'] = Job::find($job_id)->title;
                $eData['user_data'] = User::find(auth()->id());
                $this->notify('violation_attempt', $eData);
            }
        }


        $receiver = (auth()->id() == $message->chat->initiated_by) ? $message->chat->receiver : $message->chat->sender;
        $sender = (auth()->id() != $message->chat->initiated_by) ? $message->chat->receiver : $message->chat->sender;

        // notify other party
        Notification::send(auth()->id() == $message->chat->initiated_by ? $message->chat->receiver : $message->chat->sender, [
            'type' => 'message',
            'message' => $message
        ]);

        // dd($receiver, $sender);

        if($job_id){

            $eData['sender_data'] = $sender;
            $eData['job_title'] = Job::find($job_id)->title;
            $eData['user_data'] = $receiver;
            $this->notify('new_message', $eData);
        }

        return $this->sendResponse($message, '');
    }

    public function getMessages(Request $request) {
        if(isset($request->source_id) && $request->source_id){
            $chat = UserMessage::where([
                'chat_id' => $request->chat_id,
                'source_id' => $request->source_id
            ])
            ->orderBy('id')
            ->get(['id', 'message', 'source_id', 'created_at']);
        } else {
            $chat = UserMessage::where([
                'chat_id' => $request->chat_id,
            ])
            ->orderBy('id')
            ->get(['id', 'message', 'source_id', 'created_at']);
        }
        // $chat = UserMessage::where([
        //     'chat_id' => $request->chat_id
        // ])->orderBy('id')->get(['id', 'message', 'source_id', 'created_at']);

        return $this->sendResponse($chat, '');
    }

    public function getJobUserMessages(Request $request) {
        $data = $request->all();

        if (auth()->user()->hasRole('admin')) {
            $job = Job::find($data['job_id']);
            $data['user_id'] = $job->user_id;
        }

        $chat = ChatThread::where('job_id', $data['job_id'])->where(function ($q) use ($data) {
            $q->where('participant_id', $data['user_id']);
            $q->orWhere('initiated_by', $data['user_id']);
        })->first();

        if ($chat) {
            $messages = UserMessage::where([
                'chat_id' => $chat->id
            ])->orderBy('id')->get(['id', 'message', 'source_id', 'created_at']);

            return $this->sendResponse($messages, '');
        } else {
            return $this->sendResponse([], 'No messages found');
        }

    }

    public function getJobMessages(Request $request) {
        $data = $request->all();

        $chats = ChatThread::with(['sender:id,name,display_pic', 'receiver:id,name,display_pic', 'job:id,title,date,staff_category_id,user_id', 'job.staff_category:id,title', 'job.user:id,name'])->where('job_id', $data['job_id'])->get();

        return $this->sendResponse($chats, '');
    }

    public function getChats(Request $request) {
        $data = $request->all();
        
        if (isset($data['job_id'])) {
            // check chat with that job_id exists or not
            $chat_count = ChatThread::where(function($q) {
                $q->where('participant_id', auth()->id());
                $q->orWhere('initiated_by', auth()->id());
            })->where('job_id', $data['job_id'])->count();

            if ($chat_count == 0) {
                $job = Job::find($data['job_id']);

                ChatThread::create([
                    'job_id' => $data['job_id'],
                    'initiated_by' => auth()->id(),
                    'participant_id' => $job->user_id,
                    'last_message_at' => now()
                ]);
            }
        }

        $chats = ChatThread::with(['sender:id,name,display_pic', 'receiver:id,name,display_pic', 'job:id,title,date,staff_category_id,user_id', 'job.staff_category:id,title'])->where(function($q) {
            $q->where('participant_id', auth()->id());
            $q->orWhere('initiated_by', auth()->id());
        })->distinct('id')->orderBy('last_message_at', 'desc')->get([
            'id', 'initiated_by', 'job_id', 'participant_id', 'last_message_at'
        ]);

        foreach ($chats as $chat) {
            $chat->last_message = $chat->messages()->orderBy('id', 'desc')->first(['message', 'is_seen']);
        }

        return $this->sendResponse($chats, '');
    }
    
    public function chatDetail(Request $request) {
        
        $data = $request->all();

       
        $data['chat'] = ChatThread::where('id', $data['chat_id'])->with(['sender:id,name,display_pic', 'receiver:id,name,display_pic', 'job:id,title,date,staff_category_id,user_id', 'job.staff_category:id,title'])
        ->distinct('id')->orderBy('last_message_at', 'desc')->first([
            'id', 'initiated_by', 'job_id', 'participant_id', 'last_message_at'
        ]);

        $data['violations'] = Violation::where('chat_thread_id', $data['chat_id'])->get();

        return $this->sendResponse($data, '');
    }

    public function saveFcmToken(Request $request) {
        if (!auth()->check()) {
            return $this->sendResponse([]);
        }

        $user_has_token = DeviceToken::where([
            'fcm_token' => $request->token,
            'user_id' => auth()->id()
        ])->count();

        if ($user_has_token) {
            return $this->sendResponse([]);
        } else {
            DeviceToken::where('fcm_token', $request->token)->delete();

            DeviceToken::create([
                'user_id' => auth()->id(),
                'fcm_token' => $request->token
            ]);

            return $this->sendResponse([]);
        }
    }

    public function getMessageCount() {
        $id = auth()->id();

        // $count = DB::table("SELECT SUM(total) FROM message_count WHERE initiated_by = {$id} OR participant_id = {$id}");
        $count = DB::table("message_count")->where(function ($q) use ($id) {
            $q->where('initiated_by', $id);
            $q->orWhere('participant_id', $id);
        })->selectRaw(DB::raw("SUM(total) as count"))->first();

        $notification = [
            'data' => UserNotification::where('user_id', $id)
            ->with(['user', 'source'])
            ->take(5)
            ->orderBy('id', 'DESC')
            ->get(),
            'count' => UserNotification::where('user_id', $id)->count()
        ];
        
        return $this->sendResponse([
            'notification' => $notification, 'count' => $count->count
        ], '');
    }
    public function deleteChat(Request $request)
    {
        UserMessage::where('chat_id',$request->chat_id)->delete();
        ChatThread::where('id', $request->chat_id)->delete();

        return $this->sendResponse([], 'Chat has been deleted!');
    }
}