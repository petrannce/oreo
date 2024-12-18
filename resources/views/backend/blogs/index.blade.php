@extends('layouts.backend.header')

@section('content')

<section class="content">
    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-5 col-sm-12">
                <h2>Blogs
                    <small class="text-muted">Welcome to Oreo</small>
                </h2>
            </div>
            <div class="col-lg-5 col-md-7 col-sm-12">
                <ul class="breadcrumb float-md-right">
                    <li class="breadcrumb-item"><a href="{{route('admin')}}"><i class="zmdi zmdi-home"></i> Oreo</a></li>
                    <li class="breadcrumb-item"><a href="{{route('blogs')}}">Blogs</a></li>
                    <li class="breadcrumb-item active">Blogs</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>All Blogs</strong> </h2>
                        <ul class="header-dropdown">
                            <li class="remove">
                                <a class="btn btn-primary btn-lg" href="{{route('blogs.create')}}" role="button">Create Blog</a>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                <thead>
                                    <tr>
                                        <th>*</th>
                                        <th>Bill date</th>
                                        <th>Patient</th>
                                        <th>Doctor</th>
                                        <th>Charges</th>
                                        <th>Tax</th>
                                        <th>Discount</th>
                                        <th>Total</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>21</td>
                                        <td>02/21/2017</td>
                                        <td>Christina Thomas</td>
                                        <td>Juan Freeman</td>
                                        <td>102</td>
                                        <td>10</td>
                                        <td>10%</td>
                                        <td>210</td>
                                        <td>
                                            <button class="btn btn-icon btn-neutral btn-icon-mini"><i
                                                    class="zmdi zmdi-edit"></i></button>
                                            <button class="btn btn-icon btn-neutral btn-icon-mini"><i
                                                    class="zmdi zmdi-delete"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>17</td>
                                        <td>02/21/2017</td>
                                        <td>Christina Thomas</td>
                                        <td>Juan Freeman</td>
                                        <td>102</td>
                                        <td>10</td>
                                        <td>10%</td>
                                        <td>210</td>
                                        <td>
                                            <button class="btn btn-icon btn-neutral btn-icon-mini"><i
                                                    class="zmdi zmdi-edit"></i></button>
                                            <button class="btn btn-icon btn-neutral btn-icon-mini"><i
                                                    class="zmdi zmdi-delete"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>16</td>
                                        <td>02/21/2017</td>
                                        <td>Christina Thomas</td>
                                        <td>Juan Freeman</td>
                                        <td>102</td>
                                        <td>10</td>
                                        <td>10%</td>
                                        <td>210</td>
                                        <td>
                                            <button class="btn btn-icon btn-neutral btn-icon-mini"><i
                                                    class="zmdi zmdi-edit"></i></button>
                                            <button class="btn btn-icon btn-neutral btn-icon-mini"><i
                                                    class="zmdi zmdi-delete"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>15</td>
                                        <td>02/21/2017</td>
                                        <td>Christina Thomas</td>
                                        <td>Juan Freeman</td>
                                        <td>102</td>
                                        <td>10</td>
                                        <td>10%</td>
                                        <td>210</td>
                                        <td>
                                            <button class="btn btn-icon btn-neutral btn-icon-mini"><i
                                                    class="zmdi zmdi-edit"></i></button>
                                            <button class="btn btn-icon btn-neutral btn-icon-mini"><i
                                                    class="zmdi zmdi-delete"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection