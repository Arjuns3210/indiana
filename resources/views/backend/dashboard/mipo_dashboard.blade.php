@extends('backend.layouts.app')
@section('content')
    <div class="wrapper">
        <div class="main-panel">
            <div class="main-content">
                <div class="content-overlay"></div>
                <div class="content-wrapper">
                    <section id="minimal-statistics">
                        <div class="row">
                            <div class="col-12">
                                <h1 class="content-header">Welcome to Mipo Admin Panel</h1>
                                <hr style="border: none; border-bottom: 1px solid black;">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-12">
                                <div class="card">
                                    <div class="card-content" style="height:150px;">
                                        <div class="card-body">
                                            <div class="media">
                                                <div class="media-body text-left">
                                                    <h3 class="mb-1 success">{{ $totalMipoCount ?? 0 }}</h3>
                                                    <span>Total Mipo</span><br><br><br>
                                                </div>
                                                <div class="media-right align-self-center">
                                                    <i class="ft-users success font-large-2 float-right"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-12">
                                <div class="card">
                                    <div class="card-content" style="height:150px;">
                                        <div class="card-body">
                                            <div class="media">
                                                <div class="media-body text-left">
                                                    <h3 class="mb-1 success">{{ $todayMipoCount ?? 0 }}</h3>
                                                    <span>Mipos Added Today</span><br><br>
                                                </div>
                                                <div class="media-right align-self-center">
                                                    <i class="ft-user-plus success font-large-2 float-right"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            @if($assingMipoUserRecords->count())
                            <div class="col-xl-12 col-lg-12 col-12">
                                <div class="card shopping-cart">
                                    <div class="card-header pb-2">
                                        <h4 class="card-title mb-1">PO Needs Action </h4>
                                    </div>
                                    <div class="card-content">
                                        <div class="card-body p-0">
                                            <div class="table-responsive">
                                                <table class="table text-center m-0">
                                                    <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>PO No.</th>
                                                        <th>Region</th>
                                                        <th>Revision</th>
                                                        <th>PO Date</th>
                                                        <th>Category</th>
                                                        <th>Action</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @forelse ($assingMipoUserRecords as $key => $mipoData)
                                                        <tr>
                                                            <td>{{ $key + 1 }}</td>
                                                            <td>{{ $mipoData->po_no }}</td>
                                                            <td>{{ $mipoData->region->region_code ?? '' }}</td>
                                                            <td>{{ $mipoData->revision_no }}</td>
                                                            <td>{{ \Carbon\Carbon::parse($mipoData->po_recv_date)->format('d-m-Y') }}</td>
                                                            <td>{{ $mipoData->category->category_code ?? '-' }}</td>
                                                            <td>
                                                                 <a href="mipo_edit/{{$mipoData->id}}" class="btn btn-primary btn-sm src_data" title="Update"><i class="ft-arrow-right"></i></a>
                                                            </td>
                                                        </tr>

                                                    @empty
                                                        <tr>
                                                            <td colspan="7">No Records Found</td>
                                                        </tr>
                                                    @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            <div class="col-xl-12 col-lg-12 col-12">
                                <div class="card shopping-cart">
                                    <div class="card-header pb-2">
                                        <h4 class="card-title mb-1">Rejected PO List </h4>
                                    </div>
                                    <div class="card-content">
                                        <div class="card-body p-0">
                                            <div class="table-responsive">
                                                <table class="table text-center m-0">
                                                    <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>PO No.</th>
                                                        <th>Region</th>
                                                        <th>Revision</th>
                                                        <th>PO Date</th>
                                                        <th>Category</th>
                                                        <th>Rejected By</th>
                                                        <th>Rejected Date</th>
                                                        <th>Action</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @forelse ($rejectedMipoRecords as $key => $rejectedMipo)
                                                        <tr>
                                                            <td>{{ $key + 1 }}</td>
                                                            <td>{{ $rejectedMipo->po_no }}</td>
                                                            <td>{{ $rejectedMipo->region->region_code ?? '' }}</td>
                                                            <td>{{ $rejectedMipo->revision_no }}</td>
                                                            <td>{{ \Carbon\Carbon::parse($rejectedMipo->po_recv_date)->format('d-m-Y') }}</td>
                                                            <td>{{ $rejectedMipo->category->category_code ?? '-' }}</td>
                                                            <td>
                                                                {{ checkRejectMipoRoleName($rejectedMipo) }}
                                                            </td>
                                                            <td>
                                                                {{ getRejectedMipoLatestDate($rejectedMipo) }}
                                                            </td>
                                                            <td>
                                                                <a href="mipo_edit/{{$rejectedMipo->id}}" class="btn btn-primary btn-sm src_data" title="Update"><i class="ft-arrow-right"></i></a>
                                                            </td>
                                                        </tr>

                                                    @empty
                                                        <tr>
                                                            <td colspan="8">No Records Found</td>
                                                        </tr>
                                                    @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
@endsection
