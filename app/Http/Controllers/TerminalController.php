<?php

namespace App\Http\Controllers;

use App\Client\Exception\NotFoundValueException;
use App\Http\Requests\DeleteTerminalRequest;
use App\Service\TerminalService;
use Facade\FlareClient\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

class TerminalController extends Controller
{
     use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
     
     private TerminalService $terminalService;

    /**
    * コンストラクタ
    */
    public function __construct()
    {
        $this->terminalService = TerminalService::getInstance();
    }

    public function showList()
    {
        return View('terminal_list_layout')
           ->with('terminalDataArray', $this->terminalService->getMyTerminalArray($this->getOauthToken()));
    }

   public function deleteTerminal(DeleteTerminalRequest $request)
    {
        try{
            $this->terminalService->deleteTerminal($this->getOauthToken(), $request->terminalName);
            return;
        }
        catch(NotFoundValueException $e){
            return;
        }
    }
}