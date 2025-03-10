@extends('layouts.app') <!-- app.blade file is extend for CSS-->
@section('content')
<style>

.badge{

  background-color:#880009;
  width:380px;
  height:50px;
  border-radius:22px;
  display: inline-block;
    padding: 0.25em 0.4em;
    font-size: 95%;
    font-weight: 700;
    line-height: 40px;
    text-align: center;
    white-space: nowrap;
    vertical-align: baseline;
    color:white;
}

</style>

<!-- Heading For this page -->
<div style="background-color: #FFF;border-top-left-radius: 0.5rem;border-top-right-radius: 0.5rem;padding: 20px 0 15px 20px;text-align: center;"><h2 class="text-2xl font-medium" style="font-weight:bold color:white;"><span class="badge" style="">Documents List</h2></div>
               
    <div class="card mt-2">
        <div class="card-header" style="display: none;">
        </div>
        <!-- Datatable and table column names -->
        <div class="col card-body table-responsive">
            <table class="document_data-table hover stripe" id="document_data-table"   style="width:100%">
                <thead>
                    <tr>
	                <th>S.No</th>                
                        <th>Document Name</th>
                        <th class="noExport">Download Documents</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
@endsection
