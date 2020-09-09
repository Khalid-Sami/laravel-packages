@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Plans</div>
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item clearfix">
                                <div class="pull-left">
                                    <table>
                                        @foreach ($invoices as $invoice)
                                            <tr>
                                                <td>{{ $invoice->date()->toFormattedDateString() }}</td>
                                                <td>{{ $invoice->total() }}</td>
                                                <td><a href="/user/invoice/{{ $invoice->id }}">Download</a></td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
