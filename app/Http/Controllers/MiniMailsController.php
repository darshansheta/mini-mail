<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\MiniMailRequest;
use App\Models\MiniMail;
use App\Models\Attachment;
use App\Http\Resources\MiniMailResource;
use App\Http\Resources\MiniMailCollection;

class MiniMailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = MiniMail::query();
        $filters = $request->filters;

        if ($request->input('filters.from')) {
            $query->where('from', 'like', '%'.$request->filters['from'].'%');
        }
        if ($request->input('filters.to')) {
            $query->where('to', 'like', '%'.$request->filters['to'].'%');
        }
        if ($request->input('filters.subject')) {
            $query->where('subject', 'like', '%'.$request->filters['subject'].'%');
        }
        if ($request->input('filters.status')) {
            $query->where('status',$request->filters['status']);
        }
        if ($request->input('sort.sortBy')) {
            $query->orderBy($request->input('sort.sortBy'), $request->input('sort.sortOrder') ?? 'asc');
        }
        $query->withCount('attachments');
        return new MiniMailCollection($query->paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MiniMailRequest $request)
    {
        $miniMail = MiniMail::create([
            'from' => $request->from,
            'to' => $request->to,
            'subject' => $request->subject,
            'html_content' => $request->htmlContent,
            'status' => 'Posted',
        ]);

        foreach ($request->file('attachments') as $attachment) {
            $path = $attachment->store('attachment');
            Attachment::create([
                'mini_mail_id' => $miniMail->id,
                'name'=> $attachment->getClientOriginalName(),
                'uri' => $path,
            ]);
        }
        // $path = $request->file('attachments')->store('avatars');

        return new MiniMailResource($miniMail);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(MiniMail $miniMail)
    {
        $miniMail->load('attachments');

        return new MiniMailResource($miniMail);
    }

    public function recipients()
    {
        return MiniMail::pluck('to')->unique()->values();
    }

    public function recipientMails($fromMail)
    {
        return MiniMailResource::collection(
            MiniMail::where('to', $fromMail)->with('attachments')->get()
        );
    }
}
