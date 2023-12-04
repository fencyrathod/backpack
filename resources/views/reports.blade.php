@extends(backpack_view('blank'))



@section('header')
    <style>
        .select2 {
            width: 100% !important;

        }

        .select2-container--default .select2-selection--multiple {
            background-clip: padding-box;
            background-color: #fff;
            border: 1px solid rgba(0, 40, 100, 0.12);
            border-radius: 3px;
            color: #506690;
            display: block;
            font-size: 0.9375rem;
            font-weight: 400;
            height: 2.375rem;
            line-height: 1.6;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
            width: 100%;
            outline:0px;
        }
    </style>
   
    <section class="content-header">
        <div class="container-fluid mb-3">
            <h2>Report Jobs</h2>
            <form method="GET" action="{{ route('reports.jobs') }}" id="myform">

                <div style="border:1px solid rgba(0, 40, 100, 0.12);" class="p-3">




                    <div class="row">
                        <div class="col-2">
                            <select id="s_type" name="name" class="form-control">
                                <option selected disabled>Customer Name</option>
                                @foreach($Customer as $s1)
                                   
                                    <option value=@php echo $s1['Name']; @endphp
                                    
                                        @if($s1['Name']==$name) @php echo 'selected';@endphp @endif>@php echo $s1['Name']; @endphp</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-2">

                            <select id="s_type" name="type" class="form-control">
                                <option selected disabled>Service Type</option>
                                @foreach($service_type as $s1)
                                    <option value=@php echo $s1['name']; @endphp
                                    
                                        @if($s1['name']==$type) @php echo 'selected';@endphp @endif>@php echo $s1['name']; @endphp</option>
                                @endforeach
                            </select>

                        </div>
                        <div class="col-2">
                            <select id="s_type" name="dtype" class="form-control">
                                <option selected disabled>Device Type</option>
                                @foreach($device_type as $s1)
                                    <option value=@php echo $s1['name']; @endphp
                                    
                                        @if($s1['name']==$dtype) @php echo 'selected';@endphp @endif>@php echo $s1['name']; @endphp</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-2">
                            <select id="s_type" name="dbrand" class="form-control">
                                <option selected disabled>Device Brand</option>
                                @foreach($brand_type as $s1)
                                    <option value=@php echo $s1['name']; @endphp
                                    
                                        @if($s1['name']==$dbrand) @php echo 'selected';@endphp @endif>@php echo $s1['name']; @endphp</option>
                                @endforeach
                            </select>
                        </div>


                        <div class="col-3">
                            <select id="s_type" name="assign" class="form-control">
                                <option selected disabled>Assignee Name</option>
                                @foreach($user as $s1)
                                    <option value=@php echo $s1['name']; @endphp
                                    
                                        @if($s1['name']==$assign) @php echo 'selected';@endphp @endif>@php echo $s1['name']; @endphp</option>
                                @endforeach
                            </select>
                        </div> 
                    </div>


                    <br>




                    <div class="row">


                        <div class="col-md-4 col-xl-4">



                            <select name="Status[]" class="status" multiple>
                                <option value="Completed" @if (in_array('Completed', $selected)) selected @endif>Completed
                                </option>
                                <option value="Completed And Delivered" @if (in_array('Completed And Delivered', $selected)) selected @endif>
                                    Completed
                                    And Delivered</option>
                                <option value="Awaiting Approval" @if (in_array('Awaiting Approval', $selected)) selected @endif>Awaiting
                                    Approval</option>
                                <option value="In Process" @if (in_array('In Process', $selected)) selected @endif>In Process
                                </option>
                                <option value="Inward" @if (in_array('Inward', $selected)) selected @endif>Inward</option>
                                <option value="On Hold" @if (in_array('On Hold', $selected)) selected @endif>On Hold</option>
                                <option value="Outsourced" @if (in_array('Outsourced', $selected)) selected @endif>Outsourced
                                </option>
                                <option value="Cancelled" @if (in_array('Cancelled', $selected)) selected @endif>Cancelled
                                </option>
                                <option value="Cancelled And Delivered" @if (in_array(' Cancelled And Delivered', $selected)) selected @endif>
                                    Cancelled
                                    And Delivered</option>
                                <option value="Returned-Awaiting Approval"
                                    @if (in_array('Returned-Awaiting Approval', $selected)) selected @endif>
                                    Returned-Awaiting Approval</option>
                                <option value="Returned -In Process" @if (in_array(
                                        'Returned
                                                                                                                                                                                                                                                -In Process',
                                        $selected)) selected @endif>
                                    Returned
                                    -In Process</option>
                            </select>

                        </div>
                        <div class="col-md-4 col-xl-4">


                            <input type="date" class="form-control f_date" name="date" class="f_date"
                                value=@if ($date) {{ $date }} @endif>

                        </div>
                        <div class="col-md-4 col-xl-4">
                            <input type="hidden" name="s_date" class="start_date">
                            <input type="hidden" name="e_date" class="end_date">
            </form>
            <input type="text" name="daterange" class="form-control" class="r_date">

        </div>
        </div>


      

        <div class="row pt-5">
            <div class="col">
                @if ($total_payment)
                    <h4>Total Payment:{{ $total_payment }}</h4>
                @endif
            </div>
            <div class="col d-flex justify-content-end align-items-start">
                <button class="btn btn-success apply">Apply</button>&nbsp;
                <a href="{{ route('reports.jobs') }}" class="btn btn-primary">reset</a>
            </div>
        </div>
        </div>
        <table class="table" id="table">
            <thead>
                <tr>
                    <th>Customer Name</th>
                    <th>Source</th>
                    <th>Service Type</th>
                    <th>Job Type</th>
                    <th>Device Type</th>
                    <th>Device Brand</th>
                    <th>Device Model</th>
                    <th>Status</th>
                    <th>Assignee</th>

                </tr>
            </thead>
            <tbody id="myTable">

                @if (count($data) > 0)
                    @foreach ($data as $print)
                        <tr>

                            <td>{{ $print->customer_name }}</td>
                            <td>{{ $print->service_name }}</td>
                            <td>{{ $print->service_type }}</td>
                            <td>{{ $print->Job_Type }}</td>
                            <td>{{ $print->device_type }}</td>
                            <td>{{ $print->device_brand }}</td>
                            <td>{{ $print->Device_Model }}</td>
                            <td>{{ $print->Status }}</td>
                            <td>{{ $print->Assignee_name }}</td>


                        </tr>
                    @endforeach
                @else
                    <tr>

                        <td>No Data Found.</td>
                    </tr>
                @endif
            </tbody>
        </table>
        <div style="display: flex;
			justify-content: end;">
            {{ $data->links('pagination::bootstrap-4') }}
        </div>

        </div>


    </section>
@endsection
@section('content')
@endsection


@push('after_styles')
    <link href="{{ asset('css/bootstrap_card.css ') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


    @push('after_scripts')
        <script src="https://code.jquery.com/jquery-3.6.3.js"></script>

        <script src="{{ asset('js/charts.js') }}"></script>
        <script src="{{ asset('js/tooltip.js') }}"></script>
        <script src="{{ asset('js/chart_theme.js') }}"></script>

        <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>


        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


        <script>
            $(".status").select2({
                placeholder: "Select a status",
            });

            $(".apply").click(function() {

                $('#myform').submit();
            });

          


        </script>

        <script>
            deterangepicker();

            function deterangepicker() {
                $('input[name="daterange"]').daterangepicker({
                    opens: 'left'
                }, function(start, end, label) {
                    console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format(
                        'YYYY-MM-DD'));


                    $(".start_date").val(start.format('YYYY-MM-DD'));
                    $(".end_date").val(end.format('YYYY-MM-DD'));
                    $('#myform').submit();
                });
            }
        </script>
    @endpush

