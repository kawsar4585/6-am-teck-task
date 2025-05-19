<?php

namespace App\Http\Controllers\BaseControllers;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    private string $pageTitle = 'Dashboards';

    protected function setPageTitle(string $pageTitle, bool $setPageHeader=true): void
    {
        $this->pageTitle = $pageTitle;
    }

    protected function view($view): \Illuminate\Contracts\View\View
    {
        return view($view)->with([
            'pageTitle' => $this->pageTitle
        ]);
    }

    protected function returnAjaxException($exception)
    {
        return response()->json([
            'status' => 500,
            'message' => $exception->getMessage(),
        ]);
    }

    protected function returnAjaxSuccess(array $data, $message='Success')
    {
        $data['status'] = 200;
        $data['message'] = $message;
        return response()->json($data);
    }

    protected function returnAjaxError($message, $status=400)
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
        ]);
    }
}
