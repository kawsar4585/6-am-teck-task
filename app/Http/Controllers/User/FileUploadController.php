<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\BaseControllers\BackendController;
use App\Http\Requests\User\FileUploadRequest;
use App\Services\User\FileUploadService;

class FileUploadController extends BackendController
{
    protected $service;
    public function __construct(FileUploadService $service)
    {
        $this->service = $service;
        $this->addBreadcrumbs('Home', route('user.dashboard'), 'fa fa-home');
    }
    public function showForm()
    {
        $this->setPageTitle('File Upload');
        $this->setPageHeaderTitle('File Upload');
        $this->setActiveMenu('file-upload');
        $data = $this->service->getUserFiles();
        return $this->view('user.upload')->with($data);
    }
    public function upload(FileUploadRequest $request)
    {
        $this->service->upload($request);
        return redirect()->route('user.upload.form')->with('success', 'File uploaded and queued for processing.');
    }
}
