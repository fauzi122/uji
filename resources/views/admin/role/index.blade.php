@extends('layouts.dosen.main')

@section('content')

<div class="page-wrapper">
    <!-- ============================================================== -->
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <div class="container-fluid">
        
        <div class="row">
            <div class="col-12">
                <div class="table-container">
                    <div class="t-header">
                        
                         @can('roles.create') 
   <a href="{{url('/role/create') }}" class="" style="padding-top: 10px;"><i class="icon-plus"></i></a>
   @endcan 
    List Role
                                       
                                    </div>
                        <div class="table-responsive">
                            <table id="copy-print-csv" class="table custom-table">
                                <thead>
                                <tr>
                                    <th scope="col" style="text-align: center;width: 6%">NO.</th>
                                    <th scope="col" style="width: 15%">NAMA ROLE</th>
                                    <th scope="col">PERMISSIONS</th>
                                    <th scope="col" style="width: 15%;text-align: center">AKSI</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($roles as $no => $role)
                                    <tr>
                                        <th scope="row" style="text-align: center">{{ ++$no }}</th>
                                        <td>{{ $role->name }}</td>
                                        <td>
                                            @foreach($role->getPermissionNames() as $permission)
                                                <button class="btn btn-sm btn-info mb-1 mt-1 mr-1">{{ $permission }}</button>
                                            @endforeach
                                        </td>
                                        <td class="text-center">
                                             @can('roles.edit') 
                                                <a href="/role/edit/{{ $role->id }}" class="btn btn-sm btn-primary">
                                                    <i class="icon-pencil"></i>
                                                </a>
                                                @endcan 
                                                @can('roles.delete') 
                                                <button onClick="Delete(this.id)" class="btn btn-sm btn-danger" id="{{ $role->id }}">
                                                    <i class="icon-trash"></i>
                                                </button>
                                             @endcan 
{{--                                              
                                            @can('roles.delete')
                                                <button onClick="Delete(this.id)" class="btn btn-sm btn-danger" id="{{ $role->id }}">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            @endcan  --}}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div style="text-align: center">
                                {{--  {{$roles->links("vendor.pagination.bootstrap-4")}}  --}}
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    </section>
    

  
    @endsection