<?php
namespace App\Http\Controllers;

use App\Events\CallOffer;
use App\Events\CallRejected;

use App\Events\CallAnswer;
use Illuminate\Http\Request;
use App\Events\CallIceCandidate;
use App\Events\CallEnded;

class CallController extends Controller
{
    public function sendOffer(Request $request)
    {
        // Use broadcast()->toOthers() to exclude the sender
        broadcast(new CallOffer($request->call_id, $request->offer))->toOthers();
        return response()->json(['status' => 'ok']);
    }

    public function sendAnswer(Request $request)
    {
        // Use broadcast()->toOthers() to exclude the sender
        broadcast(new CallAnswer($request->call_id, $request->answer))->toOthers();
        return response()->json(['status' => 'ok']);
    }

    public function sendIce(Request $request)
    {
        // Use broadcast()->toOthers() to exclude the sender
        broadcast(new CallIceCandidate($request->call_id, $request->candidate))->toOthers();
        return response()->json(['status' => 'ok']);
    }

    public function endCall(Request $request)
    {
        // Use broadcast()->toOthers() to only notify the other person
        // The person who ended the call already knows and will cleanup immediately
        broadcast(new CallEnded($request->call_id))->toOthers();
        return response()->json(['status' => 'ok']);
    }

    public function reject(Request $request)
    {
        $validated = $request->validate([
            'call_id' => 'required',
        ]);

        // Broadcast the rejection event to the original caller (client)
        broadcast(new CallRejected($validated['call_id']))->toOthers();

        return response()->json(['status' => 'rejected']);
    }
}
