<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'subject' => 'required|string|max:200',
            'message' => 'required|string',
        ]);
        
        // Here you would typically send an email
        // For now, we'll just return with a success message
        
        return back()->with('success', 'Thank you for your message! We will get back to you soon.');
    }
}