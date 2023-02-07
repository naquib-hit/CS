<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\View\View;
use App\Http\Requests\{ FilterReportRequest, GenerateReportRequest };
//use Illuminate\Http\{JsonResponse, Request};

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        //
        return view('reports.index');
    }

    public function getByPeriods(FilterReportRequest $request): \Illuminate\Pagination\LengthAwarePaginator
    {
        // Rqeuest 
        $valid = $request->validated();
        $dateFrom = new \DateTime($valid['periode_from'].' 00:00:00');
        $dateTo = new \DateTime($valid['periode_to'].' 23:59:59');

        $data = Report::getFilteredReports($request->input('selected_by'), $dateFrom, $dateTo);

        $paging = $data->paginate(8);
        $paging->appends('filter_type', $valid['selected_by']);
        return $paging;
    }

    public function generate(GenerateReportRequest $request) 
    {
        $valid = $request->validated();
        // Needs For Generate Report File
        $fileType = $valid['file_type'];
        $itemType = $valid['selected_by'];
        $dateFrom = new \DateTime($valid['periode_from'].' 00:00:00');
        $dateTo = new \DateTime($valid['periode_to'].' 23:59:59');

        $report = Report::generateReport($fileType, $itemType, $dateFrom, $dateTo);
        return $report->download('report_'.$itemType.'_'.(new \DateTime)->format('YmdHis'));
    }
}
