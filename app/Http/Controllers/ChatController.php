<?php

namespace App\Http\Controllers;

use App\Events\MessageRead;
use App\Models\Message;
use App\Models\Student;
use App\Models\StudentParent;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\MessageSent;
use App\Events\UserStatusUpdated;

class ChatController extends Controller
{
    public function index(Request $request)
    {
        // $messages = Message::all();
        $user = Auth::user()->id;
        $students = Student::whereHas('User', function ($q) use ($user) {
            $q->where('users.id', '!=', $user);
        })->get();
        $parents = StudentParent::whereHas('User', function ($q) use ($user) {
            $q->where('users.id', '!=', $user);
        })->get();
        $admins = User::whereHas('roles', function ($q) {
            $q->where('roles.id', '2');
        })->where('id', '!=', $user)->get();
        return view('common.chat.index', compact('students', 'parents', 'admins'));
    }

    public function send(Request $request)
    {
        $validated = $request->validate([
            'message' => 'nullable|string|max:500', // Nullable if file is present
            'recipient_id' => 'required|exists:users,id',
            'attachment' => 'nullable|file|max:10240', // Max 10MB
        ]);

        if (empty($validated['message']) && !$request->hasFile('attachment')) {
            return response()->json(['success' => false, 'error' => 'Message or attachment required'], 422);
        }

        $attachmentData = [
            'attachment_path' => null,
            'attachment_original_name' => null,
            'attachment_mime' => null,
            'attachment_size' => null,
        ];

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $path = $file->store('chat_attachments', 'public');
            $attachmentData = [
                'attachment_path' => $path,
                'attachment_original_name' => $file->getClientOriginalName(),
                'attachment_mime' => $file->getClientMimeType(),
                'attachment_size' => $file->getSize(),
            ];
        }

        $message = Message::create([
            'user_id' => Auth::user()->id,
            'recipient_id' => $validated['recipient_id'],
            'message' => $validated['message'] ?? '',
            ...$attachmentData
        ]);

        broadcast(new MessageSent($message))->toOthers();

        return response()->json([
            'success' => true,
            'message' => $message,
        ]);
    }

    public function history($recipientId)
    {
        $userId = Auth::user()->id; // id user yang sedang login
        $chats = Message::where(function ($query) use ($userId, $recipientId) {
            $query->where('user_id', $userId)
                ->where('recipient_id', $recipientId);
        })
            ->orWhere(function ($query) use ($userId, $recipientId) {
                $query->where('user_id', $recipientId)
                    ->where('recipient_id', $userId);
            })
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function ($chat) {
                return [
                    'message' => $chat->message,
                    'time' => formatDate($chat->created_at, 'h:i A'),
                    'senderId' => $chat->user_id, // pengirim
                    'recipientId' => $chat->recipient_id,
                    'read' => $chat->read,
                    'createdAt' => formatDate($chat->created_at),
                    'attachment_url' => $chat->attachment_url,
                    'attachment_mime' => $chat->attachment_mime,
                    'attachment_original_name' => $chat->attachment_original_name,
                    'attachment_size' => $chat->attachment_size,
                ];
            });
        return response()->json($chats);
    }
    public function contacts(Request $request)
    {
        $user = Auth::user();
        $userId = $user->id;
        $query = $request->input('q');

        // Initialize collection
        $contacts = collect();

        // If search query is present, search ALL users (globally)
        if ($query) {
            $contacts = User::where('id', '!=', $userId)
                ->where(function ($q) use ($query) {
                    $q->where('name', 'like', "%{$query}%")
                        ->orWhere('username', 'like', "%{$query}%");
                })
                ->with(['roles', 'Student'])
                ->limit(20) // Limit results for performance
                ->get()
                ->map(function ($contact) use ($userId) {
                    // Count unread messages
                    $notifCount = Message::where('user_id', $contact->id)
                        ->where('recipient_id', $userId)
                        ->where('read', false)
                        ->count();

                    return [
                        'id' => $contact->id ?? null,
                        'status' => $contact->status ?? 'unknown',
                        'photo' => $contact->photo ?? 'default.png',
                        'name' => $contact->name ?? 'unknown',
                        'lastSeen' => isset($contact->updated_at) && $contact->updated_at == $contact->created_at
                            ? 'never'
                            : ($contact->updated_at->diffForHumans() ?? 'unknown'),
                        'role' => ($contact->role->code === 'student' && $contact->Student)
                            ? 'Santri ' . ($contact->Student->major ?? 'unknown')
                            : ($contact->role->name ?? 'unknown'),
                        'notifCount' => $notifCount,
                    ];
                });

            return response()->json($contacts);
        }

        // Existing logic for default view (No search query)
        // If role not admin/super_admin
        if (!$user->hasAnyRole(['administration_admin', 'super_admin'])) {
            // Get contacts from messages (recent chats)
            $messageContacts = Message::where(function ($q) use ($userId) {
                $q->where('user_id', $userId)
                    ->orWhere('recipient_id', $userId);
            })
                ->with(['Recipient.roles', 'User.roles', 'Recipient.Student', 'User.Student'])
                ->orderBy('created_at', 'desc') // Order by most recent
                ->get()
                ->map(function ($message) use ($userId) {
                    $contact = $message->user_id === $userId ? $message->Recipient : $message->User;

                    if ($contact) {
                        $notifCount = Message::where('user_id', $contact->id)
                            ->where('recipient_id', $userId)
                            ->where('read', false)
                            ->count();

                        return [
                            'id' => $contact->id ?? null,
                            'status' => $contact->status ?? 'unknown',
                            'photo' => $contact->photo ?? 'default.png',
                            'name' => $contact->name ?? 'unknown',
                            'lastSeen' => isset($contact->updated_at) && $contact->updated_at == $contact->created_at
                                ? 'never'
                                : ($contact->updated_at->diffForHumans() ?? 'unknown'),
                            'role' => ($contact->role->code === 'student' && $contact->Student)
                                ? 'Santri ' . ($contact->Student->major ?? 'unknown')
                                : ($contact->role->name ?? 'unknown'),
                            'notifCount' => $notifCount,
                        ];
                    }
                    return null;
                })
                ->filter()
                ->unique('id')
                ->values();

            // Get contacts with same role
            $sameRoleContacts = User::where('id', '!=', $userId)
                ->whereHas('roles', function ($q) use ($user) {
                    // Check if they share ANY common role
                    $q->whereIn('code', $user->roles->pluck('code'));
                })
                ->with(['roles', 'Student'])
                ->limit(50) // Limit to avoid loading thousands of students
                ->get()
                ->map(function ($contact) use ($userId) {
                    $notifCount = Message::where('user_id', $contact->id)
                        ->where('recipient_id', $userId)
                        ->where('read', false)
                        ->count();

                    return [
                        'id' => $contact->id ?? null,
                        'status' => $contact->status ?? 'unknown',
                        'photo' => $contact->photo ?? 'default.png',
                        'name' => $contact->name ?? 'unknown',
                        'lastSeen' => isset($contact->updated_at) && $contact->updated_at == $contact->created_at
                            ? 'never'
                            : ($contact->updated_at->diffForHumans() ?? 'unknown'),
                        'role' => ($contact->role->code === 'student' && $contact->Student)
                            ? 'Santri ' . ($contact->Student->major ?? 'unknown')
                            : ($contact->role->name ?? 'unknown'),
                        'notifCount' => $notifCount,
                    ];
                });

            // Merge: Recent chats first, then same role
            $contacts = $messageContacts->merge($sameRoleContacts)
                ->unique('id')
                ->values();
        } else {
            // Admin: Show all (limited) or just recent?
            // Existing logic showed ALL, which might be heavy. Let's keep it but maybe limit or rely on search?
            // For now, keeping existing behavior but maybe optimized.
            $contacts = User::where('id', '!=', $userId)
                ->with(['roles', 'Student'])
                ->limit(100) // Safety limit
                ->get()
                ->map(function ($contact) use ($userId) {
                    $notifCount = Message::where('user_id', $contact->id)
                        ->where('recipient_id', $userId)
                        ->where('read', false)
                        ->count();

                    return [
                        'id' => $contact->id ?? null,
                        'status' => $contact->status ?? 'unknown',
                        'photo' => $contact->photo ?? 'default.png',
                        'name' => $contact->name ?? 'unknown',
                        'lastSeen' => isset($contact->updated_at) && $contact->updated_at == $contact->created_at
                            ? 'never'
                            : ($contact->updated_at->diffForHumans() ?? 'unknown'),
                        'role' => ($contact->role->code === 'student' && $contact->Student)
                            ? 'Santri ' . ($contact->Student->major ?? 'unknown')
                            : ($contact->role->name ?? 'unknown'),
                        'notifCount' => $notifCount,
                    ];
                });
        }

        return response()->json($contacts);
    }

    public function read(Request $request)
    {
        $validated = $request->validate([
            'recipient_id' => 'required|exists:users,id',
        ]);

        $userId = Auth::user()->id;

        Message::where('recipient_id', $userId)
            ->where('user_id', $validated['recipient_id'])
            ->update(['read' => true]);

        broadcast(new MessageRead($validated['recipient_id']))->toOthers();

        return response()->json(['success' => true]);
    }


    public function setStatus(User $user, Request $request)
    {
        $validated = $request->validate([
            'status' => 'required|in:online,offline,away,busy'
        ]);

        $user->update(['status' => $validated['status']]);

        broadcast(new UserStatusUpdated($user))->toOthers();

        return response()->json(['success' => true]);
    }


    public function editUser(Request $request, User $user)
    {
        $validated = $request->validate([
            'bio' => 'nullable|string|max:120',
            'status' => 'nullable|in:online,offline,away,busy',
        ]);

        $user->update($validated);
        return redirect()->route('chat.index')->with('success', 'Berhasil update profile.');
    }
}
