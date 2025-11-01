<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class HelpController extends Controller
{
    public function index()
    {
        return view('help.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'gmail' => 'required|email',
            'pesan' => 'required|string|min:10',
            'upload_file' => 'nullable|file|mimes:jpg,jpeg,png,gif,mp4,mov,avi,wmv|max:10240', // Max 10MB
        ], [
            'upload_file.max' => 'File yang diupload terlalu besar. Maksimal ukuran file adalah 10MB.',
            'upload_file.mimes' => 'Format file tidak didukung. Hanya file JPG, PNG, GIF, MP4, MOV, AVI, WMV yang diizinkan.',
            'gmail.required' => 'Email wajib diisi.',
            'gmail.email' => 'Format email tidak valid.',
            'pesan.required' => 'Pesan wajib diisi.',
            'pesan.min' => 'Pesan minimal 10 karakter.',
        ]);

        // Determine user role
        $role = 'guest';
        if (Auth::guard('web')->check()) {
            $role = 'user';
        } elseif (Auth::guard('seller')->check()) {
            $role = 'seller';
        }

        // Handle file upload
        $filePath = null;
        $fileType = null;
        $fileName = null;
        
        if ($request->hasFile('upload_file')) {
            $file = $request->file('upload_file');
            $fileName = $file->getClientOriginalName();
            $fileExtension = $file->getClientOriginalExtension();
            
            // Determine file type
            $imageExtensions = ['jpg', 'jpeg', 'png', 'gif'];
            $videoExtensions = ['mp4', 'mov', 'avi', 'wmv'];
            
            if (in_array(strtolower($fileExtension), $imageExtensions)) {
                $fileType = 'image';
            } elseif (in_array(strtolower($fileExtension), $videoExtensions)) {
                $fileType = 'video';
            }
            
            // Store file with unique name
            $uniqueName = time() . '_' . uniqid() . '.' . $fileExtension;
            $filePath = $file->storeAs('help-uploads', $uniqueName, 'public');
        }

        // Save comment
        $comment = Comment::create([
            'gmail' => $request->gmail,
            'role' => $role,
            'pesan' => $request->pesan,
            'file_path' => $filePath,
            'file_type' => $fileType,
            'file_name' => $fileName,
        ]);

        // Send email notification
        try {
            $emailBody = "Pesan bantuan baru dari {$role}:\n\n" .
                        "Email: {$request->gmail}\n" .
                        "Role: {$role}\n" .
                        "Pesan: {$request->pesan}\n";
            
            if ($filePath) {
                $emailBody .= "File terlampir: {$fileName} ({$fileType})\n";
                $emailBody .= "URL File: " . asset('storage/' . $filePath) . "\n";
            }
            
            $emailBody .= "\nWaktu: " . now()->format('d/m/Y H:i:s');

            Mail::raw(
                $emailBody,
                function ($message) use ($request, $role) {
                    $message->to('rifat.khaidir@gmail.com')
                           ->subject("Bantuan AMPUH - Pesan dari {$role}");
                }
            );
        } catch (\Exception $e) {
            // Log error but don't fail the request
            Log::error('Failed to send help email: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Pesan bantuan Anda telah dikirim. Kami akan merespon segera!');
    }
}