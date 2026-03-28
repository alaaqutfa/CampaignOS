<?php
namespace App\Http\Controllers;

use App\Mail\ContactMessage;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PageController extends Controller
{
    public function terms()
    {
        return view('pages.terms');
    }

    public function privacy()
    {
        return view('pages.privacy');
    }

    public function cookie()
    {
        return view('pages.cookie');
    }

    public function about()
    {
        return view('pages.about');
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function contactSubmit(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email',
            'message' => 'required|string',
        ]);

        // Store in database
        $contact = Contact::create([
            'name'    => $request->name,
            'email'   => $request->email,
            'message' => $request->message,
        ]);

        // Send email to admin (configure admin email in .env or config)
        Mail::to(config('mail.admin_email', 'alaaqutfa.work@gmail.com'))
            ->send(new ContactMessage($request->all()));

        return redirect()->route('pages.contact')
            ->with('success', 'Your message has been sent. We will get back to you soon.');
    }

    public function faq()
    {
        return view('pages.faq');
    }
}
