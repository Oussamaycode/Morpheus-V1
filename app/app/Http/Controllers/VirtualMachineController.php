<?php

namespace App\Http\Controllers;

use App\Models\VirtualMachine;
use App\Http\Requests\StoreVirtualMachineRequest;
use App\Http\Requests\UpdateVirtualMachineRequest;
use Illuminate\Support\Facades\Http;

class VirtualMachineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVirtualMachineRequest $request)
    {
            
        $response = Http::withoutVerifying()->withToken(env('VASTAI_API_KEY'))->get('https://console.vast.ai/api/v0/instances/');

        $instances = $response->json('instances');

        foreach ($instances as $instance) {
           

            $available = VirtualMachine::where('vast_instance_id', $instance['id'])->exists();
            if ($available) {
                continue;
            }

            $virtualMachine=VirtualMachine::create([
                'vast_instance_id' => $instance['id'],
                'plan_id'          => $request->plan_id,
                'public_ip'        => $instance['public_ipaddr'],
                'cpu'              => $instance['cpu_name'],
                'gpu'              => $instance['gpu_name'],
                'storage'          => $instance['disk_space'],
                'user_id'          => auth()->user()->id,
            ]);
        }

        return response()->json($virtualMachine,201);

    }

    /**
     * Display the specified resource.
     */
    public function show(VirtualMachine $virtualMachine)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVirtualMachineRequest $request, VirtualMachine $virtualMachine)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VirtualMachine $virtualMachine)
    {
        //
    }

   
}
